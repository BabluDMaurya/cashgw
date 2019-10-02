<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class BusinessKyc extends Model
{
    use EncryptableTrait; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'business_certificate',
        'business_memorandum',
        'business_fname',
        'business_lname',
        'business_address',
        'business_phone',
        'business_fax',
        'business_email',
        'business_website',
        'business_taxid',
        'business_additional_info',
        'fname',
        'mname',
        'lname',
        'dob',
        'passport_no',
        'passport_country',
        'passport_expdate',
        'passport',
        'add_line_one',
        'add_line_two',
        'town_or_city',
        'zip',
        'state',
        'country',
        'address_proof',
        'photo',
    ];
    /**
     * The attributes that should be encrypted .     
     */
    protected $encryptable = [
        'business_name',
        'business_type',
        'business_certificate',
        'business_memorandum',
        'business_fname',
        'business_lname',
        'business_address',
        'business_phone',
        'business_fax',
        'business_email',
        'business_website',
        'business_taxid',
        'business_additional_info',
        'fname',
        'mname',
        'lname',
        'dob',
        'passport_no',
        'passport_country',
        'passport_expdate',
        'passport',
        'add_line_one',
        'add_line_two',
        'town_or_city',
        'zip',
        'state',
        'country',
        'address_proof',
        'photo',
    ];
    
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
