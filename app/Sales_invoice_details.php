<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_details extends Model
{
    protected $fillable = [
        'sales_invoice_id',
        'sku_id',
        'quantity',
        'unit_price',
        'total_amount_per_sku',
        'remarks',
        'agent_id',
        'principal_id',
        'sku_type',
        'kilograms',
        'total_discount_per_sku',
        'quantity_returned',
    ];

    public function sales_invoice_control_sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id')->select('description', 'unit_of_measurement', 'sku_code');
    }

    public function sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function sales_invoice_sku()
    {
        return $this->belongsTo('App\Sku_add', 'sku_id')->select('description', 'sku_type', 'id');
    }

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id');
    }

    public function sales_invoice_delivery_receipt()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id')->select('id','delivery_receipt');
    }
}
