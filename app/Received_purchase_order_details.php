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
        'quantity_returned',
        'final_unit_cost',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function received_purchase_order()
    {
        return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }
}
