<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultTransactionCharge extends Model
{
    protected $fillable = [
        'charge', 'transaction_type','charge_type',
    ];
}
