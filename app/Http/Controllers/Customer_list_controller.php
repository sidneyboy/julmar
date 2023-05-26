<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer_list_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            return view('customer_list', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer_list',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_list_generate_data(Request $request)
    {
        $customer = Customer::where('location_id', $request->input('location_id'))->get();

        return view('customer_list_generate_data', [
            'customer' => $customer,
        ])->with('location_id', $request->input('location_id'));
    }

    public function customer_list_show_map($location_id)
    {
        $customer = Customer::where('location_id', $location_id)->get();

        $customer_map_data = array();
        foreach ($customer as $key => $value) {
            $customer_map_data[] = array(
                "Lon" => $value->longitude,
                "Lat" => $value->latitude,
                "Store_name" => $value->store_name,
                "Store_type" => $value->kind_of_business,
                "Mode_of_transaction" => $value->mode_of_transaction,
                "Address" => $value->detailed_location,
                "Contact_person" => $value->contact_person,
                "Contact_number" => $value->contact_number,
            );
        }

        return view('customer_list_show_map', [
            'customer' => $customer,
            'customer_map_data' => $customer_map_data,
        ]);
    }
}
