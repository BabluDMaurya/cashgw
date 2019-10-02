<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class AdminAmountBalanceMaster extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'balance',   
    ];
    protected $encryptable = [
        'balance',
    ];
}
