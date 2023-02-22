<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_cost_adjustments extends Model
{
  protected $fillable = [
    'principal_id',
    'received_id',
    'particulars',
    'gross_purchase',
    'total_less_discount',
    'bo_discount',
    'vatable_purchase',
    'vat',
    'freight',
    'total_final_cost',
    'total_less_other_discount',
    'net_payable',
    'user_id',


  ];

  public function received_purchase_order()
  {
    return $this->belongsTo('App\Received_purchase_order', 'received_id');
  }

  public function invoice_cost_jer()
  {
    return $this->hasOne('App\Invoice_cost_adjustments_jer', 'invoice_cost_id');
  }


  public function principal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function invoice_cost_adjustment_details()
  {
    return $this->hasMany('App\invoice_cost_adjustment_details', 'invoice_cost_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }
}
