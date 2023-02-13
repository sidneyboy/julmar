<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_payment_details extends Model
{
     protected $fillable = [
    	'van_selling_payment_id',
    	'van_selling_printed_id',
    	'amount',
    	'balance',
    	'remarks',
    	'status',
    ];
}
