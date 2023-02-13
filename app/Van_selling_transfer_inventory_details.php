<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_transfer_inventory_details extends Model
{
    protected $fillable = [
        'vs_transfer_id',
        'sku_code',
        'principal',
        'description',
        'sku_type',
        'butal_equivalent',
        'unit_of_measurement',
        'quantity',
        'unit_price',
    ];
}
