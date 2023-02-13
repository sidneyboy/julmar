<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcm_upload_details extends Model
{
    protected $fillable = [
    	'pcm_upload_id',
    	'sku_id',
    	'rgs_quantity',
    	'bo_quantity',
    	'unit_price',
    	'remarks',
    ];

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }
}
