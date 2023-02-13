<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel_add extends Model
{
    protected $fillable = [
      'full_name',
      'personnel_description_id',
      'principal_id',
      'gender',
      'contact_number'

    ];

    public function personnel_description()
	  {
      return $this->belongsTo('App\Personnel_description', 'personnel_description_id');
    }

    public function personnel_details()
    {
        return $this->hasMany('App\Personnel_add_details', 'personnel_id');
    }
}
