<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Load_sheet extends Model
{
    protected $fillable = [
        'load_sheet_id',
        'agent',
        'customer',
        'customer_id',
        'agent_id',
        'user_id',
        'principal_id',
        'status',
        'date',
    ];
}
