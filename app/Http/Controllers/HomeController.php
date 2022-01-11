<?php

namespace App\Http\Controllers;

use App\Repository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        //return view('home');
        // get dashboard view according to user Role
       /* $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
            return view('dashboard');
        else return view('dashboard');*/
    }

    public function selectRepository(){
        //Session::forget('repo_id');
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
        {   
            $repositories = Repository::whereYear('created_at',now()->year)->get();
            $users = User::whereYear('created_at',now()->year)->get();
            return view('dashboard')->with(['repositories'=>$repositories,'users'=>$users]);  // super admin
        }
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        // if user has 0 repository so he is new guest
        if($repositories->count() == 0){
             return redirect()->route('create.repository.form');
        }
        // if user has just one repository so he enter the repository directly
        if($repositories->count() == 1){
            $repository = $repositories[0];
            Session::put('repo_id', $repository->id);
            return redirect(route('in.repository',$repository->id));
        }
        return view('manager.Dashboard.select_repository')->with(['user'=>$user,'repositories'=>$repositories]);
    }

    public function selectRepositoryRedirectWithNoDeleteForSession(){
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
        {   
            $repositories = Repository::whereYear('created_at',now()->year)->get();
            $users = User::whereYear('created_at',now()->year)->get();
            return view('dashboard')->with(['repositories'=>$repositories,'users'=>$users]);  // super admin
        }
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        // if user has 0 repository so he is new guest
        if($repositories->count() == 0){
             return redirect()->route('create.repository.form');
        }
        // if user has just one repository so he enter the repository directly
        if($repositories->count() == 1){
            $repository = $repositories[0];
            Session::put('repo_id', $repository->id);
            return redirect(route('in.repository',$repository->id));
        }
        return view('manager.Dashboard.select_repository')->with(['user'=>$user,'repositories'=>$repositories]);
    }

    public function switchSub(){
        Session::forget('repo_id');
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
        {   
            $repositories = Repository::whereYear('created_at',now()->year)->get();
            $users = User::whereYear('created_at',now()->year)->get();
            return view('dashboard')->with(['repositories'=>$repositories,'users'=>$users]);  // super admin
        }
        $repositories = $user->repositories;   // display all repositories for the owner|worker
        // if user has 0 repository so he is new guest
        if($repositories->count() == 0){
             return redirect()->route('create.repository.form');
        }
        // if user has just one repository so he enter the repository directly
        if($repositories->count() == 1){
            $repository = $repositories[0];
            Session::put('repo_id', $repository->id);
            return redirect(route('in.repository',$repository->id));
        }
        return view('manager.Dashboard.select_repository')->with(['user'=>$user,'repositories'=>$repositories]);
    }

   /* public function main(){    // get dashboard view according to user Role
        $user = Auth::user();
        $user = User::find($user->id);
        if($user->hasRole('مشرف'))
            return view('dashboard');
        elseif($user->hasRole('مالك-مخزن'))
        {
            $user = Auth::user();
            $user = User::find($user->id);
            $repositories = $user->repositories;   // display all repositories for the owner|worker
            return view('manager.Dashboard.index')->with(['repositories'=>$repositories]);
        }
        elseif($user->hasRole('عامل-مخزن'))
        {
            $user = Auth::user();
            $user = User::find($user->id);
            $repositories = $user->repositories;   // display all repositories for the owner|worker
            return view('manager.Dashboard.worker_index')->with(['repositories'=>$repositories]);
        } 
    }  */

    public function choseMain($id){    // get dashboard view according to user Role
        $user = Auth::user();
        $user = User::find($user->id);
        $repository = Repository::find($id);
        // cant log to 2 repositories at the same time
        if(Session::get('repo_id')){
            return redirect(route('select.repository.redirect'));
        }
        else{
            return redirect(route('in.repository',$id));
        }
    } 

    public function main($id){    // get dashboard view according to user Role
        $user = Auth::user();
        $user = User::find($user->id);
        $repository = Repository::find($id);
        if($user->hasRole('مالك-مخزن'))
        {
            Session::put('repo_id', $repository->id);   // to use this repo_id where ever we want instead of using hidden input every where
            return view('manager.Dashboard.index')->with(['repository'=>$repository]);
        }
        elseif($user->hasRole('عامل-مخزن'))
        {
            Session::put('repo_id', $repository->id);
            return view('manager.Dashboard.worker_index')->with(['repository'=>$repository]);
        }
    } 

   
}
