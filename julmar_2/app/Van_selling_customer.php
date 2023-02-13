<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Van_selling_customer extends Model
{
    protected $fillable = [
        'location_id',
        'store_name',
        'store_type',
        'barangay',
        'address',
        'contact_person',
        'contact_number',
        'latitude',
        'longitude',
    ];

    public function location()
    {
        return $this->BelongsTo('App\Location', 'location_id');
    }
}
