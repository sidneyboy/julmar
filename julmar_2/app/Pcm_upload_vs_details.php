<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pcm_upload_vs_details extends Model
{
    protected $fillable = [
    	'pcm_upload_vs_id',
    	'sku_code',
    	'rgs_quantity',
    	'bo_quantity',
    	'unit_price',
    	'remarks',
    ];
}
