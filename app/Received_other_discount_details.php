<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_other_discount_details extends Model
{
    protected $fillable = [
        'received_id',
        'discount_name',
        'discount_rate',
    ];
}
