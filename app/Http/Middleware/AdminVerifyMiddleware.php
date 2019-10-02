<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdminVerifyMiddleware
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
        if(Auth::check()) {
            $role =  Auth::user()->role;
            if($role == 2){
               $relation = 'business';
            }else if($role == 1){
                $relation = 'individual';
            } 
            if(Auth::user()->$relation->admin_verify == 1){   
                return $next($request);
            }else if(Auth::user()->$relation->admin_verify == 0){
                Auth::logout();
                return redirect('/login')->with('status','Your Account not verifed by Admin.Please contact Admin.');
            }else if(Auth::user()->$relation->admin_verify == 2){
                Auth::logout();
                return redirect('/login')->with('status','Your Account rejected by Admin.Please contact Admin.');
            }else{
                Auth::logout();
                return redirect('/login')->with('status','Oops Something Wrong.');
            }
        }
    }
}
