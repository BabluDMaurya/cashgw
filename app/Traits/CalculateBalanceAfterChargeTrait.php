<?php
namespace App\Traits; 
use Illuminate\Support\Facades\Auth;
use App\DefaultTransactionCharge;
use App\SetTransactionCharge;
use App\SetPercentTransactionCharge;
use App\SetFlatTransactionCharge;

trait CalculateBalanceAfterChargeTrait {
    
    public function transactionCharges($ttype) {        
            $user = Auth::user();             
            if($user->fees == 3){ //check the set fees
                $chargetype = SetTransactionCharge::select('charge_type')->where('user_id',$user->id)->first();
                if($chargetype->charge_type == 2){
                    $queryrow = SetFlatTransactionCharge::select('charge')->where('user_id',$user->id)->where('transaction_type',$ttype)->first();
                    return $result = [
                            'charge'=>$queryrow->charge,
                            'charge_type'=>$chargetype->charge_type,
                            'fees'=>$user->fees,
                            'transaction_type'=>$ttype
                        ];
                }else{
                    $queryrow = SetPercentTransactionCharge::select('charge')->where('user_id',$user->id)->where('transaction_type',$ttype)->first();
                    return $result = [
                            'charge'=>$queryrow->charge,
                            'charge_type'=>$chargetype->charge_type,
                            'fees'=>$user->fees,
                            'transaction_type'=>$ttype,
                        ];
                }
            }else{
                $queryrow = DefaultTransactionCharge::select('charge','charge_type')->where('charge_type',$user->fees)->where('transaction_type',$ttype)->first();
                return $result = [
                            'charge'=>$queryrow->charge,
                            'charge_type'=>$queryrow->charge_type,
                            'fees'=>$user->fees,
                            'transaction_type'=>$ttype
                        ];
            }        
    }
   
    public function calculateBalanceAfterCharge($balance,$charge){
        $charges = $charge['charge'];
        $settype_charge = $charge['charge_type'];
        $feestype = $charge['fees'];
        if($feestype == 1){
            // default charge apply in percent
           return $this->calculateBalanceInPercent($balance,$charges);
        }else if($feestype == 2){
           //set charge apply in flat
           return $this->calculateBalanceInFlat($balance,$charges);
        }else if($feestype == 3){
                // set charge depend on settype_charge
            if($settype_charge == 1){
                //set charge apply in percent
                return $this->calculateBalanceInPercent($balance,$charges);
            }else if($settype_charge == 2){
                //set charge apply in flat
                return $this->calculateBalanceInFlat($balance,$charges);
            }
        }
    }
    private function calculateBalanceInPercent($balance,$charge){
        return $result = [              
                        'principalAmount'=> $balance,
                        'balance'=>($balance)-(($balance*$charge)/100),
                        'TranCharge'=> (($balance*$charge)/100),              
                      ];
    }
    private function calculateBalanceInFlat($balance,$charge){
        return $result = [              
                        'principalAmount'=> $balance,
                        'balance'=>($balance - $charge),
                        'TranCharge'=> $charge,              
                      ];
    }
}