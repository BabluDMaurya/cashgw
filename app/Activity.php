<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
use Carbon;
class Activity extends Model
{
    use EncryptableTrait;  
    
    protected $fillable = [
        'user_id',
        'to_user_id',
        'invoice_id',
        'type',
        'name',
        'email',
        'status',
        'balance',
        'fee',
        'descriptions',
        'transactionid',
        'currency',
        'archieve',
        'showdate',
    ];
    protected $encryptable = [
        'status',
        'balance',
        'fee',
        'descriptions',
    ];
    
    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
    }
}
