<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_ledger extends Model
{
    protected $fillable = [
    	'principal_id',
    	'date',
    	'all_id',
        'principal_invoice',    
    	'transaction',
    	'accounts_payable_beginning',
    	'received',
    	'returned',
    	'adjustment',
    	'payment',
    	'accounts_payable_end',
		'user_id',
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

