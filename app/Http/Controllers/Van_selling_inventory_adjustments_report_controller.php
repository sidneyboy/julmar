<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Van_selling_inventory_adjustments;
use Illuminate\Http\Request;

class Van_selling_inventory_adjustments_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'kind_of_business')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_inventory_adjustments_report', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_inventory_adjustments_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_inventory_adjustments_report_generate_data(Request $request)
    {
        //return $request->input();

        $data_range = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($data_range[0]));
        $date_to = date('Y-m-d', strtotime($data_range[1]));
        $customer_data = explode('-', $request->input('customer'));
        $customer_id = $customer_data[0];
        $store_name = $customer_data[1];

        $van_selling_inventory_adjustments = Van_selling_inventory_adjustments::whereBetween('date', [$date_from, $date_to])
            ->where('customer_id', $customer_id)
            ->get();

        return view('van_selling_inventory_adjustments_report_generate_data', [
            'van_selling_inventory_adjustments' => $van_selling_inventory_adjustments,
        ])->with('date_from', $date_from)
            ->with('date_to', $date_to)
            ->with('customer_data', $customer_data)
            ->with('customer_id', $customer_id)
            ->with('store_name', $store_name);
    }
}
