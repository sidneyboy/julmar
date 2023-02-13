<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_beginning extends Model
{
    protected $fillable = [
        'customer_id',
        'date',
        'user_id',
    ];
}
