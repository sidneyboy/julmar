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

    public function chart_of_accounts()
    {
        return $this->belongsTo('App\Chart_of_accounts', 'chart_of_accounts_id')->select('account_number');
    }
}
