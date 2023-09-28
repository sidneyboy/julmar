<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_accounts_receivable extends Model
{
    protected $fillable = [
        'user_id',
        'principal_id',
        'customer_id',
        'transaction',
        'all_id',
        'debit_record',
        'credit_record',
        'running_balance',
    ];
}
