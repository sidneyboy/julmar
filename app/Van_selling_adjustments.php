<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_adjustments extends Model
{
    protected $fillable = [
        'customer_id',
        'van_selling_printed_id',
        'date',
        'approved_by',
        'user_id',
        'remarks',
    ];

    public function van_selling_adjustments_details()
    {
        return $this->hasMany('App\Van_selling_adjustments_details', 'vs_adjustments_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function van_selling_printed()
    {
        return $this->belongsTo('App\Van_selling_printed', 'van_selling_printed_id');
    }
}
