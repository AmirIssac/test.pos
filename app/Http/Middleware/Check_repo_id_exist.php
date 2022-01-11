<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Check_repo_id_exist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     // هذا الميدلوير لعدم امكانية فتح اكثر من فرع في نفس الجلسة
    public function handle($request, Closure $next)
    {
        $repo_id = Session::get('repo_id');
        $token_name = Session::get('branch_token_name');
        $token_value = Session::get('branch_token_value');
        if(!$token_name && $token_name != $token_value){
            return redirect('/');
        }
        return $next($request);
    }
}
