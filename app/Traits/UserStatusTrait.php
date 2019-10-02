<?php
namespace App\Traits; 
use Illuminate\Support\Facades\Crypt;
use App\User;
use App\Individual;
use App\Business;
trait UserStatusTrait {
   
    public function CheckUserStatus($id){
        $user = User::select('role')->where('id',$id)->first();
        if($user->role == 2){
            $data = Business::where('user_id',$id)->first();
            $verify = $this->returnvalue($data->verify);
            if($verify != 1){
                return config('constants.Userverify');
            }
            $kyc = $this->returnvalue($data->kyc);
            if($kyc != 1){
                return config('constants.Kycnotfill');
            }            
            $kycverify = $this->returnvalue($data->kyc_verify);
            if($kycverify != 1){
                return config('constants','Kycverify');
            }
            $adminverify = $this->returnvalue($data->admin_verify);
            if($adminverify == 2){
                return config('constants','Adminreject');
            }else if($adminverify == 0){
                return config('constants','AdminNotverify');
            }
            $accstatus = $this->returnvalue($data->account_status);            
            if($accstatus == 2){
                return config('constants','Accdelete');
            }
            return config('constants','Activeuser');
        }else{
            $data = Individual::where('user_id',$id)->first();
            $verify = $this->returnvalue($data->verify);
            if($verify != 1){
                return config('constants.Userverify');
            }
            $kyc = $this->returnvalue($data->kyc);
            if($kyc != 1){
                return config('constants.Kycnotfill');
            }            
            $kycverify = $this->returnvalue($data->kyc_verify);
            if($kycverify != 1){
                return config('constants','Kycverify');
            }
            $adminverify = $this->returnvalue($data->admin_verify);
            if($adminverify == 2){
                return config('constants','Adminreject');
            }else if($adminverify == 0){
                return config('constants','AdminNotverify');
            }
            $accstatus = $this->returnvalue($data->account_status);            
            if($accstatus == 2){
                return config('constants','Accdelete');
            }
            return config('constants','Activeuser');
        }
    }
    public function returnvalue($data){
        if($data == 1){
            return '1';
        }else if($data == 2){
            return '0';
        }elseif($data == 3){
            return '3';
        }else{
            return '0';
        }
    }
}