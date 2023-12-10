<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart_of_accounts extends Model
{
    protected $fillable = [
        'account_name',
        'account_number',
    ];
}
