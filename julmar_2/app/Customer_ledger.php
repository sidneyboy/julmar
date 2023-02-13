<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_ledger extends Model
{
    protected $fillable = [
        'customer_payment_id',
         'van_selling_payment_id',
    	'customer_id',
    	'principal_id',
        'delivery_receipt',
    	'sales_order_number',
    	'transaction_reference',
        'accounts_receivable_previous',
    	'sales',
        'payment',
        'bo',
        'rgs',
        'adjustments',
        'payment',
        'accounts_receivable_end',
    	'credit_line_amount',
        'update_credit_line_amount',
    	'credit_line_balance',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

     public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }



}
