<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class EmailVerify
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
            if($role === 2){
               $relation = 'business';
            }else if($role === 1){
                $relation = 'individual';
            } 
            if(Auth::user()->$relation->verify == 1){   
                return $next($request);
            }else{
                Auth::logout();
                return redirect('/login')->with('status','Your account is not verify. Check your email and click on the link to verify.');
            }
        }
    }
}
