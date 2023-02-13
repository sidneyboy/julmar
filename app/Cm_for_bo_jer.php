<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_bo_jer extends Model
{
    protected $fillable = [
    	'cm_for_bo_id',
    	'sales',
    	'accounts_receivable',
    	'sales_return_and_allowances',
    	'cost_of_sales',
    ];
}
