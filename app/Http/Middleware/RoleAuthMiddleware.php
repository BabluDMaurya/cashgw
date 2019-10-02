<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
class RoleAuthMiddleware
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
        foreach(Auth::user()->role()->get() as $role){            
            if($role->name == 'individual'){                
                return redirect('/account-setting');                 
            }else if($role->name == 'business'){
                return redirect('/account-setting123');                 
            }
        }
//        return $next($request);
    }
}
