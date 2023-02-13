<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location_details extends Model
{
    protected $fillable = [
    	'location_id',
    	'barangay',
    	'street'
    ];

    public function location()
    {
    	return $this->belongsTo('App\Location', 'location_id');
    }
}
