<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_os_details extends Model
{
    protected $fillable = [
        'vs_os_id',
        'sku_id',
        'store_name',
        'quantity',
        'date',
        'unit_price',
    ];

    
    public function sku()
    {
    	return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function vs_os()
    {
    	return $this->belongsTo('App\Vs_os_data', 'vs_os_id');
    }
}
