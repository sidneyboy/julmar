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
        'customer_id',
        'normal_balance',
    ];

    public function chart_of_accounts()
    {
        return $this->belongsTo('App\Chart_of_accounts', 'chart_of_accounts_id')->select('account_number');
    }

    public function chart_of_accounts_general_account_number()
    {
        return $this->belongsTo('App\Chart_of_accounts', 'chart_of_accounts_id')->select('account_number');
    }
}
