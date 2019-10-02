<?php
namespace App\Traits;
use App\Traits\CurrencyConverterAPI;
use App\CashgwCharge;
use App\ConvertionCharge;
//use App\Traits\CalculateBalanceAfterChargeTrait;
trait CurrencyConverter 
{
      use CurrencyConverterAPI;
      public $amount,$ttype;
      public function __construct() {
          $this->amount;
          $this->ttype;
      }
      public function convertionCharge() {
          return ConvertionCharge::select('charge')->where(function($q){
              $q->where('minval','<=' ,$this->amount)->where('maxval','>=' ,$this->amount);                      
          })->first();
      }      
      public function cashgwCharge() {
          return CashgwCharge::select('charge')->where(function($q){
              $q->where('minval','<=' ,$this->amount)->where('maxval','>=' ,$this->amount);                      
          })->first();
      }      
      public function currencyConvert($request){     
          $this->amount = $request->balance;
          $this->ttype = $request->ttype;               
          $charge = $this->transactionCharges($this->ttype);          
          $calresult = $this->calculateBalanceAfterCharge($this->amount,$charge);
          if($calresult['balance'] > 0){
              $responce = $this->single($request->fromcurrency,$request->tocurrency,$calresult['balance']);
              if(isset($responce->getData()->error)){ //currency converter api not working.
                  $data = $this->array_push_assoc($calresult, 'error', $responce->getData()->error);
                  $data = $this->array_push_assoc($calresult, 'error_message', $responce->getData()->message);
                  $data = $this->array_push_assoc($calresult, 'error_status', $responce->getData()->status);
                  return $data;
              }else{
                  return $dataresponce = [
                            'balance' => $request->balance,
                            'amount' => $responce->getData()->amount,
                            'from_currency' => $responce->getData()->from,
                            'to_currency' => $responce->getData()->to,
                            'convertionRate' => $responce->getData()->convertionRate,
                            'canvertion_charge' => $calresult['TranCharge'],
                            'convertedAmount' => $responce->getData()->convertedAmount,
                            'ccstatus' => 'Success',
                        ];
              }
          }else{
             return $this->array_push_assoc($calresult, 'ccstatus', 'Fail');
          }         
      }
      public function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
      }      
}