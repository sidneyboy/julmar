<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Load_sheet_details extends Model
{
    protected $fillable = [
        'load_sheet_id',
        'sku_id',
        'quantity',
        'unit_price',
    ];
}
