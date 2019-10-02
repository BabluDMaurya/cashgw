<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailOTPCheck extends Model
{
    protected $fillable = [
        'email', 'otp','token'
    ];
    
    protected $hidden = [
        'email', 'otp','token'
    ];
}
