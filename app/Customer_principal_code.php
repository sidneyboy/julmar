<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_principal_code extends Model
{
    protected $fillable = [
    	'customer_id',
    	'principal_id',
    	'store_code',
        'user_id',
    ];

    public function customer()
    {
        return $this->belongsTo('App\customer', 'customer_id');
    }

    public function customer_data()
    {
        return $this->hasOne('App\customer', 'customer_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\sku_principal', 'principal_id');
    }
}
