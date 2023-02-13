<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_pcm extends Model
{
    protected $fillable = [
        'pcm_number',
        'customer_id',
        'remitted_by',
        'store_name',
        'user_id',
        'date',
        'remarks',
        'amount',
        'pcm_type',
    ];

    public function customer()
    {
        return $this->belongsTo('App\customer', 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\user', 'user_id');
    }

    public function van_selling_pcm_details()
    {
        return $this->hasMany('App\van_selling_pcm_details', 'van_selling_pcm_id');
    }
}
