<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_inventory_ledger extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'principal_id',
        'transaction',
        'sku_id',
        'beginning_inventory',
        'quantity',
        'ending_inventory',
        'unit_price',
        'all_id',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add','sku_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal','principal_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }
}
