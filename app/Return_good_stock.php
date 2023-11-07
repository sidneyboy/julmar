<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_good_stock extends Model
{
    protected $fillable = [
        'delivery_receipt',
        'user_id',
        'principal_id',
        'sku_type',
        'total_amount',
        'pcm_number',
        'customer_id',
        'agent_id',
        'status',
        'verified_date',
        'verified_by',
        'si_id',
        'returned_by',
        'verified_by_name',
    ];

    public function return_good_stock_details()
    {
        return $this->hasMany('App\Return_good_stock_details', 'return_good_stock_id');
    }

    public function return_good_stock_discount()
    {
        return $this->hasMany('App\Return_good_stock_discounts', 'return_good_stock_id')->select('discount_rate');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id')->select('principal');
    }


    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id')->select('store_name');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'si_id');
    }
}
