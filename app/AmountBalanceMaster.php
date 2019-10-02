<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class AmountBalanceMaster extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'user_id',
        'balance',
        'currency_requested',
        'admin_request',       
    ];
    protected $encryptable = [
        'balance',
        'currency_requested',
        'admin_request',
    ];
}
