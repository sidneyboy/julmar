<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_inventory_adjustments_details extends Model
{
    protected $fillable = [
        'vs_inv_adj_id',
        'principal',
        'sku_code',
        'description',
        'old_quantity',
        'adjusted_quantity',
        'unit_price',
        'remarks',
    ];
}
