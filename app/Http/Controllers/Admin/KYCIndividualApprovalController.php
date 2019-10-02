<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Individual;
use App\IndividualKyc;
use App\Master;
use App\User;
use Mail;
use App\Mail\AccountApproveMail;
use Illuminate\Support\Facades\Crypt;
use App\Traits\UpdateUnRegisterEmail;
use App\DefaultTransactionCharge;
use App\SetTransactionCharge;
use App\SetPercentTransactionCharge;
use App\SetFlatTransactionCharge;
use App\AdminLogin;
class KYCIndividualApprovalController extends Controller
{
    use UpdateUnRegisterEmail;
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }    
    public function index(){
        $defaultTCharge = DefaultTransactionCharge::where('charge_type',1)->get();
        $IndividualDetailsPending = DB::table('users')
                                    ->join('individuals', 'users.id', '=', 'individuals.user_id')
                                    ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
                                    ->select('users.email',
                                        'users.created_at',
                                        'individual_kycs.fname',
                                        'individual_kycs.dob',                                             
                                        'individual_kycs.town_or_city', 
                                        'individual_kycs.country', 
                                        'individuals.user_id',
                                        'individuals.admin_verify')            
                                        ->where('users.role', '=', 1)
                                        ->where('individuals.admin_verify', '=', 0)  
                                        ->where('individuals.kyc_verify', '=', 1)  
                                    ->get();     
        
        $IndividualDetailsApproved = DB::table('users')
                                    ->join('individuals', 'users.id', '=', 'individuals.user_id')
                                    ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
                                    ->select('users.email',
                                        'users.created_at',
                                        'users.fees',    
                                        'individual_kycs.fname',
                                        'individual_kycs.dob', 
                                        'individual_kycs.town_or_city', 
                                        'individual_kycs.country', 
                                        'individuals.user_id',
                                        'individuals.admin_verify')            
                                        ->where('users.role', '=', 1)
                                        ->where('individuals.admin_verify', '=', 1)                                          
                                    ->get(); 
        $IndividualDetailsRejected = DB::table('users')
                                    ->join('individuals', 'users.id', '=', 'individuals.user_id')
                                    ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
                                    ->select('users.email',
                                        'users.created_at',
                                        'individual_kycs.fname',
                                        'individual_kycs.dob', 
                                        'individual_kycs.town_or_city', 
                                        'individual_kycs.country', 
                                        'individuals.user_id',
                                        'individuals.admin_verify')            
                                        ->where('users.role', '=', 1)
                                        ->where('individuals.admin_verify', '=', 2)                                          
                                    ->get();   
        $user = AdminLogin::where('email',config('constants.AdminMail'))->first();
        $user->unreadNotifications()->where('notifiable_type','App\AdminLogin')->whereIn('type',['App\Notifications\IndividualApproval'])->update(['read_at' => now()]);
        return view('pages.admin.kyc-approval',compact('IndividualDetailsPending','IndividualDetailsApproved','IndividualDetailsRejected','defaultTCharge')) ;
    }
    
    public function VerifyUserByAdmin(Request $request){
        
        $user_id = decrypt($request->id);        
        $status = $request->status_val;  
        $selcharge = $request->selcharge;
        
        $users = User::where('id', $user_id)->first();
        
        if($request->reject == 1 && $status == 2){
            $email = Crypt::encrypt($users->email);        
            $updateVerifyStatus = Individual::where('user_id', $user_id)
                    ->update(['admin_verify'=>$status,'primary_email'=>$email]);
            session()->flash('status',config('constants.UserRejected'));
            return redirect()->back();
        }else{
            $users->fees = $selcharge;
            $users->save();
            Mail::to($users->email)->send(new AccountApproveMail());
        }
        if($status == 3 && $selcharge == 3){
                SetTransactionCharge::where('user_id',$user_id)->delete();
             if($request->setcharge == 1){  
                SetPercentTransactionCharge::where('user_id',$user_id)->delete();
             }else if($request->setcharge == 2){  
                SetFlatTransactionCharge::where('user_id',$user_id)->delete();
             }
         }
         
        if($selcharge == 3){
            SetTransactionCharge::create([
               'user_id'=> $user_id,
                'charge_type'=> $request->setcharge,
            ]);            
            $chargearray = [$request->requestfees,$request->invoicefees,$request->currencyconverterfees];
            // [request money, invoice , currency conversion]
            $i = 1;
           if($request->setcharge == 1){               
               foreach($chargearray as $value){
                    SetPercentTransactionCharge::create([
                        'user_id'=> $user_id,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }else{
               foreach($chargearray as $value){
                    SetFlatTransactionCharge::create([
                        'user_id'=> $user_id,
                        'charge'=>$value,
                        'transaction_type'=>$i,
                    ]);
                $i++;    
               }
           }
        }    
        if($status != 3){
        $email = Crypt::encrypt($users->email);        
        $updateVerifyStatus = Individual::where('user_id', $user_id)
                ->update(['admin_verify'=>$status,'primary_email'=>$email]);        
        $kyc = IndividualKyc::where('user_id', $user_id)->first();
        $checkUserIdExist = Master::where('user_id',$user_id)->first();                 
        if(is_null($checkUserIdExist)){
            $master = Master::create([
                    'user_id'=>$user_id,                
                    'verify' => 1,
                    'kyc'=> 1,
                    'kyc_verify'=> 1,
                    'admin_verify'=> 1,
                    'account_status' => 1,
                    'primary_email' => $kyc->email,
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
        $this->updateEmailId($users->email,$user_id,$kyc->fname);   
        }        
        session()->flash('status',config('constants.UserApproved'));
        return redirect()->back();
    } 
}
