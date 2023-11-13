<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ewt_rate extends Model
{
    protected $fillable = [
        'user_id',
        'ewt_rate',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
