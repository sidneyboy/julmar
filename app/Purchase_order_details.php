<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_order_details extends Model
{
    protected $fillable = [
      'purchase_order_id',
      'sku_id',
      'quantity',
      'receive',
      'unit_cost',
      'remarks',
      'scanned_remarks',
      'freight',
      'final_unit_cost',
    ];

   public function purchaseOrderDetailsID()
   {
   	return $this->belongsTo('App\Purchase_order', 'purchase_order_id');
   }

   public function sku()
   {
    return $this->belongsTo('App\Sku_add', 'sku_id');
   }

   public function sku_price_details()
   {
    return $this->belongsTo('App\Sku_price_details', 'sku_id', 'sku_id');
   }

    public function sku_price_details_one()
    {
      return $this->hasOne('App\Sku_price_details','sku_id', 'sku_id')->latest();
    }

}
