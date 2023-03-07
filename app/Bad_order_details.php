<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bad_order_details extends Model
{
    protected $fillable = [
        'bad_order_id',
        'sku_id',
        'quantity',
        'unit_price',
    ];
}
