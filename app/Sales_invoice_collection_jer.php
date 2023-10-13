<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_collection_jer extends Model
{
    protected $fillable = [
        'sicrd_id',
        'debit_record',
        'credit_record',
    ];
}
