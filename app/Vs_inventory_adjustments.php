<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_inventory_adjustments extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
    ];
}
