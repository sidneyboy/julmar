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

    public function location_van_selling_sales()
    {
    	return $this->belongsTo('App\Location', 'location_id')->select('location');
    }
}
