<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck_and_sales_invoice_details extends Model
{
    protected $fillable = [
        'truck_si_id',
        'sales_invoice_id',
    ];

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id');
    }

}
