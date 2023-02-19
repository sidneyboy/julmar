<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_ar_ledger extends Model
{
      protected $fillable = [
        'customer_id',
        'van_selling_print_id',
        'van_selling_pcm_id',
        'van_selling_payment_id',
        'adjustments',
        'sku_price_adjustments',
        'cm_amount',
        'price_update',
        'actual_stocks_on_hand',
        'charge_payment',
        'amount',
        'collection',
        'over_short',
        'running_balance',
        'should_be',
        'principal_id',
        'user_id',
        'date',
        'remarks',
        'outstanding_balance',
        'vs_inv_adj_id'
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
