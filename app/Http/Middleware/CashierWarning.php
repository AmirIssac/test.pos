<?php

namespace App\Http\Middleware;

use App\Repository;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CashierWarning
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        /*
        $user = Auth::user();
        $user = User::find($user->id);
        $repositories = $user->repositories;
        /*foreach($repositories as $repository){
            if($repository->isCashierWarning())
                return redirect(route('cashier.warning',$repository->id));
        }*/
        /*
        foreach($repositories as $repository){
            $warning = $repository->CashierWarningDetails();
            if($warning['status']==true)
                return redirect(route('cashier.warning',$repository->id));
        }
        */
        $repository_id = $request->route()->parameter('repository_id');
        $repository = Repository::find($repository_id);
        $setting = $repository->setting;
        if($setting->cashier_reminder){  // Not Null
            if(now() > $setting->cashier_reminder){
                Session::put('repo_id', $repository->id);
                return redirect(route('cashier.reminder',$repository->id));
            }
            else{
                return $next($request);
            }
        }
        else{   // Null
            return $next($request);
        }
    }
}
