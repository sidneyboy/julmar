<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_cost_adjustment_details extends Model
{
    protected $fillable = [
      'invoice_cost_id',
      'sku_id',
      'adjustments',
      'quantity',
      'original_unit_cost',
      'adjusted_amount',
    ];

    public function invoice_cost_adjusment()
    {
    	return $this->belongsTo('App\Invoice_cost_adjustment', 'invoice_cost_id');
    }

    public function sku()
    {
      return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
