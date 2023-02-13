<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_helper_charge extends Model
{
     protected $fillable = [
    	'driver_3rdman_id',
    	'amount',
    	'date',
    	'remarks',
    	'user_id',
    ];
}
