<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetPercentTransactionCharge extends Model
{
   protected $appends = ['type'];
   protected $fillable = [
        'user_id', 'charge','transaction_type',
    ];
   public function getTypeAttribute(){
        return 'car';
    }
}
