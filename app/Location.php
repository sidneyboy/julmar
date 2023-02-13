<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
    	'location'
    ];

    public function location_details()
    {
    	return $this->hasMany('App\Location_details', 'location_id');
    }
}
