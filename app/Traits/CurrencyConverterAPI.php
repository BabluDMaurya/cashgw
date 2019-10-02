<?php
namespace App\Traits;
use Exception;
use AkibTanjim\Currency\Currency;
trait CurrencyConverterAPI{    
    public function rates(){
        $response = Currency::getRates();
        return response()->json($response);
      }

      public function single($basecurrency,$convertcurrency,$amount){
        $response = Currency::convert($basecurrency,$convertcurrency,$amount);
        return response()->json($response);
      }

      public function multiple(){
        $response = Currency::convert('USD',['BDT','JPY','AUD'],10);
        return response()->json($response);
      }
}