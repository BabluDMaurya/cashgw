<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class CurrencyConvertionTransaction extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'transactionId','user_id','fromCurrency','toCurrency','rate','amount','convertedAmount','canvertionCharge',
//        'cashgwCharge'
    ];
    protected $encryptable = [
        'transactionId','fromCurrency','toCurrency','rate','amount','convertedAmount','canvertionCharge',
//        'cashgwCharge'
    ];
}
