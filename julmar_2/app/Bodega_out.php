<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega_out extends Model
{
     protected $fillable = [
      'principal_id',
      'user_id',
      'remarks',
      'date',
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function principal()
    {
    	return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function bodega_out_details()
    {
      return $this->hasMany('App\Bodega_out', 'bodega_out_id');
    }
}
