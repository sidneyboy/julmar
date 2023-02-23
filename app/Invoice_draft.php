<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_draft extends Model
{
    protected $fillable = [
        'agent',
        'principal_id',
        'customer_id',
        'user_id',
        'mode_of_transaction',
        'sku_type',
        'other_discount',
        'total_amount',
        'delivery_receipt',
        'scanned_by',
        'status',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Customer', 'customer_id');
    }
}
