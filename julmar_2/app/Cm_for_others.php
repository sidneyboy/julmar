<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_others extends Model
{
    protected $fillable = [
    	'customer_id',
    	'total_amount',
    	'personnel_id',
    	'status',
    	'created_by',
    	'approved_by',
    	'transaction_remarks',
    ];
}
