<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class ManageItem extends Model
{
  use EncryptableTrait; 
    protected $fillable = [        
        'user_id', 
        'item_name',
        'description',        
        'price',
        'tax_name',
        'rate',
        'invoice_cat_id'        
    ];
    
    protected $encryptable = [
        'item_name', 
        'description',        
        'price'   
    ]; 
}
