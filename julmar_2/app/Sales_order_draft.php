<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_order_draft extends Model
{
  protected $fillable = [
    'customer_id',
    'principal_id',
    'agent_id',
    'mode_of_transaction',
    'sku_type',
    'sales_order_number',
    'status',
    'user_id',
  ];

  public function principal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function agent()
  {
    return $this->belongsTo('App\Agent', 'agent_id');
  }

  public function customer()
  {
    return $this->belongsTo('App\Customer', 'customer_id');
  }

  public function sales_order_draft_details()
  {
    return $this->hasMany('App\Sales_order_draft_details', 'sales_order_draft_id');
  }
}
