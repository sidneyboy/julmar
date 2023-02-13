<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_printed_details extends Model
{
    protected $fillable = [
		'van_selling_printed_id',
        'customer_id',
    	'sales_order_number',
    	'sku_id',
    	'quantity',
        'butal_quantity',
    	'price',
    	'amount_per_sku',
        'remarks',
    ];

     public function sku()
     {
     	return $this->belongsTo('App\Sku_add', 'sku_id');
     }
}
