<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_inventory_clearing extends Model
{
    protected $fillable = [
        'customer_id',
        'vs_ar_ending_balance',
        'vs_inventory_running_balance',
        'adjustments',
        'total_adjustments',
        'date',
    ];
}
