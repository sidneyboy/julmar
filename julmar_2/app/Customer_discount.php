<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer_discount extends Model
{
      protected $fillable = [
        'principal_id',
        'customer_id',
        'customer_discount',
    ];

     public function principal()
    {
    	return $this->BelongsTo('App\Sku_principal', 'principal_id');
    }
}
