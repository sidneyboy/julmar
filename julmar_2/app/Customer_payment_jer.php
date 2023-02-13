<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_payment_jer extends Model
{
    protected $fillable = [
    	'customer_payment_id',
    	'cash_cheque',
    	'accounts_receivable',
    ];
}
