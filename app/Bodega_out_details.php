<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega_out_details extends Model
{
  protected $fillable = [
    'bodega_out_id',
    'out_from_sku_id',
    'out_from_quantity',
    'in_to_sku_id',
    'in_to_quantity',

  ];

  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function principal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function bodega_out()
  {
    return $this->belongsTo('App\Bodega_out', 'bodega_out_id');
  }

  public function out_from()
  {
    return $this->belongsTo('App\sku_add', 'out_from_sku_id');
  }

  public function in_to()
  {
    return $this->belongsTo('App\sku_add', 'in_to_sku_id');
  }

  public function equivalent_sku()
  {
    return $this->belongsTo('App\sku_add', 'transfer_to_sku_id');
  }
}
