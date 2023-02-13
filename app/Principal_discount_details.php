<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount_details extends Model
{
    protected $fillable = [
    	'principal_discount_id',
    	'discount_name',
    	'discount_rate'
    ];
}	
