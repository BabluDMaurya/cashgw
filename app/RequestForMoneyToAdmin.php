<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
use Carbon;
class RequestForMoneyToAdmin extends Model
{
    use EncryptableTrait;
    protected $fillable = [
        'user_id',
        'balance',
        'currency_requested',
        'admin_action', 
        'status',
        'bankid',
        'bank_name',
        'refcode',
        'transaction_id',
    ];
    protected $encryptable = [
        'balance',
        'currency_requested',
        'refcode',
        'bank_name',
        'bankid',
        'transaction_id'
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
