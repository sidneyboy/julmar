<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bo_allowance_adjustments_details extends Model
{
    protected $fillable = [
      'sku_id',
      'quantity',
      'unit_cost',
      'adjusted_amount',
      'bo_allowance_id',
    ];

    public function sku()
    {
    	return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function bo_allowance_adjustment()
    {
    	return $this->belongsTo('App\bo_allowance_adjustments', 'bo_allowance_id');
    }
}
