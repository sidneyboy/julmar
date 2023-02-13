<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_ledger extends Model
{
   protected $fillable = [
      'sku_id',
      'principal_id',
      'category_id',
      'sku_type',
      'in_out_adjustments',
      'rr_dr',
      'sales_order_number',
      'principal_invoice',
      'quantity',
      'running_balance',
      'unit_cost',
      'total_cost',
      'adjustments',
      'running_total_cost',
      'final_unit_cost',
      'transaction_date',
      'user_id',
    ];

    public function sku()
    {
      return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function received_order()
    {
      return $this->belongsTo('App\Received_purchase_order', 'rr_dr');
    }

    
}
