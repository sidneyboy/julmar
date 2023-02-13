<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Received_jer extends Model
{
    protected $fillable = [
      'principal_id',
      'received_id',
      'dr',
      'cr',
      'date',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_ids');
    }

    public function received_purchase_order()
    {
      return $this->belongsTo('App\received_purchase_order', 'received_id');
    }
}
