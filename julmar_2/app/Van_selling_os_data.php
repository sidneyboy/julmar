<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_os_data extends Model
{
    protected $fillable = [
        'store_name',
        'sku_code',
        'description',
        'quantity',
        'os_unit_price',
        'os_sub_total',
        'os_date',
        'served_quantity',
        'served_unit_price',
        'served_sub_total',
        'served_date',
        'principal',
        'os_code',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
