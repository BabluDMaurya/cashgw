<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConvertionCharge extends Model
{
   protected $fillable = [
        'charge', 'minval', 'maxval',
    ];
}
