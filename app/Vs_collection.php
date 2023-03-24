<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_collection extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
        'bank',
        'reference',
        'remarks',
    ];
}
