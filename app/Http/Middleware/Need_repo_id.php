<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Need_repo_id
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // هذا المدل وير من اجل عدم قيام بأي عملية داخل المتجر في حال لم يكن هنالك في الجلسة لدينا repo_id
    public function handle($request, Closure $next)
    {
        $token_name = Session::get('branch_token_name');
        $token_value = Session::get('branch_token_value');
        if($token_name != $token_value && $token_value){
            return redirect('/');
        }
        return $next($request);
    }
}
