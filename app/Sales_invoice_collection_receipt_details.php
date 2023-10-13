<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_collection_receipt_details extends Model
{
    protected $fillable = [
        'sicrd_id',
        'si_id',
        'ar_balance',
        'amount_collected',
        'outstanding_balance',
        'remarks',
    ];
}
