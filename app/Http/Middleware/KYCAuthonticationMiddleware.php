<?php
namespace App\Http\Middleware;
use Closure;
use App\User;   
use Illuminate\Support\Facades\Auth;
class KYCAuthonticationMiddleware
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
               $user =  Auth::user()->business;
               $path = '/info-business';

            }else if($role == 1){
                $user =  Auth::user()->individual;
                $path = '/info-individual';
            } 
           
            if(($user->kyc == 1) && ($user->kyc_verify == 1)){                
                return $next($request);                    
              }else{
                if(($user->kyc == 0) && ($user->kyc_verify == 0)){                
                        return redirect($path);                                         
                }else if(($user->kyc == 1)){
                    if($user->kyc_verify == 0){
                        Auth::logout();
                        return redirect('/login')->with('status','Please verify your KYC Email.');
                    }
                }
            }
        
         }
        
        
//        $user = Auth::user();
//        $kycverify = User::select('kyc','kycverified')->where('id',$user->id)->get();
//        if(($kycverify[0]->kyc === 1) && ($kycverify[0]->kycverified === 1)){
//            return $next($request);
////            return redirect()->route('/account-setting');
//        }else{
//            if(($kycverify[0]->kyc === 0)&&($kycverify[0]->kycverified === 0)){
//                foreach(Auth::user()->role()->get() as $role){            
//                    if($role->name == 'individual'){                
//                        return redirect('/info-individual');                 
//                    }else if($role->name == 'business'){
//                        return redirect('/info-business');                 
//                    }
//                }
//            }else if(($kycverify[0]->kyc === 1)){
//                if($kycverify[0]->kycverified === 0){
//                    Auth::logout();
//                    return redirect('/login')->with('status','Please verify KYC Email.');
//                }
//            }
//        }        
    }
}
