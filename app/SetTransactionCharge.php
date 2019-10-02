<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetTransactionCharge extends Model
{
   protected $fillable = [
        'user_id', 'charge_type',
    ];
}
