<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount_gci extends Model
{
     protected $fillable = [
      // 'discount_id',
      'principal_id',
      'logistics_fee',
      'selling_fee',
      'cwo_discount',
      'bo_discount',
      'vmi_discount',
      'per_category_sell_discount',
      'total_sell_discount',
      'dops_discount',
      'dbs_discount',
      'reach',
      'shelf_management_discount',
      'display_allowance',
      'bleach_management_project',
      'business_development_fund_discount',
      'others'
    ];

    public function principal()
    {
      return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

}
