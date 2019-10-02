<?php

namespace App\Http\Controllers\Admin;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Master;
use App\Individual;
use App\IndividualKyc;
use App\Business;
use App\BusinessKyc;
use App\ChangePrimaryAddressRequest;
use App\RequestForMoneyToAdmin;
use Illuminate\Support\Facades\Crypt;
use App\Traits\BalanceTrait;
use Mail;
use App\Mail\AdminVerifyAprovalMail;
use App\Mail\AdminRequestPaymentApprovalMail;
use App\Mail\AdminRequestPaymentRejactionMail;
use App\Mail\PrimaryAddressApprovalMail;
use App\Mail\PrimaryAddressRejectMail;
use Auth;
use App\Traits\TransactionIdTrait;

use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminNotify;

class AdminUserController extends Controller    
{
    use BalanceTrait,TransactionIdTrait,Notifiable;
    
    public function __construct() {
        $this->middleware('auth:admin')->except('logout');
    }
    public function index(){

        $IndividualDetails = DB::table('users')
            ->join('individuals', 'users.id', '=', 'individuals.user_id')
            ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
            ->select('users.email',
                    'users.created_at',
                    'individual_kycs.fname',
                    'individuals.user_id',
                    'individuals.admin_verify')            
                    ->where('users.role', '=', 1)            
            ->get(); 
       
        $BusinessDetails = DB::table('users')
            ->join('businesses', 'users.id', '=', 'businesses.user_id')
            ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
            ->select('users.email',
                    'users.created_at',
                    'business_kycs.fname',
                    'businesses.user_id',
                    'businesses.admin_verify')            
                    ->where('users.role', '=', 2)            
            ->get(); 
        return view('pages.admin.user-verfication',compact('IndividualDetails','BusinessDetails')) ;
    }
    
    public function VerifyUserByAdmin(Request $request){
        $userId = decrypt($request->id);
        $status = $request->status_val;
        $updateVerifyStatus = Individual::where('user_id', $userId)
                    ->update(['admin_verify'=>$status]);
        $updateVerifyStatus = Business::where('user_id', $userId)
                    ->update(['admin_verify'=>$status]);
    } 
    
    public function ManagePaymentRequest(){
        
        $IndividualPaymentRequest = DB::table('users')
            ->join('individuals', 'users.id', '=', 'individuals.user_id')
            ->join('individual_kycs', 'users.id', '=', 'individual_kycs.user_id')
            ->join('request_for_money_to_admins', 'users.id', '=', 'request_for_money_to_admins.user_id')                  
            ->select('users.email',
                    'request_for_money_to_admins.created_at',
                    'individual_kycs.fname',
                    'request_for_money_to_admins.id',
                    'request_for_money_to_admins.balance',
                    'request_for_money_to_admins.admin_action',
                    'request_for_money_to_admins.currency_requested')            
                    ->where('users.role', '=', 1)            
            ->get(); 
        
        $BusinessPaymentRequest = DB::table('users')
            ->join('businesses', 'users.id', '=', 'businesses.user_id')
            ->join('business_kycs', 'users.id', '=', 'business_kycs.user_id')
            ->join('request_for_money_to_admins', 'users.id', '=', 'request_for_money_to_admins.user_id')
            ->select('users.email',
                    'request_for_money_to_admins.created_at',                    
                    'business_kycs.fname',
                    'request_for_money_to_admins.id',                    
                    'request_for_money_to_admins.balance',
                    'request_for_money_to_admins.admin_action',
                    'request_for_money_to_admins.currency_requested')            
                    ->where('users.role', '=', 2)            
            ->get(); 
        
        return view('pages.admin.manage-payment-request',compact('IndividualPaymentRequest','BusinessPaymentRequest')) ;
        
    }
    
    public function PaymentRequestAdmin(Request $request){ 
        $rowdetails = RequestForMoneyToAdmin::where('id', decrypt($request->id))->first();
//        $transactionId = $this->createTID();
        $userdeatils = User::where('id',$rowdetails->user_id)->first();
        
        if($request->status_val != 3){
            $result = $this->recivedRequestAddBalanceAdmin($rowdetails);                    
            if($result == 1){        
                $rowdetails->admin_action = $request->status_val;
                $rowdetails->status = 2;
                $rowdetails->save();
                
                $this->createPaymentHistory($rowdetails->user_id,NULL,$rowdetails->balance,config('constants.BalanceRequesteToAdmin'),$rowdetails->transaction_id);                    
                //create activity 
                // method parameter (userid,name,email,status [1=pending,2=success,3=rejected,4=cancel],balance,type 3=request to admin,fees,descriptions)
                //$this->createActivity($rowdetails->user_id,$rowdetails->user_id,0,config('constants.AdminName'),config('constants.AdminMail'),2,$rowdetails->balance,12,NULL,config('constants.BRTA'),$rowdetails->transaction_id,$rowdetails->currency_requested,NULL);
                $activity3 = $this->updateActivityStatus($rowdetails->transaction_id,Crypt::encrypt(2));
                $notifydata = [
                                'request_status' => 6,
                                'action'=>'recived',
                                'process'=>2,
                                'type'=>'PaymentRequestAdmin',
                                'tab'=> 3,
                            ];
                $userdeatils->notify(new AdminNotify($notifydata));
                Mail::to($userdeatils->email)->send(new AdminRequestPaymentApprovalMail());
                echo $request->status_val;
            }else{
                echo $result;
            }
        }else{
            $rowdetails->admin_action = $request->status_val;            
            $rowdetails->save();
            // method parameter (userid,name,email,status [1=pending,2=success,3=rejected,4=cancel],balance,type 3=request to admin,fees,descriptions)
                //$this->createActivity($rowdetails->user_id,$rowdetails->user_id,0,config('constants.AdminName'),config('constants.AdminMail'),3,$rowdetails->balance,14,NULL,config('constants.BRTA'),$rowdetails->transaction_id,$rowdetails->currency_requested,NULL);
                $activity3 = $this->updateActivityStatus($rowdetails->transaction_id,Crypt::encrypt(3));
                $notifydata = [
                                'request_status' => 6,
                                'action'=>'recived',
                                'process'=>3,
                                'type'=>'SentRequest',
                                'tab'=> 3,
                            ];
                $userdeatils->notify(new AdminNotify($notifydata));
                Mail::to($userdeatils->email)->send(new AdminRequestPaymentRejactionMail());                
            echo $request->status_val;
        }
    }  
    
    
    
