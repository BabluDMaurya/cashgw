<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class BankDetails extends Model
{
    use EncryptableTrait; 
    
    protected $fillable = [
        'bank', 
        'bankcode',
        'ifsc',
        'branch',
        'currency',
        'acno',
        'name',
        'address',  
    ];
    
    protected $encryptable = [
//        'bank', 
//        'bankcode',
//        'ifsc',
//        'branch',
//        'currency',
//        'acno',
//        'name',
//        'address',
    ]; 
}
