<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_discount extends Model
{
    protected $fillable = [
    	'user_id',
    	'principal_id',
    	'total_discount',
    	'total_bo_allowance_discount',
        'cash_with_order_discount',
    ];

    public function principal_discount_details()
    {
    	 return $this->hasMany('App\Principal_discount_details', 'principal_discount_id');
    }

    public function principal()
    {
    	 return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
