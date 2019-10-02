<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EmailOTPCheck;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendMoneyOTPMail;
use Mail;
use App\Traits\TwoFATrait;
class RequestFormController extends Controller
{
    use TwoFATrait;
    public function sendMoneyForm(Request $request, $id){        
        $user = Auth::user(); 
        $mes = 'No record added';
        if(isset($request->amount)){
            $validator = Validator::make($request->all(), [
            'search_text' => 'required|email|string|emailformate|exists:users,email', 
            'user_id'=>'required',   
            'amount' => 'required|integer', 
            'balance_request'=>'required',
            'note'=>'required',    
            ],[
            'search_text.required' => 'Email Address or Phone Number Required',
            'search_text.email' => 'Email required',    
            'search_text.exists' => 'Cashgw send a mail to this email.when he/she register then your request proceeds.', 
            'user_id.required' => 'User Required',
            'amount.required' => 'Amount Required',      
            'amount.integer' => 'amount should be integer',
            'balance_request.required'=>'Please select Currency.',    
            'note.required' => 'Note Required',
            ]);
            if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
            }
            $otpdata = $this->sendOTP($request);
            $data = [
                        'number' => $otpdata['number'],
                        'amount' => $otpdata['amount'], 
                        'search_text'=>$request->search_text,
                        'currency' => $request->balance_request,
                        'datetime'=> date('d-m-Y H:i:s'),  
                        'note' => $request->note,
                        'user_id'=>$request->user_id,
                        'email'=>$user->email,
                        'murl'=>$request->murl,
                        'recivedrequest'=>'No',
                        ];
            
            if($request->typeuser == 'busi'){
                return view('pages.business.send-money-otp',['user_id'=>$id,'data'=>$data]); 
            }else{
                return view('pages.user.send-money-otp',['user_id'=>$id,'data'=>$data]); 
            }
        }
        session()->flash('status',$mes);
          return redirect()->back();
    }
}
