<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistics_upload extends Model
{
    protected $fillable = [
        'logistics_id',
        'sales_invoice_id',
        'date',
        'delivered_date',
    ];

    public function logistics_driver()
    {
        return $this->belongsTo('App\Logistics', 'logistics_id')->select('driver');
    }

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id')->select('delivery_receipt','customer_id','principal_id','total','cm_amount_deducted','cm_for_confirmation_amount','agent_id','total_payment');
    }
}
