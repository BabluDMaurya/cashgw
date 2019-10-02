<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class UnRegisterEmail extends Model
{
    use EncryptableTrait; 
   protected $fillable = [
        'table','row_id','user_id','email','mailcount','cname','cvalue',       
    ];
   protected $encryptable = [        
        '',        
    ];
}
