<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ap_ledger extends Model
{
    protected $fillable = [
        'principal_id',
        'user_id',
        'transaction_date',
        'description',
        'debit_record',
        'credit_record',
        'running_balance',
        'transaction',
        'reference',
        'remarks',
        'close_date',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
