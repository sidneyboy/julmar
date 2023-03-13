<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_order extends Model
{
  protected $fillable = [
    'purchase_id',
    'principal_id',
    'user_id',
    'payment_term',
    'delivery_term',
    'van_number',
    'particulars',
    'po_confirmation_image',
    'remarks',
    'status',
    'sku_type',
    'gross_purchase',
    'total_less_discount',
    'bo_discount',
    'vatable_purchase',
    'vat',
    'freight',
    'total_final_cost',
    'total_less_other_discount',
    'net_payable',
    'discount_type',
    'bo_allowance_discount_rate',
  ];

  public function purchaseOrderDetails()
  {
    return $this->hasMany('App\Purchase_order_details', 'purchase_order_id', 'purchase_order_id');
  }

  public function purchase_order_details()
  {
    return $this->hasMany('App\Purchase_order_details', 'purchase_order_id');
  }

  public function skuPrincipal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function purchase_order_discount_details()
  {
    return $this->hasMany('App\Purchase_order_discount_details', 'purchase_order_id');
  }

  public function purchase_order_other_discount_details()
  {
    return $this->hasMany('App\Purchase_order_other_discount_details', 'purchase_order_id');
  }
}
