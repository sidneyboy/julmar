<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiving_draft_main extends Model
{
    protected $fillable = [
            'purchase_order_id',
            'session_id',
            'user_id',
            'status',
    ];

    public function purchase_order()
    {
    	return $this->belongsTo('App\Purchase_order', 'purchase_order_id');
    }

    public function draft_details()
    {
    	return $this->belongsTo('App\Receiving_draft', 'session_id','session_id');
    }
}
