<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_ar_ledger extends Model
{
      protected $fillable = [
       'customer_id',
       'user_id',
       'principal_id',
       'transaction',
       'all_id',
       'running_balance',
       'amount',
       'short',
       'outstanding_balance',
       'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    public function van_selling_printed()
    {
        return $this->belongsTo('App\van_selling_printed', 'van_selling_print_id');
    }

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    } 
}
