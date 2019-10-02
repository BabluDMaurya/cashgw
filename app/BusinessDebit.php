<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class BusinessDebit extends Model
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
    ];
    protected $encryptable = [
        'transactionid',
        'name',
        'amount',
        'email', 
        'details',
        'status',
    ];
}
