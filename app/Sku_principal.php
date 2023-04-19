<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sku_principal extends Model
{
    protected $fillable = [
        'principal', 'contact_number'
    ];

    public function main_category()
    {
        return $this->hasMany('App\Sku_category', 'principal_id');
    }

    public function principalToSku()
    {
        return $this->hasMany('App\Sku_add', 'principal_id');
    }
    
    public function sku()
    {
        return $this->hasMany('App\Sku_add', 'principal_id');
    }

    public function customer_principal_code()
    {
        return $this->hasMany('App\Customer_principal_code', 'principal_id');
    }
}
