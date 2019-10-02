<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\CurrencyConvertionTransaction;
use App\TransactionDetail;
trait TransactionIdTrait{
    public function createCCID(){
                $tdata = CurrencyConvertionTransaction::orderBy('id', 'DESC')->first();
                if(empty($tdata)){
                    $tId = 1;
                }else{
                    $tId = ($tdata->id) + 1;
                }   
        return config('constants.CCID').str_pad($tId.$this->currentdate(), 16, '0', STR_PAD_LEFT);
    }   
    public function createTID(){
            $tdata = TransactionDetail::orderBy('id', 'DESC')->first();                            
            if(empty($tdata)){
                $tId = 1;
            }else{
                $tId = ($tdata->id) + 1;
            }            
            $lastid = TransactionDetail::create([
                'transactionid'=>config('constants.TID').str_pad($tId.$this->currentdate(), 16  , '0', STR_PAD_LEFT),
            ]);
        return $lastid->transactionid;
    }
    public function currentdate() {
        return $datetime = strtotime(date('Y-m-d H:i:s'));
    }
}

