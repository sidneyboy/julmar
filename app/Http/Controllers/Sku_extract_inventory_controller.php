<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Customer;
use App\Sku_principal;
use App\Customer_principal_price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sku_extract_inventory_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::where('principal', '!=', 'none')->get();
            return view('sku_extract_inventory', [
                'user' => $user,
                'principal' => $principal,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_extract_inventory',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function extract_sku_inventory_generate_data(Request $request)
    {
        //return $request->input();
        if ($request->input('extract_for') == 'REGULAR EXTRACT') {
            $sku = Sku_add::where('principal_id', $request->input('principal'))->get();
            return view('extract_sku_inventory_generate_data', [
                'sku' => $sku,
            ])->with('extract_for', $request->input('extract_for'));
        } elseif ($request->input('extract_for') == 'VAN SELLING') {
            $agent = Customer::select('id', 'store_name')->where('kind_of_business', 'VAN SELLING')->get();
            $principal = Sku_principal::where('principal', '!=', 'none')->get();
            return view('extract_sku_inventory_generate_agent', [
                'agent' => $agent,
                'principal' => $principal,
            ])->with('extract_for', $request->input('extract_for'));
        }
    }

    public function extract_sku_inventory_generate_agent_proceed(Request $request)
    {
        $agent_price_level = Customer_principal_price::select('price_level', 'principal_id')
            ->where('customer_id', $request->input('agent_id'))
            ->whereIn('principal_id', $request->input('principal_id'))
            ->get();

        return view('extract_sku_inventory_generate_agent_proceed', [
            'agent_price_level' => $agent_price_level,
        ]);

        // if ($agent_price_level == 'price_1') {
        //     $price = $sku_price_details->price_1;
        // } else if ($agent_price_level == 'price_2') {
        //     $price = $sku_price_details->price_2;
        // } else if ($agent_price_level == 'price_3') {
        //     $price = $sku_price_details->price_3;
        // } else if ($agent_price_level == 'price_4') {
        //     $price = $sku_price_details->price_4;
        // } else if ($agent_price_level == 'price_5') {
        //     $price = $sku_price_details->price_5;
        // }
    }

    public function extract_sku_inventory_generate_export_data(Request $request)
    {
        return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');
        $sku = Sku_add::findMany($request->input('sku'));
        return view('extract_sku_inventory_generate_export_data', [
            'sku' => $sku
        ])->with('date', $date)
            ->with('time', $time);
    }
}
