<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_order extends Model
{
  protected $fillable = [
      'purchase_id',
      'principal_id',
      'user_id',
      'email',
      'payment_term',
      'delivery_term',
      'sales_order_number',
      'particulars',
      'po_confirmation_image',
      'remarks',
      'date'
    ];

  public function purchaseOrderDetails()
  {
    return $this->hasMany('App\Purchase_order_details', 'purchase_order_id', 'purchase_order_id');
  }

  public function skuPrincipal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  
}
