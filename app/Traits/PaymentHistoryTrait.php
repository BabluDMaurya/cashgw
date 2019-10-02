<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\BusinessKyc;
use App\IndividualKyc;
use App\BusinessTotalTransaction;
use App\BusinessCreadit;
use App\BusinessDebit;
use App\IndividualCreadit;
use App\IndividualDebit;
use App\IndividualTotalTransaction;
//use App\Traits\TransactionIdTrait;
trait PaymentHistoryTrait{
//    use TransactionIdTrait;
    
    public function getReciverNameIDRoleByEmail($email){
        $reciverdeatail  = User::select('role','id')->where('email',$email)->first();  
       
        if(is_null($reciverdeatail)){
            // unregister email detais
          return $result = [
            'name'=> config('constants.UnregisterUserName'),
            'role'=> config('constants.UnregisterUserRole'),
            'email'=> $email,
            'id'=> config('constants.UnregisterUserID'),
            ]; 
        }else{
            if($reciverdeatail->role == 2){
                $name = BusinessKyc::select('fname')->where('user_id',$reciverdeatail->id)->first();
                if(isset($name->fname)){
                    $aname = $name->fname;
                }else{
                    $aname = config('constants.UnregisterUserName');
                }
                
            }elseif($reciverdeatail->role == 1){
                $name = IndividualKyc::select('fname')->where('user_id',$reciverdeatail->id)->first();
                if(isset($name->fname)){
                    $aname = $name->fname;
                }else{
                    $aname = config('constants.UnregisterUserName');
                }
            }
            return $result = [
                'name'=> $aname,
                'role'=> $reciverdeatail->role,
                'email'=> $email,
                'id'=> $reciverdeatail->id,
            ];
        }
    }
    
    public function getReciverNameEmailRoleById(int $id){
        $reciverdeatail  = User::select('role','email')->where('id',$id)->first();  
        if($reciverdeatail->role == 2){
            $name = BusinessKyc::select('fname')->where('user_id',$id)->first();
        }else{
            $name = IndividualKyc::select('fname')->where('user_id',$id)->first();
        }
        return $result = [
            'name'=> $name->fname,
            'role'=> $reciverdeatail->role,
            'email'=> $reciverdeatail->email,
            'id'=> $id,
        ];
    }
    public function getSenderNameEmailRoleById(){        
        if(Auth::Check()){
            $user = Auth::user();               
        if($user->role == 2){
            $name = BusinessKyc::select('fname')->where('user_id',$user->id)->first();
            $fname = $name->fname;
        }else if($user->role == 1){
            $name = IndividualKyc::select('fname')->where('user_id',$user->id)->first();
            $fname = $name->fname;
        }else{
            $fname = $user->fname;
        }        
        return $result = [
            'name'=> $fname,
            'role'=> $user->role,
            'email'=> $user->email,
            'id'=> $user->id,            
        ];  
      }  
    }
    public function createPaymentHistory($id,$balance,$balance_to,$details,$transactionId){
        if(Auth::Check()){               
            $reciver = $this->getReciverNameEmailRoleById($id);  
            $sender = $this->getSenderNameEmailRoleById();            
                $Rrecords = [                    
                    'user_id' => $reciver['id'],                    
                    'name' => $sender['name'],                    
                    'email' => $sender['email'],                     
                    'status' => 1,
                    'tstatus' => 1,                    
                    'transactionid' => $transactionId,
                    'details' => ($details != '')? $details : config('constans.SENDMONEYHISTORY'),
                    'amount' => $balance_to,
                ];      
                $Srecords = [
                    'user_id' => $sender['id'],                    
                    'name' => $reciver['name'],                    
                    'email' => $reciver['email'],                     
                    'status' => 1,
                    'tstatus' => 2,                    
                    'transactionid' => $transactionId,
                    'details' => ($details != '')? $details : config('constans.SENDMONEYHISTORY'),
                    'amount' => $balance,
                ];
            if($reciver['role'] == 2){
                BusinessTotalTransaction::create($Rrecords)->id;
                BusinessCreadit::create($Rrecords);
            }else if($reciver['role'] == 1){
                IndividualTotalTransaction::create($Rrecords)->id;
                IndividualCreadit::create($Rrecords);
            }
            
            if($sender['role'] == 2){
                BusinessTotalTransaction::create($Srecords);
                BusinessDebit::create($Srecords);
            }else if($sender['role'] == 1){
                IndividualTotalTransaction::create($Srecords);
                IndividualDebit::create($Srecords);
            }
        }    
    }
}

