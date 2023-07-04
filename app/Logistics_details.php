<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistics_details extends Model
{
    protected $fillable = [
        'logistics_id',
        'principal_id',
        'case',
        'butal',
        'conversion',
        'amount',
        'percentage',
        'equivalent',
        'weight',
    ];

    public function principal()
    {
        return $this->belongsTo('App\Sku_principal', 'principal_id');
    }
}
