<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck_and_sales_invoice extends Model
{
    protected $fillable = [
        'truck_id',
        'driver',
        'assistant',
        'user_id',
       'departure_date',
       'departure_time',
       'arrival_date',
       'arrival_time',
    ];

    public function truck()
    {
        return $this->belongsTo('App\Truck', 'truck_id');
    }

    public function truck_and_sales_invoice_details()
    {
        return $this->hasMany('App\Truck_and_sales_invoice_details', 'truck_si_id');
    }
}
