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
        'location_id',
        'date_sold',
    ];
}
