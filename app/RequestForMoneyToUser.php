<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
use Carbon;
class RequestForMoneyToUser extends Model
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
        'transaction_id',
    ];
    protected $encryptable = [
        'balance',
        'balance_to',
        'currency_requested', 
        'note',
        'transaction_id',
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
