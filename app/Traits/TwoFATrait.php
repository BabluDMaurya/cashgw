<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\EmailOTPCheck;
use Mail;
use App\Mail\SendMoneyOTPMail;
trait TwoFATrait{
    public function sendOTP(Request $request){
        if(Auth::check()){
        $user = Auth::user();
        $otp = mt_rand(config('constants.RandnumOTPstart'), config('constants.RandnumOTPend'));
                    EmailOTPCheck::create([
                       'email' => $user->email,
                       'token' => $request->_token,                    
                       'otp'=>$otp,
                   ]);
                $data = [
                        'number' => $otp,
                        'amount' => $request->amount,   
                        ];                
                    Mail::to($user->email)->send(new SendMoneyOTPMail($data));                    
                if (Mail::failures()) {
                    return redirect()->back()->withErrors('mailfail',config('constants.MailFailures'));
                }else{
                    return $data; 
                }
        }
    }
}