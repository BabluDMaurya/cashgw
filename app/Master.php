<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class Master extends Model
{
    
     use EncryptableTrait;
     
    protected $fillable = [
        'user_id',
        'verify',
        'kyc',
        'kyc_verify',
        'admin_verify',
        'account_status',
        
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
        
        'euro_balance',
        'usd_balance',
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
        
        'euro_balance',
        'usd_balance',
    ];
}
