<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount_ppmc extends Model
{
     protected $fillable = [
      'principal_id',
      'category_id',
      'trade_discount_1',
      'trade_discount_2',
      'bo_allowance',
      'dste_inc',
      'dizer_allowance',
      'optimix',
    ];

    public function principal()
    {
      return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function category()
    {
      return $this->belongsTo('App\Sku_category', 'category_id');
    }
}
