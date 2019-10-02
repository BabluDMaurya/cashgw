<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Activity;
trait ActivityTrait{
    
    public function createActivity($userid,$touser,$invoice_id,$name,$email,$status,$balance,$type,$fee,$note,$transactionid,$currency,$showdate){
        if(Auth::Check()){                         
                $records = [
                    'user_id' => $userid, 
                    'to_user_id'=>$touser,
                    'invoice_id' => $invoice_id,
                    'name' => $name,    
                    'email' => $email,    
                    'status' => $status,                    
                    'balance' => $balance,
                    'type'=> $type,
                    'fee'=> $fee,
                    'descriptions' =>$note,
                    'archieve'=>1,
                    'transactionid'=>$transactionid,
                    'currency'=>$currency,
                    'showdate'=>$showdate,
                ];
                $data = Activity::create($records);
                return $data->id;
        }    
    }
    public function updateActivityStatus($transactionid,$status){
        $data = Activity::where('transactionid',$transactionid)->update(['status'=>$status]);        
    }
}

