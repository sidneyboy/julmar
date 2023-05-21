<?php

namespace App\Http\Controllers;

use App\Van_selling_customer;
use App\User;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Van_selling_customer_list_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            // $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();
            $location = Location::get();
            return view('van_selling_customer_list', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_customer_list',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_customer_list_show_data(Request $request)
    {
        $customer = Van_selling_customer::where('location_id', $request->input('location_id'))->get();

        return view('van_selling_customer_list_show_data', [
            'customer' => $customer,
        ])->with('location_id', $request->input('location_id'));
    }

    public function van_selling_customer_list_show_map($location_id)
    {
        $customer = Van_selling_customer::where('location_id', $location_id)->get();

        $customer_map_data = array();
        foreach ($customer as $key => $value) {
            $customer_map_data[] = array(
                "Lon" => $value->longitude,
                "Lat" => $value->latitude,
                "Store_name" => $value->store_name,
                "Store_type" => $value->store_type,
                "Barangay" => $value->barangay,
                "Address" => $value->address,
                "Contact_person" => $value->contact_person,
                "Contact_number" => $value->contact_number,
            );
        }

        return view('van_selling_customer_list_show_map', [
            'customer' => $customer,
            'customer_map_data' => $customer_map_data,
        ]);
    }
}
