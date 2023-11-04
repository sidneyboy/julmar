<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
    	'full_name',
    	'location_id',
    	'contact_number',
    	'full_address',
    	'email_address',
    	'user_id',
        'status',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function location()
    {
    	return $this->belongsTo('App\Location', 'location_id');
    }

    public function agent_principal()
    {
    	return $this->hasMany('App\Agent_principal', 'agent_id');
    }



}
