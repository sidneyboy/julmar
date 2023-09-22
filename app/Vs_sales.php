<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_sales extends Model
{
    protected $fillable = [
        'user_id',
        'principal_id',
        'customer_id',
        'customer_store_name',
        'reference',
        'sku_id',
        'quantity',
        'unit_price',
        'area',
        'location',
        'date_sold',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
