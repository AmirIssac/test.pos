<?php

namespace App\Http\Controllers;

use App\PermissionCategory;
use App\PermissionCustom;
use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    public function index(){
        $permissions = Permission::all();
        return view('dashboard.Permissions.permissions')->with('permissions',$permissions);
    }
    public function addPermissionForm(){
        $categories = PermissionCategory::all();
        return view('dashboard.Permissions.add')->with('categories',$categories);
    }
    public function store(Request $request){
        Permission::create(['name' => $request->permission,'guard_name'=>'web','category_id'=>$request->cat]);
        return back()->with('success','تم إضافة الصلاحية الجديدة بنجاح');
    }

    public function editUserDetailsForm($id){
        $user = User::find($id);
        $repository = Repository::find(Session::get('repo_id'));   // better than sending id by hidden input
        return view('dashboard.Repositories.edit_user_details')->with(['repository'=>$repository,'user'=>$user]);
    }

    public function changeUserPassword(Request $request,$id){
        $user = User::find($id);
        if($request->new_password == $request->confirm_password){
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);
        return back()->with('success','تم تغيير كلمة المرور بنجاح');
        }
        else{
            return back()->with('fail','تأكد من تطابق كلمة المرور في الحقلين من فضلك');
        }
    }
}
