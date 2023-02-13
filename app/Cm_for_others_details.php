<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_others_details extends Model
{
    protected $fillable = [
    	'cm_for_others_id',
    	'sku_id',
    	'quantity',
    	'price',
    	'amount',
    	'remarks'
    ];
}
