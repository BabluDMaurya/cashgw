<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Business;
use App\BusinessKyc;
use App\Master;
use App\User;
use Illuminate\Support\Facades\Crypt;
use App\Traits\UpdateUnRegisterEmail;
use Mail;
use App\Mail\AccountApproveMail;
use App\DefaultTransactionCharge;
use App\SetTransactionCharge;
use App\SetPercentTransactionCharge;
use App\SetFlatTransactionCharge;
use App\AdminLogin;
class KYCBusinessApprovalController extends Controller
{
    use UpdateUnRegisterEmail;
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    
    public function index(){
        $defaultTCharge = DefaultTransactionCharge::where('charge_type',1)->get();
        $BusinessDetailsPending = DB::table('users')
                                ->join('businesses', 'users.id', '=', 'businesses.user_id')
                                ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
                                ->select('users.email',
                                        'users.created_at',
                                        'business_kycs.business_name',
                                        'business_kycs.business_type',
                                        'business_kycs.dob',
                                        'business_kycs.town_or_city', 
                                        'business_kycs.country', 
                                        'businesses.user_id',
                                        'businesses.admin_verify')            
                                        ->where('users.role', '=', 2)  
                                        ->where('businesses.admin_verify', '=', 0)  
                                        ->where('businesses.kyc_verify', '=', 1)  
                                ->get(); 
        
        $BusinessDetailsApproved = DB::table('users')
                                ->join('businesses', 'users.id', '=', 'businesses.user_id')
                                ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
                                ->select('users.email',
                                        'users.created_at',
                                        'users.fees',   
                                        'business_kycs.business_name',
                                        'business_kycs.business_type',
                                        'business_kycs.dob',
                                        'business_kycs.town_or_city', 
                                        'business_kycs.country', 
                                        'businesses.user_id',
                                        'businesses.admin_verify')           
                                        ->where('users.role', '=', 2)  
                                        ->where('businesses.admin_verify', '=', 1) 
                                ->get(); 
        
        $BusinessDetailsRejected = DB::table('users')
                                ->join('businesses', 'users.id', '=', 'businesses.user_id')
                                ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
                                ->select('users.email',
                                        'users.created_at',
                                        'business_kycs.business_name',
                                        'business_kycs.business_type',
                                        'business_kycs.dob',
                                        'business_kycs.town_or_city', 
                                        'business_kycs.country', 
                                        'businesses.user_id',
                                        'businesses.admin_verify')             
                                        ->where('users.role', '=', 2)  
                                        ->where('businesses.admin_verify', '=', 2) 
                                ->get(); 
        
        $user = AdminLogin::where('email',config('constants.AdminMail'))->first();
        $user->unreadNotifications()->where('notifiable_type','App\AdminLogin')->whereIn('type',['App\Notifications\BusinessApproval'])->update(['read_at' => now()]);
        
        return view('pages.admin.kyc-approval-business',compact('BusinessDetailsPending','BusinessDetailsApproved','BusinessDetailsRejected','defaultTCharge')) ;
    }
    
    public function VerifyBusinessByAdmin(Request $request){
        
        $userId = decrypt($request->id);        
        $status = $request->status_val;          
        $selcharge = $request->selcharge;        
        
        $users = User::where('id', $userId)->first();
        
       if($request->reject == 1 && $status == 2){
            $email = Crypt::encrypt($users->email);        
            $updateVerifyStatus = Business::where('user_id', $userId)
                    ->update(['admin_verify'=>$status,'primary_email'=>$email]);
            session()->flash('status',config('constants.UserRejected'));
            return redirect()->back();
        }else{
            $users->fees = $selcharge;
            $users->save();  
            Mail::to($users->email)->send(new AccountApproveMail());
        }
        
         if($status == 3 && $selcharge == 3){
                SetTransactionCharge::where('user_id',$userId)->delete();
             if($request->setcharge == 1){  
                SetPercentTransactionCharge::where('user_id',$userId)->delete();
             }else if($request->setcharge == 2){  
                SetFlatTransactionCharge::where('user_id',$userId)->delete();
             }
         }
        
        if($selcharge == 3){                   
            SetTransactionCharge::create([
               'user_id'=> $userId,
                'charge_type'=> $request->setcharge,
            ]);            
            $chargearray = [$request->requestfees,$request->invoicefees,$request->currencyconverterfees];
            // [request money, invoice , currency conversion]
            $i = 1;
           if($request->setcharge == 1){               
               foreach($chargearray as $value){
                    SetPercentTransactionCharge::create([
                        'user_id'=> $userId,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }else{
               foreach($chargearray as $value){
                    SetFlatTransactionCharge::create([
                        'user_id'=> $userId,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }         
        }         
        if($status != 3){
        $email = Crypt::encrypt($users->email);
        
        $updateVerifyStatus = Business::where('user_id', $userId)
                    ->update(['admin_verify'=>$status,'primary_email'=>$email]);
        $kyc = BusinessKyc::where('user_id', $userId)->first();
        $checkUserIdExist = Master::where('user_id',$userId)->first();
                     
        if(is_null($checkUserIdExist)){
            $master = Master::create([
                    'user_id'=>$userId,
                //common filed in business and individual table    
                    'verify' => 1,
                    'kyc'=> 1,
                    'kyc_verify'=> 1,
                    'admin_verify'=> 1,
                    'account_status' => 1,
                    'primary_email' => $kyc->email,
                //BusinessKyc table
                    'business_name' => $kyc->business_name,
                    'business_type'=> $kyc->business_type,
                    'business_certificate'=> $kyc->business_certificate,
                    'business_memorandum'=>$kyc->business_memorandum,
                //common filed in business and individual table    
                    'fname'=>$kyc->fname,   
                    'mname'=> $kyc->mname,
                    'lname'=>$kyc->lname,
                    'dob'=> $kyc->dob,
                    'passport_no'=> $kyc->passport_no,
                    'passport_country'=> $kyc->passport_country,
                    'passport_expdate'=> $kyc->passport_expdate,
                    'passport'=>$kyc->passport,
                    'add_line_one'=> $kyc->add_line_one,
                    'add_line_two'=> $kyc->add_line_two,
                    'town_or_city'=> $kyc->town_or_city,
                    'zip'=> $kyc->zip,
                    'state'=> $kyc->state,
                    'country'=> $kyc->country,
                    'address_proof'=>$kyc->address_proof,
                    'photo'=>$kyc->photo,
            ]);
        }
        $this->updateEmailId($users->email,$userId,$kyc->fname);
        }
        session()->flash('status',config('constants.UserApproved'));
        return redirect()->back();
    } 
}
