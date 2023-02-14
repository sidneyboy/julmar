<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_purchase_order_details extends Model
{
    protected $fillable = [
        'received_id',
        'sku_id',
        'quantity',
        'unit_cost',
        'freight',
    ];
}
