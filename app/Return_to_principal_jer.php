<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_to_principal_jer extends Model
{
     protected $fillable = [
      'return_to_principal_id',
      'dr',
      'cr',
      'date',
    ];

    public function return_to_principal()
    {
    	return $this->belongsTo('App\Return_to_principal', 'return_to_principal_id');
    }

   
}
