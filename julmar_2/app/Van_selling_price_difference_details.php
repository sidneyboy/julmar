<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_price_difference_details extends Model
{
    protected $fillable = [
        'vs_price_diff_id',
        'sku_id',
        'total_quantity',
        'price',
        'price_update',
        'difference',
    ];
}
