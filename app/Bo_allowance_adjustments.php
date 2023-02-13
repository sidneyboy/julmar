<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bo_allowance_adjustments extends Model
{
     protected $fillable = [
      'received_id',
      'particulars',
      'principal_id',
      'bo_allowance_deduction',
      'vat_deduction',
      'net_deduction',
      'user_id',
      'date'

    ];

    public function received()
    {
    	return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function Bo_allowance_adjustments_details()
    {
      return $this->hasMany('App\Bo_allowance_adjustments_details', 'bo_allowance_id');
    }

     public function bo_jer()
    {
      return $this->hasOne('App\Bo_allowance_adjustments_jer', 'bo_allowance_id');
    }

    public function principal()
    {
      return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
