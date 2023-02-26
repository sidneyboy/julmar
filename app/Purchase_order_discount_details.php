<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase_order_discount_details extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'discount_name',
        'discount_rate',
    ];
}
