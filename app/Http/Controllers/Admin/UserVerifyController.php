<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\BusinessKyc;
use App\IndividualKyc;
use App\Master;
use Mail;
use App\Mail\AdminVerifyAprovalMail;
use App\Traits\UpdateUnRegisterEmail;
class UserVerifyController extends Controller
{
    use UpdateUnRegisterEmail;
    public function verifyUser($id){
        $userid = Crypt::decrypt($id);
        $users = User::where('id', $userid)->first();        
        if(isset($users) ){
            $userrole = $users->role;  
            $email = $users->email;
            if($userrole == 2){
                $busi = $users->business;
                if(!$busi->admin_verify){
                    $busi->admin_verify = 1;
                    $busi->primary_email = $email;
                    $busi->save(); 
                        $kyc = BusinessKyc::where('user_id', $userid)->first(); 
                        // send Emial to user of admin conformation
                            Mail::to($email)->send(new AdminVerifyAprovalMail());
                        //
                    $status = "E-mail verified.";
                }else{
                    $status = "E-mail already verified.";
                }
            }else{
                $indi = $users->individual;
                if(!$indi->admin_verify) {
                    $indi->admin_verify = 1;
                    $indi->primary_email = $email;
                    $indi->save();
                    
                    $kyc = IndividualKyc::where('user_id', $userid)->first();
                         // send Emial to user of admin conformation
                            Mail::to($email)->send(new AdminVerifyAprovalMail());
                        //
                    $status = "E-mail verified.";
                }else{
                    $status = "E-mail already verified.";
                }
            }
            if(!empty($kyc)){
                $master = Master::create([
                            'user_id'=>$userid,
                        //common filed in business and individual table    
                            'verify' => 1,
                            'kyc'=> 1,
                            'kyc_verify'=> 1,
                            'admin_verify'=> 1,
                            'account_status' => 1,
                            'primary_email' => $email,
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
            $this->updateEmailId($email,$userid,$kyc->fname);
            session()->flash('status', $status);
        }else{
            session()->flash('warning', 'Sorry Email not verified.');
        }        
        return redirect('/login');    
    }
}
