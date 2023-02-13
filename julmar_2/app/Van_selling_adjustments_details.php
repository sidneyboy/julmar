<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_adjustments_details extends Model
{
    protected $fillable = [
        'vs_adjustments_id',
        'sku_id',
        'original_quantity',
        'adjusted_quantity',
        'price',
        'remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
