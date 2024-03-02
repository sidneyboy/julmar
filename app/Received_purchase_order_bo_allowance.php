<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_purchase_order_bo_allowance extends Model
{
    protected $fillable = [
        'received_id',
        'bo_allowance',
        'sku_id',
    ];
}
