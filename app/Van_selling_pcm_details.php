<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_pcm_details extends Model
{
    protected $fillable = [
        'van_selling_pcm_id',
        'sku_code',
        'principal',
        'description',
        'quantity',
        'unit_price',
        'remarks',
    ];
}
