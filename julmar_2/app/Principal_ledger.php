<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Principal_ledger extends Model
{
    protected $fillable = [
    	'principal_id',
    	'date',
    	'rr_dr',
        'principal_invoice',    
    	'transaction',
    	'accounts_payable_beginning',
    	'received',
    	'returned',
    	'adjustment',
       
    	'payment',
    	'accounts_payable_end',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}

