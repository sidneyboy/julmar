<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_to_principal extends Model
{
     protected $fillable = [
      'principal_id',
      'received_id',
      'personnel',
      'user_id',
      'gross_purchase',
      'total_less_discount',
      'bo_discount',
      'vatable_purchase',
      'vat',
      'freight',
      'total_final_cost',
      'total_less_other_discount',
      'net_payable',
      'cwo_discount',
      'date',
      'time',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id')->select('principal');
    }

    public function return_to_principal_details()
    {
    	return $this->hasMany('App\Return_to_principal_details', 'return_to_principal_id');
    }

    public function received_purchase_order()
    {
    	return $this->belongsTo('App\Received_purchase_order', 'received_id');
    }

    public function personnel()
    {
    	return $this->belongsTo('App\Personnel_add', 'personnel_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

     public function return_jer()
    {
      return $this->hasOne('App\Return_to_principal_jer', 'return_to_principal_id');
    }

    public function principal_discount()
    {
      return $this->belongsTo('App\Principal_discount', 'discount_id');
    }

   


}
