<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_purchase_order_inv_cost extends Model
{
    protected $fillable = [
        'received_id',
        'invoice_cost',
        'sku_id',
    ];
}
