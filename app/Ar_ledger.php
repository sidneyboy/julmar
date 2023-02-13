<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ar_ledger extends Model
{
    protected $fillable = [
    	'customer_id',
    	'sales_order_print_id',
    	'agent_id',
    	'cm_for_bo_id',
    	'cm_for_rgs_id',
    	'customer_payment_details_id',
    	'principal_id',
    	'user_id',
    	'date',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function cm_for_bo()
    {
        return $this->belongsTo('App\cm_for_bo', 'cm_for_bo_id');
    }

    public function cm_for_rgs()
    {
        return $this->belongsTo('App\cm_for_rgs', 'cm_for_rgs_id');
    }

    public function sales_order_print()
    {
        return $this->belongsTo('App\Sales_order_print', 'sales_order_print_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function customer_payment_details()
    {
        return $this->belongsTo('App\Customer_payment_details', 'customer_payment_details_id');
    }
}
