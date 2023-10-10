<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice extends Model
{
    protected $fillable = [
        'customer_id',
        'principal_id',
        'agent_id',
        'mode_of_transaction',
        'sku_type',
        'sales_order_number',
        'status',
        'user_id',
        'discount_rate',
        'delivery_receipt',
        'total',
        'cancelled_date',
        'cancelled_by',
        'approved_by',
        'sales_order_draft_id',
        'total_weight',
        'logistic_status',
        'sales_invoice_printed',
        'control',
        'customer_discount',
        'total_payment',
        'payment_status',
        'truck_load_status',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function sales_invoice_agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id')->select('full_name');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function sales_invoice_customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id')->select('store_name','location_id','kind_of_business');
    }

    public function sales_order()
    {
        return $this->belongsTo('App\Sales_order_draft', 'sales_order_draft_id');
    }

    public function sales_invoice_details()
    {
        return $this->hasMany('App\Sales_invoice_details', 'sales_invoice_id');
    }

    public function sales_invoice_status_logs()
    {
        return $this->hasMany('App\Sales_invoice_status_logs', 'sales_invoice_id')->orderBy('id','desc');
    }

}
