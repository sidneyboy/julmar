<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_withdrawal extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'principal_id',
        'delivery_receipt',
        'total_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function vs_withdrawal_details()
    {
        return $this->hasMany('App\Vs_withdrawal_details', 'vs_withdrawal_id');
    }
}
