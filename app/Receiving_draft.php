<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receiving_draft extends Model
{
    protected $fillable = [
        'sku_id',
        'quantity',
        'remarks',
        'session_id',
        'user_id',
        'freight',
        'unit_cost',
    ];

    public function sku()
    {
    	return $this->belongsTo('App\Sku_add', 'sku_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
    
}
