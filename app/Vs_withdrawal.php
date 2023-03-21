<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'principal_id',
        'delivery_receipt',
        'total_amount',
        'status',
    ];
}
