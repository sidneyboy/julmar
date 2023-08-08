<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ap_ledger extends Model
{
    protected $fillable = [
        'principal_id',
        'user_id',
        'transaction_date',
        'description',
        'debit_record',
        'credit_record',
        'running_balance',
        'transaction',
        'reference',
        'remarks',
        'close_date',
    ];
}
