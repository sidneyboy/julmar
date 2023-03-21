<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_withdrawal_details extends Model
{
    protected $fillable = [
        'vs_withdrawal_id',
        'sku_id',
        'quantity',
        'unit_price',
        'sku_type',
    ];
}
