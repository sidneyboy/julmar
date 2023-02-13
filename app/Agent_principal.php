<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent_principal extends Model
{
    protected $fillable = [
    	'agent_id',
    	'principal_id',
    ];

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
