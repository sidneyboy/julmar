<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales_invoice_status_logs extends Model
{
    protected $fillable = [
        'sales_invoice_id',
        'posted',
        'updated',
        'status',
        'no_of_days',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
