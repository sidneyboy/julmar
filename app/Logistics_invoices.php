<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistics_invoices extends Model
{
    protected $fillable = [
        'logistics_id',
        'sales_invoice_id',
        'principal_id',
        'case',
        'butal',
        'conversion',
        'amount',
        'percentage',
        'equivalent',
        'weight',
        'delivered_date',
    ];

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id');
    }

    public function logistics_driver()
    {
        return $this->belongsTo('App\Logistics', 'logistics_id')->select('driver');
    }
}
