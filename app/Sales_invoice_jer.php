<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_jer extends Model
{
    protected $fillable = [
        'sales_invoice_id',
        'debit_record_ar',
        'credit_record_sales',
        'debit_record_cost_of_sales',
        'credit_record_inventory',
    ];
}
