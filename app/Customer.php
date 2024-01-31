<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'store_name',
        'location_id',
        'detailed_location',
        'contact_person',
        'credit_term',
        'credit_line_amount',
        'contact_number',
        'kind_of_business',
        'max_number_of_transactions',
        'mode_of_transaction',
        'status',
        'longitude',
        'latitude',
        'allowed_number_of_sales_order',
        'location_details_id',
        'account_number',
    ];

    public function location()
    {
    	return $this->BelongsTo('App\Location', 'location_id');
    }

    public function location_details()
    {
    	return $this->BelongsTo('App\Location_details', 'location_id');
    }

    public function customer_discount()
    {
        return $this->hasMany('App\customer_discount', 'customer_id')->orderBy('principal_id');
    }

    public function customer_principal_price()
    {
        return $this->hasMany('App\customer_principal_price', 'customer_id');
    }

     public function customer_principal_price_one()
    {
        return $this->hasOne('App\customer_principal_price', 'customer_id');
    }

    public function customer_ledger_credit_line_balance()
    {
        return $this->hasOne('App\customer_ledger', 'customer_id')->latest();
    }

    public function customer_principal_code()
    {
        return $this->hasMany('App\customer_principal_code', 'customer_id');
    }


    
}
