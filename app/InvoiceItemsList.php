<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemsList extends Model
{
    protected $fillable = [
        'create_invoice_id',
        'invoice_number',
        'item_name', 
        'item_desc',
        'item_quantity',
        'item_price',
        'item_tax_id', 
        'item_amount',
    ];
}
