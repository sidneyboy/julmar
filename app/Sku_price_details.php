<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_price_details extends Model
{
    protected $fillable = [
      'sku_id',
      'unit_cost',
      'price_1',
      'price_2',
      'price_3',
      'price_4',
      'price_5',
      'final_unit_cost',
    ];

    public function sku()
    {
    	   return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    
}
