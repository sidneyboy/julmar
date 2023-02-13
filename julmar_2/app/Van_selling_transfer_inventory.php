<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_transfer_inventory extends Model
{
    protected $fillable = [
            'customer_id',
            'transfered_amount',
            'user_id',
            'status',
            'date',
    ];

    public function van_selling_transfer_details()
    {
        return $this->hasMany('App\van_selling_transfer_inventory_details','vs_transfer_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\customer','customer_id');
    }
}
