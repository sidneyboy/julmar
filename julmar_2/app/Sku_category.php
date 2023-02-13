<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_category extends Model
{
  protected $fillable = [
    'category',
    'principal_id',
  ];

  public function categoryToSku()
  {
    return $this->hasMany('App\Sku_add');
  }

  public function principal()
  {
    return $this->belongsTo('App\Sku_principal', 'principal_id');
  }

  public function sub_category()
  {
    return $this->hasMany('App\Sku_sub_category', 'main_category_id');
  }

  public function category_to_principal_discount_cifpi()
  {
    return $this->hasMany('App\Principal_discount_cifpi', 'category_id');
  }

  public function category_to_principal_discount_ppmc()
  {
    return $this->hasMany('App\Principal_discount_ppmc', 'category_id');
  }
}
