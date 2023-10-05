<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_add extends Model
{
    protected $fillable = [
      'sku_code',
      'description',
      'category_id',
      'principal_id',
      'unit_of_measurement',
      'minimum_stocking_level',
      'sku_type',
      'equivalent_sku_entryNo',
      'equivalent_butal_pcs',
      'reorder_point',
      'remarks',
      'weight',
      'grams',
      'barcode',
      'sub_category_id',
    ];

    public function skuCategory()
    {
    	return $this->belongsTo('App\Sku_category', 'category_id');
    }

    public function skuPrincipal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function sku_product_details()
    {
      return $this->hasMany('App\Sku_add_details', 'sku_id', 'id');
    }

    public function sku_price_details()
    {
      return $this->hasMany('App\Sku_price_details','sku_id')->orderBy('id','Desc');
    }

    public function sku_price_details_one()
    {
      return $this->hasOne('App\Sku_price_details','sku_id')->orderBy('id','Desc');
    }

    public function sku_price_details_unit_cost()
    {
      return $this->hasOne('App\Sku_price_details','sku_id')->select('unit_cost')->orderBy('id','Desc');
    }

    public function sku_ledger()
    {
      return $this->hasMany('App\Sku_ledger', 'sku_id');
    }

    public function sku_ledger_latest()
    {
      return $this->hasOne('App\Sku_ledger', 'sku_id')->latest();
    }

    public function sku_ledger_get_average_cost()
    {
      return $this->hasOne('App\Sku_ledger', 'sku_id')->select('running_balance','running_amount')->latest();
    }

    public function vs_sku_ledger()
    {
      return $this->hasMany('App\Vs_inventory_ledger', 'sku_id');
    }


    public function sku_ledger_quantity()
    {
      return $this->hasOne('App\Sku_ledger', 'sku_id','id')->latest();
    }

    

    
}
