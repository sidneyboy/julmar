<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_collection_receipt extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'agent_id',
        'check_ref_cash',
        'official_receipt',
        'bank',
        'payment_date',
    ];
}
