<?php
namespace App\Traits; 
use Illuminate\Support\Facades\Crypt;
use DB;
trait UniqueEmailTrait {
   
    public function checkUniqueEmail(){
                $uemail = array();
                $bPemail = array();
                $bSemail = array();
                $iPemail = array();
                $iSemail = array();
                $marray = array();
                
                $users = DB::table('users');
                $usersemail = $users->pluck('email')->toArray();
                if(!empty($usersemail)){
                    foreach ($usersemail as $value) {
                        if(!empty($value)){
                            $uemail[] = $value;
                        }
                    } 
                    $marray = array_merge($marray,array_filter($uemail));
                }
                
                $busi = DB::table('businesses');
                $busiPemail = $busi->pluck('primary_email')->toArray();
                $busiSemail = $busi->pluck('secondary_email')->toArray();
                if(!empty($busiPemail)){
                    foreach ($busiPemail as $value) {
                        if(!empty($value)){
                            $bPemail[] = decrypt($value);
                        }
                    }  
                        $marray = array_merge($marray,array_filter($bPemail));
                }
                if(!empty($busiSemail)){
                    foreach ($busiSemail as $value) {
                        if(!empty($value)){
                            $bSemail[] = decrypt($value);
                        }
                    }
                        $marray = array_merge($marray,array_filter($bSemail));
                }
                $indi = DB::table('individuals');
                $indiPemail = $indi->pluck('primary_email')->toArray();
                $indiSemail = $indi->pluck('secondary_email')->toArray();
               if(!empty($indiPemail)){ 
                    foreach ($indiPemail as $value) {
                        if(!empty($value)){
                            $iPemail[] = decrypt($value);
                        }
                   }                    
                        $marray = array_merge($marray,array_filter($iPemail));                   
                }      
                if(!empty($indiSemail)){
                    foreach ($indiSemail as $value) {
                        if(!empty($value)){
                            $iSemail[] = decrypt($value);
                        }
                    }    
                        $marray = array_merge($marray,array_filter($iSemail));
                }
                $emails = array_unique($marray);
//                print_r($emails);
                return $emails;
    }
}