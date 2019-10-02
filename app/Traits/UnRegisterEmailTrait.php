<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\UnRegisterEmail;
trait UnRegisterEmailTrait{
    
    public function unRegisterEmail($table,$last_id,$user_id,$email,$mcount,$cname,$cvalue){
        UnRegisterEmail::create([
             'table' => $table,  
             'row_id' => $last_id,
             'user_id'=>$user_id,
             'email'=>$email,
             'mailcount'=>$mcount,
             'cname'=>$cname,
             'cvalue'=>$cvalue,
         ]);    
    }
}

