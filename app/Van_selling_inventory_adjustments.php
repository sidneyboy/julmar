<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_inventory_adjustments extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'total_amount',
        'date',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function van_selling_inventory_adjustments_details()
    {
        return $this->hasMany('App\Van_selling_inventory_adjustments_details', 'vs_inv_adj_id');
    }
}
