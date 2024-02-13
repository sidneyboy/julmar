<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_order_draft_details extends Model
{
  protected $fillable = [
    'sku_id',
    'sales_order_draft_id',
    'quantity',
  ];

  public function sku()
  {
    return $this->belongsTo('App\Sku_add', 'sku_id');
  }

  public function sku_ledger_latest()
  {
    return $this->hasOne('App\Sku_ledger', 'sku_id', 'sku_id')->select('with_invoice_net_balance')->latest();
  }
}
