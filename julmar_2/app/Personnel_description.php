<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personnel_description extends Model
{
      protected $fillable = [
      'personnel_description'
    ];

    

    public function personnel_add()
	  {
      return $this->hasMany('App\Personnel_add', 'personnel_description_id');
    }

}
