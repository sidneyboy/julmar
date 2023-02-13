<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_category_discount extends Model
{
    protected $fillable = [
    	'customer_id',
    	'principal_id',
    	'category_id',
    	'category_discount_rate'
    ];
}
