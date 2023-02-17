<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_upload_ledgers;
use App\Customer;
use App\Location;
use App\Sku_add;
use App\Sku_principal;
use App\customer_principal_price;
use DB;
use Illuminate\Http\Request;

class Van_selling_export_updated_price_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            $principal = Sku_principal::where('principal', '!=', 'NONE')->get();
            return view('van_selling_export_updated_price', [
                'user' => $user,
                'location' => $location,
                'principal' => $principal,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_export_updated_price',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_export_updated_price_generate_customer(Request $request)
    {
        $customer = Customer::select('id', 'store_name')->where('location_id', $request->input('location_id'))->get();

        return view('van_selling_export_updated_price_generate_customer_page', [
            'customer' => $customer,
        ]);
    }

    public function van_selling_export_updated_price_generate_data(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');

        $variable_explode = explode(',', $request->input('customer_id'));
        $customer_id = $variable_explode[0];
        $store_name = $variable_explode[1];

        $van_selling_ledger = DB::table('Van_selling_upload_ledgers')
            ->select('id', 'principal', 'sku_code', 'unit_of_measurement', 'description', 'beg', 'butal_equivalent', 'reference', 'customer_id', 'sku_type', DB::raw('SUM(sales) as total_sales'), DB::raw('SUM(van_load) as total_van_load'))
            ->where('customer_id', $customer_id)
            ->where('principal', $request->input('principal_id'))
            ->groupBy('sku_code')
            ->get();

        $counter = count($van_selling_ledger);

        foreach ($van_selling_ledger as $key => $data) {
            $principal = Sku_principal::select('id')->where('principal', $data->principal)->first();
            $customer_principal_price = Customer_principal_price::select('id', 'price_level')->where('customer_id', $customer_id)->where('principal_id', $principal->id)->first();
            $sku = Sku_add::select('id')->where('sku_code', $data->sku_code)->where('sku_type', 'Butal')->first();

            if ($customer_principal_price->price_level == 'price_1') {
                $price[] = $sku->sku_price_details_one->price_1;
            } else if ($customer_principal_price->price_level == 'price_2') {
                $price[] = $sku->sku_price_details_one->price_2;
            } else if ($customer_principal_price->price_level == 'price_3') {
                $price[] = $sku->sku_price_details_one->price_3;
            } else if ($customer_principal_price->price_level == 'price_4') {
                $price[] = $sku->sku_price_details_one->price_4;
            } else if ($customer_principal_price->price_level == 'price_5') {
                $price[] = $sku->sku_price_details_one->price_5;
            }
        }

        $export_customer_name = preg_replace('/[^A-Za-z0-9\-]/', '', $store_name);

        return view('van_selling_export_updated_price_generate_data_page', [
            'van_selling_ledger' => $van_selling_ledger,
        ])->with('price', $price)
            ->with('counter', $counter)
            ->with('date', $date)
            ->with('time', $time)
            ->with('export_customer_name', $export_customer_name)
            ->with('customer_id', $customer_id);
    }
}
