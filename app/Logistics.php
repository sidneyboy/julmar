<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logistics extends Model
{
    protected $fillable = [
        'location_id',
        'truck_id',
        'number_of_invoices',
        'driver',
        'contact_number',
        'helper_1',
        'helper_2',
        'total_outlet',
        'loading_date',
        'loading_date_updated_by',
        'departure_date',
        'departure_date_updated_by',
        'arrival_date',
        'arrival_date_updated_by',
        'sg_departure_noted_by',
        'sg_arrival_noted_by',
        'fuel_given_amount',
        'remarks',
        'user_id',
        'trucking_company',
        'total_expense',
        'total_expense_updated_by',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id');
    }

    public function sales_invoice()
    {
        return $this->belongsTo('App\Sales_invoice', 'sales_invoice_id');
    }

    public function truck()
    {
        return $this->belongsTo('App\Truck', 'truck_id');
    }

    public function logistics_details()
    {
        return $this->hasMany('App\Logistics_details', 'logistics_id');
    }

    public function logistics_invoices()
    {
        return $this->hasMany('App\Logistics_invoices', 'logistics_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function loading_date_updated_by_user()
    {
        return $this->belongsTo('App\User', 'loading_date_updated_by');
    }

    public function departure_date_updated_by_user()
    {
        return $this->belongsTo('App\User', 'departure_date_updated_by');
    }

    public function arrival_date_updated_by_user()
    {
        return $this->belongsTo('App\User', 'arrival_date_updated_by');
    }
}
