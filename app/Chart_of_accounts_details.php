<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart_of_accounts_details extends Model
{
    protected $fillable = [
        'chart_of_accounts_id',
        'account_name',
        'account_number',
        'principal_id',
    ];
}
