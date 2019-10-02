<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\UnRegisterEmail;
use DB;
use App\Jobs\RequestPaymentMailJob;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
trait UpdateUnRegisterEmail{    
   public function updateEmailId($email,$userid,$fname){
       $data = UnRegisterEmail::where('email',$email)->get();
       if(count($data) > 0){
           foreach($data as $value){
               $record = DB::table($value->table)->where('id',$value->row_id)->first();
                 if($value->cname == 'name'){
                        $cvalue = $fname;
                    }elseif($value->cname == 'user_id'){
                        $cvalue = $userid;
                    }
                                
                  $userdata[] = [
                    'balance' => Crypt::decrypt($record->balance),
                    'currency_requested' => '1',
                    'email' => 'user',
                    'request_status' => 1,    
                  ];
                if($value->table == 'request_for_money_to_users'){
                    DB::table($value->table)->where('id',$value->row_id)->update([$value->cname=>$cvalue,'action'=>1]);  
                }else{
                    DB::table($value->table)->where('id',$value->row_id)->update([$value->cname=>$cvalue]);  
                }  
                
                UnRegisterEmail::where('id',$value->id)->delete();  
            }
            
                 
                  
                  $job = (new RequestPaymentMailJob($email,$userdata,NULL,NULL))->delay(Carbon::now()->addSeconds(20));
                  $this->dispatch($job);
       }       
       
   }
}

