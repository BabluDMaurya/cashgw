<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
use Carbon;
class SendMoneyToUser extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'user_id',
        'from',
        'balance',
        'balance_to',
        'currency_requested',
        'action', 
        'status',
        'note',
    ];
    protected $encryptable = [
        'balance_to',
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
