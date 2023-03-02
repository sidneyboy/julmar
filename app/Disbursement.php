<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'user_id',
        'disbursement',
        'bank',
        'check_deposit_slip',
        'principal_id',
        'amount',
    ];
}
