<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_payment_details extends Model
{
    protected $fillable = [
    	'customer_payment_id',
    	'sales_order_printed_id',
        'customer_id',
    	'amount',
    	'cash_amount',
    	'check_amount',
    	'check_number',
        'check_date',
        'refer_cash_amount',
        'refer_check_amount',
        'refer_check_number',
        'refer_check_date',
        'refer_remarks',
    	'balance',
    	'remarks',
    	'status',
        'or_number',
    ];

    public function sales_order_print()
    {
        return $this->belongsTo('App\Sales_order_print', 'sales_order_printed_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }
}
