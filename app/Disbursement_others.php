<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursement_others extends Model
{
    protected $fillable = [
        'payee',
        'transaction_date',
        'invoice_number',
        'check_ref',
        'description',
        'bank',
        'transaction_date_from',
        'transaction_date_to',
        'user_id',
    ];
}
