<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class BusinessTotalTransaction extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'user_id',
        'transactionid',
        'name',
        'amount',
        'email', 
        'details',
        'status',
        'tstatus',
        'archieve',
    ];
    protected $encryptable = [
        'transactionid',
        'name',
        'amount',
        'email', 
        'details',
        'status',
        'tstatus',
    ];
}
