<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_good_stock_discounts extends Model
{
    protected $fillable = [
        'return_good_stock_id',
        'discount_rate',
    ];
}
