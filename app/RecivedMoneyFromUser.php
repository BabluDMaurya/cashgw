<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
use Carbon;
class RecivedMoneyFromUser extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'user_id',
        'to',
        'balance',
        'currency_requested',
        'action', 
        'status',
        'note',
    ];
    protected $encryptable = [
        'balance',
        'currency_requested',
        'note',
    ];
    
    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y');
    }
}
