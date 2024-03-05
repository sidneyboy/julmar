<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_to_principal_details extends Model
{
    protected $fillable = [
      'return_to_principal_id',
      'sku_id',
      'quantity_return',
      'unit_cost',
      'freight',
      'bo_discount',
    ];

    public function return_to_principal()
    {
    	return $this->belongsTo('App\Return_to_principal', 'return_to_principal_id');
    }

    public function sku()
    {
    	return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
