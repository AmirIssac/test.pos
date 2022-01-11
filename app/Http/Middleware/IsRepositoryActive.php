<?php

namespace App\Http\Middleware;

use App\Repository;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class IsRepositoryActive
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
        $repository_id = $request->route()->parameter('repository_id');
        $repository = Repository::find($repository_id);
        $setting = $repository->setting;
        if(!$setting->is_active){
            $user = User::find(Auth::user()->id);
           // return view('guest.message')->with(['repository'=>$repository,'user'=>$user]);       
           return redirect(route('repository.status',$repository->id));
        } 
        else
         return $next($request);
    }
}
