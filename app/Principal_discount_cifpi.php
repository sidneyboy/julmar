<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount_cifpi extends Model
{
      protected $fillable = [
      'principal_id',
      'category_id',
      'discount1',
      'discount2',
      'discount3',
      'discount4',
      'discount5',
      'discount6',
      'bo_allowance'
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
