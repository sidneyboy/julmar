<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_price_history extends Model
{
    protected $fillable = [
        'sku_id',
        'unit_cost',
        'price_1',
        'price_2',
        'price_3',
        'price_4',
        'price_5',
    ];
}
