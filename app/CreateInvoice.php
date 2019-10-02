<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\EncryptableTrait;
//use Carbon;
class CreateInvoice extends Model
{
    use EncryptableTrait; 
    
    protected $fillable = [
        'user_id',
        'invoice_cat_id', 
        'invoice_number',
        'transaction_id',
        'invoice_date',
        'reference', 
        'business_logo',
        'business_name',
        'first_name',
        'address',
        'phone',
        'email_id',
        'due_date_value',
        'bill_to_email',
        'cc_email',
        'notes_to_recepient',
        'terms_and_conditions',
        'attach_file',
        'add_memo_to_self',
        'invoice_subtotal',
        'invoice_discount_in_percent',
        'invoice_discount_in_value',
        'invoice_shipping',
        'invoice_grand_total',
        'currency',
        'tax_id',
        'invoice_status'
    ];
    
    protected $encryptable = [
        'notes_to_recepient',
        'terms_and_conditions',
        'attach_file',
        'add_memo_to_self',
        'transaction_id',
    ];
    
//    public function getCreatedAtAttribute($date)
//    {
//        return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
//    }
//
//    public function getUpdatedAtAttribute($date)
//    {        
//        return Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
//    }
}
