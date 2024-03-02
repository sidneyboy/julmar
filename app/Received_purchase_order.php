<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_purchase_order extends Model
{
  protected $fillable = [
    'bo_allowance_discount_rate',
    'principal_id',
    'purchase_order_id',
    'dr_si',
    'truck_number',
    'courier',
    'invoice_date',
    'remarks',
    'date',
    'time',
    'invoice_image',
    'discount_type',
    'scanned_by',
    'finalized_by',
    'branch',
    'gross_purchase',
    'total_less_discount',
    'bo_discount',
    'vatable_purchase',
    'vat',
    'freight',
    'total_final_cost',
    'total_less_other_discount',
    'net_payable',
    'cwo_discount_rate',
    'cwo_discount',
    'payment_status',
  ];

  public function purchase_order()
  {
    return $this->belongsTo('App\Purchase_order', 'purchase_order_id');
  }

  public function return_to_principal()
  {
    return $this->hasMany('App\Return_to_principal', 'received_id');
  }

  public function bo_allowance_adjustment()
  {
    return $this->hasMany('App\Bo_allowance_adjustments', 'received_id');
  }

  public function invoice_cost_adjustment()
  {
    return $this->hasMany('App\Invoice_cost_adjustments', 'received_id');
  }


  public function scanned_by_data()
  {
    return $this->belongsTo('App\User', 'scanned_by');
  }

  public function finalized_data()
  {
    return $this->belongsTo('App\User', 'finalized_by');
  }

  public function received_discount_details()
  {
    return $this->hasMany('App\Received_discount_details', 'received_id');
  }

  public function received_other_discount_details()
  {
    return $this->hasMany('App\Received_other_discount_details', 'received_id');
  }

  public function principal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function received_jer()
  {
    return $this->hasOne('App\Received_jer', 'received_id');
  }

  public function sku_add_details()
  {
    return $this->hasOne('App\Sku_add_details', 'received_id');
  }

  public function received_purchase_order_details()
  {
    return $this->hasMany('App\Received_purchase_order_details', 'received_id');
  }



  public function principal_discount()
  {
    return $this->belongsTo('App\Principal_discount_details', 'discount_id');
  }
}
