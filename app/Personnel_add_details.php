<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel_add_details extends Model
{
    protected $fillable = [
    	'personnel_id',
    	'principal_id'
    ];

    public function principal()
    {
    	 return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
