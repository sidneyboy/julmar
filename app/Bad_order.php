<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bad_order extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'principal_id',
        'sku_type',
        'total_amount',
        'pcm_number',
        'customer_id',
        'status',
        'verified_date',
        'verified_by',
    ];

    public function bad_order_details()
    {
        return $this->hasMany('App\Bad_order_details', 'bad_order_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
