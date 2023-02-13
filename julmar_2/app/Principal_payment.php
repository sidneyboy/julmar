<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_payment extends Model
{
    protected $fillable = [
    	'principal_id',
    	'payment',
    	'paid_by',
    	'cheque_number',
    	'disbursement_number',
    	'payment',
    	'current_accounts_payable',
    	'date',
    
    ];
}
