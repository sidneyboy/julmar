<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_calls extends Model
{
    protected $fillable = [
        'customer_id',
        'store_name',
        'address',
        'date',
        'remarks',
    ];

    public function customer()
    {
      return $this->belongsTo('App\Customer', 'customer_id');
    }
}
