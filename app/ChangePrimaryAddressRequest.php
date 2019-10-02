<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class ChangePrimaryAddressRequest extends Model
{
   use EncryptableTrait; 
   
   protected $fillable = [
        'user_id', 
        'role',       
        'add_line_one',
        'add_line_two',
        'town_or_city',
        'zip',
        'state',
        'country',  
        'address_proof'
    ];
    /**
     * The attributes that should be encrypted .     
     */
    protected $encryptable = [
        'add_line_one',
        'add_line_two',
        'town_or_city',
        'zip',
        'state',
        'country',
        'address_proof'
    ];    

}
