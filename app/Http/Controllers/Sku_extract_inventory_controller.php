<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Customer;
use App\Sku_principal;
use App\Customer_principal_price;
use DB;
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
        } elseif ($request->input('extract_for') == 'BOOKING') {
            $principal_id = $request->input('principal');
            $principal_name = Sku_principal::select('principal')->find($request->input('principal'));
            $sku_ledger = DB::select("SELECT * FROM sku_ledgers WHERE id IN (SELECT MAX(id) FROM sku_ledgers
            WHERE principal_id = '$principal_id' GROUP BY sku_id)");

            if ($sku_ledger) {
                for ($i = 0; $i < count($sku_ledger); $i++) {
                    $description[] = Sku_add::select('sku_code', 'description', 'sku_type', 'id', 'unit_of_measurement')->find($sku_ledger[$i]->sku_id);
                }
                return view('extract_sku_inventory_generate_booking', [
                    'principal_name' => $principal_name,
                    'sku_ledger' => $sku_ledger,
                    'description' => $description,
                ])->with('extract_for', $request->input('extract_for'));
            } else {
                return 'NO QTY SKU LEDGER';
            }
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
    }

    public function extract_sku_inventory_generate_export_data(Request $request)
    {
        //return $request->input();
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
