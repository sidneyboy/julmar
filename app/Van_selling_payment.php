<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_payment extends Model
{
    protected $fillable = [
    	'customer_id',
    	'cash_cheque',
    	'bank_name',
    	'cheque_number',
    	'cheque_date',
    	'remitted_by',
    	'date',
    	'user_id',
    ];
}
