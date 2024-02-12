<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class General_ledger extends Model
{
    protected $fillable = [
        'principal_id',
        'account_name',
        'account_number',
        'debit_record',
        'credit_record',
        'user_id',
        'transaction_date',
        'running_balance',
        'general_account_number',
        'transaction',
        'branch',
        'customer_id',
        'remarks',
    ];

    public function chart_of_account_details()
    {
        return $this->belongsTo('App\Chart_of_accounts_details', 'account_number','account_number');
    }
}
