<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bo_allowance_adjustments_jer extends Model
{
     protected $fillable = [
      'bo_allowance_id',
      'dr',
      'cr',
      'date',
    ];

    public function bo_allowance_adjustments()
    {
    	return $this->hasMany('App\Bo_allowance_adjustments', 'bo_allowance_id');
    }
}
