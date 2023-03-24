<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_pcm extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'principal_id',
        'total_amount',
        'reference',
        'status',
        'pcm_type',
        'store_name',
        'remitted_by',
        'posted_by',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\sku_principal','principal_id');
    }

    public function pcm_details()
    {
        return $this->hasMany('App\Vs_pcm_details','vs_pcm_id');
    }
}
