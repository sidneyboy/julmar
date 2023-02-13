<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_bo_details extends Model
{
    protected $fillable = [
    	'cm_for_bo_id',
    	'sku_id',
    	'quantity',
        'bo_quantity_expired',
        'category_discount',
    	'price',
    	'bo_amount',
    	'remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\sku_add', 'sku_id');
    }
}
