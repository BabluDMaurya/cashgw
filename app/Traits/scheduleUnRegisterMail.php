<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\UnRegisterEmail;
use DB;
use Mail;
use App\Mail\JoinCashgwMail;
trait scheduleUnRegisterMail{    
   public function sendMail(){
       Mail::to('bablu@wdipl.com')->send(new JoinCashgwMail());
       
//       $data = DB::table('email_o_t_p_checks')->get();
//       foreach($data as $value){
//           if($value->mailcount <= 3){
//                Mail::to($value->email)->send(new JoinCashgwMail());
//                $data->mailcount = $value->mailcount + 1;
//                $data->save(); 
//           }
//       }
   }
}

