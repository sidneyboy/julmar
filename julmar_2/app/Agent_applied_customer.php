<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent_applied_customer extends Model
{
    protected $fillable = [
    	'agent_id',
    	'location_id',
    	'customer_id',
    	'user_id',
    ];

    public function agent()
    {
      return $this->belongsTo('App\Agent', 'agent_id');
    }

    public function location()
    {
      return $this->belongsTo('App\Location', 'location_id');
    }

    public function customer()
    {
      return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function user()
    {
      return $this->belongsTo('App\user', 'user_id');
    }
}
