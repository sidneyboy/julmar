<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart_of_accounts extends Model
{
    protected $fillable = [
        'account_name',
        'account_number',
        'principal',
    ];

    public function chart_of_accounts_details()
    {
        return $this->hasMany('App\Chart_of_accounts_details', 'chart_of_accounts_id');
    }

    public function chart_of_accounts_details_latest()
    {
        return $this->hasOne('App\Chart_of_accounts_details', 'chart_of_accounts_id')->orderBy('id','desc')->first();
    }
}
