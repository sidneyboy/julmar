<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warehouse_out_details extends Model
{
    protected $fillable = [
        'warehouse_out_id',
        'sku_id',
        'quantity',
    ];
}
