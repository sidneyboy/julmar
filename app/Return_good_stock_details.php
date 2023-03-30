<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_good_stock_details extends Model
{
    protected $fillable = [
        'return_good_stock_id',
        'sku_id',
        'quantity',
        'unit_price',
        'confirmed_quantity',
        'remarks',
        'scanned_by',
        'user_id',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
