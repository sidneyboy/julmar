<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_sales extends Model
{
    protected $fillable = [
        'customer_id' ,
        'store_name',
        'vs_upload_id' ,
        'principal' ,
        'sku_code' ,
        'description' ,
        'unit_of_measurement' ,
        'sku_type' ,
        'butal_equivalent' ,
        'reference' ,
        'sales' ,
        'unit_price' ,
        'total' ,
        'date' ,
        'date_sold' ,
        'location',
    ];

    public function van_selling_upload()
    {
        return $this->belongsTo('App\van_selling_upload','vs_upload_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\customer','customer_id');
    }
}
