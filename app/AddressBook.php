<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class AddressBook extends Model
{
    use EncryptableTrait; 
    
    protected $fillable = [
        'user_id', 
        'email',
        'fname',       
        'lname',
        'phone',
        'business_name',
        'country',
        'additional_information',
        'billing_add_country',
        'billing_address_line_one',
        'billing_address_line_two',
        'billing_address_town_city',
        'billing_address_state',
        'billing_address_zipcode',
        'shipping_address_fname',
        'shipping_address_lname',
        'shipping_address_business_name',
        'shipping_address_country',
        'shipping_address_line_one',
        'shipping_address_line_two',
        'shipping_address_town_city',
        'shipping_address_state',
        'shipping_address_zipcode',
        'customer_memo'
        
    ];
    
    protected $encryptable = [
        'fname',
        'lname',
        'phone',
        'business_name',
        'country',
        'additional_information',
        'billing_add_country',
        'billing_address_line_one',
        'billing_address_line_two',
        'billing_address_town_city',
        'billing_address_state',
        'billing_address_zipcode',
        'shipping_address_fname',
        'shipping_address_lname',
        'shipping_address_business_name',
        'shipping_address_country',
        'shipping_address_line_one',
        'shipping_address_line_two',
        'shipping_address_town_city',
        'shipping_address_state',
        'shipping_address_zipcode',
        'customer_memo'
    ]; 
}
