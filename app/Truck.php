<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'plate_no',
        'capacity',
        'model',
        'status',
    ];
}
