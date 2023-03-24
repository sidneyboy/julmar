<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_pcm_details extends Model
{
    protected $fillable = [
        'vs_pcm_id',
        'sku_id',
        'quantity',
        'unit_price',
        'remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add','sku_id');
    }
}
