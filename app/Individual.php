<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class Individual extends Model
{
    use EncryptableTrait;  
    
    protected $fillable = [
        'user_id','verify', 'kyc','kyc_verify','admin_verify','account_status',
    ];
    
    protected $encryptable = [
        'primary_email',
        'secondary_email',
        'primary_phone',
        'secondary_phone',
        'billing_address_line_one',
        'billing_address_line_two',
        'billing_address_townOrcity',
        'billing_address_zipcode',
        'billing_address_state',
        'billing_address_country',
        'lang',
    ];
    
    public function verifyUser(){
        return $this->hasOne('App\VerifyUser');
    }
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
