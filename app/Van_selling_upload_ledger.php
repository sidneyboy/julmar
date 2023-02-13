<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_upload_ledger extends Model
{
    protected $fillable = [
        'van_selling_printed_id',
        'vs_upload_id',
    	'customer_id',
    	'principal',
    	'sku_code',
    	'description',
    	'unit_of_measurement',
    	'sku_type',
    	'butal_equivalent',
    	'reference',
    	'beg',
    	'sales',
    	'van_load',
        'adjustments',
        'inventory_adjustments',
        'pcm',
        'clearing',
    	'end',
    	'unit_price',
    	'total',
    	'running_balance',
    	'date',
        'remarks',
    ];

    public function customer()
    {
        return $this->belongsTo('App\customer','customer_id');
    }

    public function vs_upload()
    {
        return $this->belongsTo('App\van_selling_upload','vs_upload_id');
    }
}
