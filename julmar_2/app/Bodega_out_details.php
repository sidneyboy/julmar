<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega_out_details extends Model
{
    protected $fillable = [
      'bodega_out_id',
      'sku_id',
      'quantity',
      'fuc_prices',
      'transfer_to_sku_id',
      'transfer_quantity',

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

     public function sku()
    {
      return $this->belongsTo('App\sku_add', 'sku_id');
    }

    public function equivalent_sku()
    {
      return $this->belongsTo('App\sku_add', 'transfer_to_sku_id');
    }
}
