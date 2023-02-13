<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_price_difference extends Model
{
    protected $fillable = [
        'van_selling_printed_id',
        'principal_id',
        'user_id',
        'total_price_difference',
        'date',
    ];
}
