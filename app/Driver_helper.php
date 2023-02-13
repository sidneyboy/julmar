<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver_helper extends Model
{
    protected $fillable = [
    	'full_name',
    	'contact_number',
    	'full_address',
    	'truck_unit_number',
    	'work_description',
    	'user_id',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }
}
