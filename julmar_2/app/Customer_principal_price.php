<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_principal_price extends Model
{
    protected $fillable = [
    	'customer_id',
    	'principal_id',
    	'price_level',
    	'user_id'
    ];

    public function principal()
    {
    	return $this->BelongsTo('App\Sku_principal', 'principal_id');
    }
}
