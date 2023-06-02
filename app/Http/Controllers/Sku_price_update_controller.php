<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Sku_principal;
use App\Sku_price_details;
use App\Vs_inventory_ledger;
use App\Sku_price_history;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sku_price_update_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('sku_update_price', [
                'user' => $user,
                'principal' => $principal,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_update_price',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sku_update_price_show_sku(Request $request)
    {
        $variable_explode = explode('-', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];

        if ($principal_name == 'EPI') {
            $sku = Sku_add::select('id', 'sku_code', 'description', 'sku_type')->where('principal_id', $principal_id)->get();
        } else {
            $sku = Sku_add::select('id', 'sku_code', 'description', 'sku_type')->where('principal_id', $principal_id)->where('sku_type', 'Case')->get();
        }


        return view('sku_update_price_show_sku', [
            'sku' => $sku,
        ])->with('principal_id', $principal_id);
    }

    public function sku_update_price_generate_price_inputs(Request $request)
    {


        $sku = Sku_add::select('id', 'sku_code', 'description', 'sku_type', 'equivalent_sku_entryNo')->whereIn('sku_code', $request->input('sku'))->where('principal_id', $request->input('principal_id'))->get();

        return view('sku_update_price_generate_price_inputs', [
            'sku' => $sku
        ])->with('principal_id', $request->input('principal_id'));
    }

    public function sku_update_price_save(Request $request)
    {
        //return $request->input();

        //$employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        foreach ($request->input('sku_id') as $key => $sku_id) {

            $unit_cost = str_replace(',', '', $request->input('unit_cost')[$sku_id]);
            $price_1 = str_replace(',', '', $request->input('price_1')[$sku_id]);
            $price_2 = str_replace(',', '', $request->input('price_2')[$sku_id]);
            $price_3 = str_replace(',', '', $request->input('price_3')[$sku_id]);
            $price_4 = str_replace(',', '', $request->input('price_4')[$sku_id]);
            $price_5 = str_replace(',', '', $request->input('price_5')[$sku_id]);

            $checker = Sku_price_details::select('sku_id', 'unit_cost', 'price_1', 'price_2', 'price_3', 'price_4', 'price_5')
                ->where('sku_id', $sku_id)
                ->first();

            if ($checker) {
                $sku_price_history = new Sku_price_history([
                    'sku_id' => $sku_id,
                    'unit_cost' => $checker->unit_cost,
                    'price_1' => $checker->price_1,
                    'price_2' => $checker->price_2,
                    'price_3' => $checker->price_3,
                    'price_4' => $checker->price_4,
                    'price_5' => $checker->price_5,
                ]);

                $sku_price_history->save();

                Sku_price_details::where('sku_id', $sku_id)
                    ->update([
                        'unit_cost' => $unit_cost,
                        'price_1' => $price_1,
                        'price_2' => $price_2,
                        'price_3' => $price_3,
                        'price_4' => $price_4,
                        'price_5' => $price_5,
                    ]);
            } else {
                $price_add = new Sku_price_details([
                    'sku_id'    => $sku_id,
                    'unit_cost' => $unit_cost,
                    'price_1' => $price_1,
                    'price_2' => $price_2,
                    'price_3' => $price_3,
                    'price_4' => $price_4,
                    'price_5' => $price_5,
                ]);
                $price_add->save();

                $sku_price_history = new Sku_price_history([
                    'sku_id'    => $sku_id,
                    'unit_cost' => $unit_cost,
                    'price_1' => $price_1,
                    'price_2' => $price_2,
                    'price_3' => $price_3,
                    'price_4' => $price_4,
                    'price_5' => $price_5,
                ]);

                $sku_price_history->save();
            }

            $agent = Vs_inventory_ledger::select('customer_id')->groupBy('customer_id')->get();

            foreach ($agent as $key => $data) {
                $customer_id = $data->customer_id;
                $ledger_results =  DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_id = '$sku_id' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                if (count($ledger_results)  != 0) {
                    if ($data->customer->customer_principal_price_one->price_level == 'price_1') {
                        $unit_price = str_replace(',', '', $request->input('price_1')[$sku_id]);
                    } elseif ($data->customer->customer_principal_price_one->price_level == 'price_2') {
                        $unit_price = str_replace(',', '', $request->input('price_2')[$sku_id]);
                    } elseif ($data->customer->customer_principal_price_one->price_level == 'price_3') {
                        $unit_price = str_replace(',', '', $request->input('price_3')[$sku_id]);
                    } elseif ($data->customer->customer_principal_price_one->price_level == 'price_4') {
                        $unit_price = str_replace(',', '', $request->input('price_4')[$sku_id]);
                    } elseif ($data->customer->customer_principal_price_one->price_level == 'price_5') {
                        $unit_price = str_replace(',', '', $request->input('price_5')[$sku_id]);
                    }

                    $new_inventory_ledger = new Vs_inventory_ledger([
                        'user_id' => auth()->user()->id,
                        'customer_id' => $customer_id,
                        'principal_id' => $ledger_results[0]->principal_id,
                        'transaction' => 'price update',
                        'sku_id' => $sku_id,
                        'beginning_inventory' => $ledger_results[0]->beginning_inventory,
                        'quantity' => $ledger_results[0]->quantity,
                        'ending_inventory' => $ledger_results[0]->ending_inventory,
                        'unit_price' => $unit_price,
                        'all_id' => 'n/a',
                        'sku_code' => $ledger_results[0]->sku_code,
                    ]);
                    $new_inventory_ledger->save();
                }
            }
        }
    }
}
