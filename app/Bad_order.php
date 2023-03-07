<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bad_order extends Model
{
    protected $fillable = [
        'agent_id',
        'user_id',
        'principal_id',
        'sku_type',
    ];
}
