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
        'po_rr_id',
        'amount_payable',
        'transaction',
        'payable_amount',
        'ewt_amount',
        'net_payable',
        'amount_paid',
        
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
