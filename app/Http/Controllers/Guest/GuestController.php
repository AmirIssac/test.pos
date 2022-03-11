<?php

namespace App\Http\Controllers\Guest;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Repository;
use App\RepositoryCategory;
use App\Setting;
use App\Statistics;
use App\User;
use App\UserVerify;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    //

    public function enterEmailForm(){
        return view('guest.input_credentials_form');
    }

    public function storeCredentials(Request $request){
        // check if user exist before so we dont create user
        $check_if_exist =  User::where('email',$request->owneremail)->first();
        if($check_if_exist)
            return back()->with('fail','عذرا هذا الايميل موجود');
        $user = User::create([
            'name' => $request->ownerName,
            'email' => $request->owneremail,
            'password' => Hash::make($request->ownerpassword),
            'phone' => $request->ownerphone,
            'is_email_verified' => true ,  // auto verified
        ]);
        //$user->assignRole('مالك-مخزن');
        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->id, 
              'token' => $token
            ]);
        /*
        Mail::send('Mail.emailVerificationEmail', ['token' => $token], function($message) use($request){
              $message->to($request->owneremail);
              $message->subject('Email Verification Mail');
          });
          */
          Mail::to($request->owneremail)->send(new VerifyMail($token));

          Session::put('register_email',$request->owneremail);
          Session::put('owner_name',$request->ownerName);

          return redirect()->route('wait.for.verify')->withSuccess('تم ادخال البيانات بنجاح');
        //return redirect("/enter/credentials")->withSuccess('Great! You have Successfully loggedin');
    }

    public function waitForVerify(){
        $email = Session::get('register_email');
        $name = Session::get('owner_name');
        return view('guest.wait_for_email_verify')->with(['email'=>$email,'name'=>$name]);
    }

    public function verifyAccount($token)
    {
        $verifyUser = UserVerify::where('token', $token)->first();
  
        $message = 'Sorry your email cannot be identified.';
  
        if(!is_null($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "تهانينا تم تأكيد الايميل بنجاح , قم بتسجيل الدخول الآن";
            } else {
                $message = "الايميل مؤكد مسبقا يمكنك تسجيل الدخول بكل سهولة";
            }
        }
      return redirect()->route('login')->with('message', $message);
      //return redirect()->route('create.repository.form')->with('success',' تهانينا تم تأكيد الايميل بنجاح');
    }

    public function createRepositoryForm(){
        $categories = RepositoryCategory::all();
        $branches = Branch::all();
        // generate code for the new company   {{4 cells}}
        $branchesCount = Branch::all()->count();
        $branchesCount++;
        $code = str_pad($branchesCount, 4, '0', STR_PAD_LEFT);
        return view('guest.create_repository')->with(['categories'=>$categories,'branches'=>$branches,
                    'code' => $code,
        ]);
    }

    public function storeRepository(Request $request){
    
            $user = User::find(Auth::user()->id);
            $user->assignRole('مالك-مخزن');
             
            $branch = Branch::create([
                'company_code' => $request->company_code,
                'name' => $request->branch_name,
            ]);
            $repository = Repository::create([
                    'branch_id' => $branch->id,
                    'name' => $request->repositoryName,
                    'name_en' => $request->repositoryName_en,
                    'address' => $request->address,
                    'category_id'=>$request->category_id,
                ]);
        
        $repository->users()->attach($user->id); //pivot table insert

        // open statistic record for this repository  (one-to-one relatioship)
        Statistics::create([
            'repository_id' => $repository->id,
        ]);
        $end_at = now()->addMonth();
            Setting::create([
                'repository_id' => $repository->id,
                'end_of_experience' => $end_at,
            ]);
        if($repository->category->name == 'مخزن'){
            $repository->update([
                'min_payment' => 100,
            ]);
       }
        return redirect('/');
    }
}
