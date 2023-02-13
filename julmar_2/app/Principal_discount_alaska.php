<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount_alaska extends Model
{
    protected $fillable = [
      'principal_id',
      'discount',
      'bo_allowance'
    ];

    public function principal()
    {
      return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
