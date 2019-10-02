<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class TransactionDetail extends Model
{
     use EncryptableTrait; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transactionid',        
    ];
    /**
     * The attributes that should be encrypted .     
     */
    protected $encryptable = [        
        'transactionid',        
    ];
}
