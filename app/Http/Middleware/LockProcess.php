<?php

namespace App\Http\Middleware;

use App\Repository;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LockProcess
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
        if(!Session::get('lock_process')){
            $repository_id = $request->route()->parameter('repository_id');
            $repository = Repository::find($repository_id);
            return redirect(route('sales.index',$repository->id));
        }
        return $next($request);
    }
}
