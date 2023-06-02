<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bad_order_discounts extends Model
{
    protected $fillable = [
        'bad_order_id',
        'discount_rate',
    ];
}