    public function PrimaryAddressApproval(){        
        $IndividualPrimaryAddressDetails = DB::table('change_primary_address_requests')                            
                            ->join('individual_kycs', 'change_primary_address_requests.user_id', '=', 'individual_kycs.user_id')
                            ->select('change_primary_address_requests.*',                                    
                                    'individual_kycs.fname',
                                    'individual_kycs.lname')            
                                    ->where('change_primary_address_requests.role', '=', 1)                                    
                                    ->orderby('change_primary_address_requests.created_at','DESC')
                            ->get(); 
        $BusinessPrimaryAddressDetails = DB::table('change_primary_address_requests')                            
                            ->join('business_kycs', 'change_primary_address_requests.user_id', '=', 'business_kycs.user_id')
                            ->select('change_primary_address_requests.*',                                    
                                    'business_kycs.fname',
                                    'business_kycs.lname')            
                                    ->where('change_primary_address_requests.role', '=', 2)                                    
                                    ->orderby('change_primary_address_requests.created_at','DESC')
                            ->get(); 
        return view('pages.admin.primary-address-approval', compact('IndividualPrimaryAddressDetails','BusinessPrimaryAddressDetails'));
    }
    
    public function ViewPrimaryAddressApproval(Request $request){
        $id = decrypt($request->id);       
        $ViewUserAddressDetails = DB::table('change_primary_address_requests')            
            ->select('change_primary_address_requests.*')
            ->where('change_primary_address_requests.id', '=', $id)
            ->get(); 
        return view('pages.ajaxmodal.viewuserprimaryaddress',['ViewUserAddressDetails'=>$ViewUserAddressDetails]); 
    }
    
    public function AppOrRejectAddressByAdmin(Request $request){
        $user_id = decrypt($request->user_id);     
        $status_val = $request->status_val;
        $id = decrypt($request->id);
        
        $addressDetailsRow = ChangePrimaryAddressRequest::where('user_id', $user_id)->orderby('change_primary_address_requests.created_at','DESC')->first();         
        $users = User::where('id', $user_id)->first(); 
        $email = $users->email;       
        $role = $request->role;        
           
        if($status_val==1 && $role==1){
            $updateAddress = IndividualKyc::where('user_id', $user_id)
                    ->update(['add_line_one'=>Crypt::encrypt($addressDetailsRow['add_line_one']),
                              'add_line_two'=>Crypt::encrypt($addressDetailsRow['add_line_two']),
                              'town_or_city'=>Crypt::encrypt($addressDetailsRow['town_or_city']),
                              'zip'=>Crypt::encrypt($addressDetailsRow['zip']),
                              'state'=>Crypt::encrypt($addressDetailsRow['state']),
                              'country'=>Crypt::encrypt($addressDetailsRow['country']),
                              'address_proof'=>($addressDetailsRow['address_proof'])]);
            $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                    ->update(['admin_status'=>1]); 
            
            $username = IndividualKyc::where('user_id', $user_id)->first(); 
            $fname = $username['fname'];            
            Mail::to($email)->send(new PrimaryAddressApprovalMail($fname));
            
            echo "1";
        }elseif($status_val==1 && $role==2){
            $updateAddress = BusinessKyc::where('user_id', $user_id)
                    ->update(['add_line_one'=>Crypt::encrypt($addressDetailsRow['add_line_one']),
                              'add_line_two'=>Crypt::encrypt($addressDetailsRow['add_line_two']),
                              'town_or_city'=>Crypt::encrypt($addressDetailsRow['town_or_city']),
                              'zip'=>Crypt::encrypt($addressDetailsRow['zip']),
                              'state'=>Crypt::encrypt($addressDetailsRow['state']),
                              'country'=>Crypt::encrypt($addressDetailsRow['country']),
                              'address_proof'=>($addressDetailsRow['address_proof'])]);
            $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                    ->update(['admin_status'=>1]); 
            
            $businessname = BusinessKyc::where('user_id', $user_id)->first(); 
            $bname = $businessname['business_name'];             
            Mail::to($email)->send(new PrimaryAddressApprovalMail($bname));
            
            echo "1";
        }elseif($status_val==2){
            $updateStatus = ChangePrimaryAddressRequest::where('id', $id)
                    ->update(['admin_status'=>2]);
            if($role==1){
                $username = IndividualKyc::where('user_id', $user_id)->first(); 
                $fname = $username['fname'];
                Mail::to($email)->send(new PrimaryAddressRejectMail($fname));
            }else{
                $businessname = BusinessKyc::where('user_id', $user_id)->first(); 
                $bname = $businessname['business_name'];  
                Mail::to($email)->send(new PrimaryAddressRejectMail($bname));
            }            
            echo "2";
        }
    }
}
