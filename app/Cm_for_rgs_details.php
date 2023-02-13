<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cm_for_rgs_details extends Model
{
    protected $fillable = [
    	'cm_for_rgs_id',
    	'sku_id',
    	'quantity',
        'price',
    	'remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\sku_add', 'sku_id');
    }
}
