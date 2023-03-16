<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    protected $fillable = [
        'user_id',
        'disbursement',
        'bank',
        'check_deposit_slip',
        'principal_id',
        'amount',
        'payee',
        'amount_in_words',
        'title',
        'debit',
        'credit',
        'particulars',
        'cv_number',
        'remarks',
    ];
}
