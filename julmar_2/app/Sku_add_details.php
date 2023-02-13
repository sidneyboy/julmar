<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_add_details extends Model
{
    protected $fillable = [
      'received_id',
      'sku_id',
      'quantity_per_sku',
      'quantity_return_per_sku',
      'quantity_bodega_out',
      'unit_cost_per_sku',
      'final_total_cost_per_sku',
      'bo_allowance_discount_per_sku',
      'bo_allowance_discount_rate_per_sku',
      'final_unit_cost_per_sku',
      'freight_per_sku',
      'discount_rate_per_sku',
      'expiration_date',
      'remarks',
      

    ];

    public function sku()
    {
    	return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function received_purchase_order()
    {
    	return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }

    
}
