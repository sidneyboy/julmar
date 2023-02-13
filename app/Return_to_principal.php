<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_to_principal extends Model
{
     protected $fillable = [
      'principal_id',
      'received_id',
      'discount_id',
      'personnel_id',
      'user_id',
      'remarks',
      'date',
      'total_amount_return',
      'return_vatable_purchase',
      'return_less_discount',
      'return_net_discount',
      'return_vat_amount',
      'return_net_of_deduction',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function received()
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
