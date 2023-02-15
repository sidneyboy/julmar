<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_purchase_order extends Model
{
     protected $fillable = [
      'discount_id',
      'principal_id',
      'purchase_order_id',
      'dr_si',
      'truck_number',
      'courier',
      'invoice_date',
      'remarks',
      'date',
      'invoice_image',
      'discount_type',
      'scanned_by',
      'finalized_by',
      'branch'
    ];

    public function purchase_order()
    {
    	return $this->belongsTo('App\Purchase_order', 'purchase_order_id');
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
      return $this->hasOne('App\Received_purchase_order_details', 'received_id');
    }

    public function bo_allowance_adjustment()
    {
      return $this->hasOne('App\Bo_allowance_adjustments', 'received_id');
    }

    public function principal_discount()
    {
      return $this->hasMany('App\Principal_discount_details', 'principal_discount_id','principal_discount_id');
    }
}
