<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_upload extends Model
{
    protected $fillable = [
    	'van_selling_export_code',
    	'date',
    	'customer_id',
    	'date_range',
    ];

    public function vs_upload_ledger()
    {
        return $this->hasMany('App\van_selling_upload_ledger','vs_upload_id');
    }
}
