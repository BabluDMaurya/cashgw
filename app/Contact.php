<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
class Contact extends Model
{
    use EncryptableTrait;    
    protected $encryptable = [
        'name',
        'email',
        'subject',
        'message',
    ];
}
