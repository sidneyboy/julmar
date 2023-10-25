<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vs_os_data extends Model
{
    protected $fillable = [
        'export_code',
        'user_id',
        'customer_id',
    ];


    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }


    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
