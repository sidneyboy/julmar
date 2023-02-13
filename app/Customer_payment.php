<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_payment extends Model
{
    protected $fillable = [
        'remitted_by',
    	'date',
    	'user_id',
    ];
}
