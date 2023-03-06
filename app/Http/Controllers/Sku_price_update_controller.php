<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Sku_principal;
use App\Sku_price_details;
use App\Van_selling_upload_ledger;
use SESSION;
use DB;
use App\Customer_principal_price;
use Illuminate\Http\Request;

class Sku_price_update_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
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
        $customer_id = Van_selling_upload_ledger::select('customer_id')->groupBy('customer_id')->get();
        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        foreach ($request->input('sku_id') as $key => $sku_id) {
            $unit_cost = str_replace(',', '', $request->input('unit_cost')[$sku_id]);
            $price_1 = str_replace(',', '', $request->input('price_1')[$sku_id]);
            $price_2 = str_replace(',', '', $request->input('price_2')[$sku_id]);
            $price_3 = str_replace(',', '', $request->input('price_3')[$sku_id]);
            $price_4 = str_replace(',', '', $request->input('price_4')[$sku_id]);
            $price_5 = str_replace(',', '', $request->input('price_5')[$sku_id]);

            $checker = Sku_price_details::select('sku_id')->where('sku_id', $sku_id)->first();

            if ($checker) {
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
            }

            // if ($request->input('sku_type')[$sku_id] == 'BUTAL' or $request->input('sku_type')[$sku_id] == 'Butal' or  $request->input('sku_type')[$sku_id] == 'butal') {
            //     $price_add = new Sku_price_details([
            //         'sku_id'    => $sku_id,
            //         'unit_cost' => $unit_cost,
            //         'price_1' => $price_1,
            //         'price_2' => $price_2,
            //         'price_3' => $price_3,
            //         'price_4' => $price_4,
            //         'price_5' => $price_5,
            //     ]);
            //     $price_add->save();


            //     foreach ($customer_id as $key => $data) {
            //         $customer_id = $data->customer_id;
            //         $sku_code = $request->input('sku_code')[$sku_id];

            //         $van_selling_ledger_latest = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            //         $customer_principal_price = Customer_principal_price::select('id', 'price_level', 'customer_id', 'principal_id')->where('customer_id', $customer_id)->where('principal_id', $request->input('principal_id'))->first();
            //         if ($customer_principal_price['price_level'] == 'price_1') {
            //             if ($van_selling_ledger_latest) {
            //                 if ($van_selling_ledger_latest[0]->end == 0) {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_1;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_1,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 } else {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_1;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_1,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 }
            //             }
            //         } elseif ($customer_principal_price['price_level'] == 'price_2') {
            //             if ($van_selling_ledger_latest) {
            //                 if ($van_selling_ledger_latest[0]->end == 0) {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_2;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_2,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 } else {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_2;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_2,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 }
            //             }
            //         } elseif ($customer_principal_price['price_level'] == 'price_3') {
            //             if ($van_selling_ledger_latest) {
            //                 if ($van_selling_ledger_latest[0]->end == 0) {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_3;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_3,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 } else {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_3;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_3,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 }
            //             }
            //         } elseif ($customer_principal_price['price_level'] == 'price_4') {
            //             if ($van_selling_ledger_latest) {
            //                 if ($van_selling_ledger_latest[0]->end == 0) {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_4;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_4,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 } else {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_4;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_4,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 }
            //             }
            //         } elseif ($customer_principal_price['price_level'] == 'price_5') {
            //             if ($van_selling_ledger_latest) {
            //                 if ($van_selling_ledger_latest[0]->end == 0) {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_5;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_5,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 } else {
            //                     $total = $van_selling_ledger_latest[0]->end * $price_5;
            //                     $van_selling_upload_ledger = new Van_selling_upload_ledger([
            //                         'customer_id' => $customer_id,
            //                         'principal' => $van_selling_ledger_latest[0]->principal,
            //                         'sku_code' => $sku_code,
            //                         'description' => $van_selling_ledger_latest[0]->description,
            //                         'unit_of_measurement' => $van_selling_ledger_latest[0]->unit_of_measurement,
            //                         'sku_type' => $van_selling_ledger_latest[0]->sku_type,
            //                         'butal_equivalent' => $van_selling_ledger_latest[0]->butal_equivalent,
            //                         'reference' => 'PRICE ADJUSTMENTS',
            //                         'beg' => $van_selling_ledger_latest[0]->end,
            //                         'van_load' => 0,
            //                         'sales' => 0,
            //                         'adjustments' => 0,
            //                         'inventory_adjustments' => 0,
            //                         'clearing' => 0,
            //                         'end' => $van_selling_ledger_latest[0]->end,
            //                         'unit_price' => $price_5,
            //                         'total' => $total,
            //                         'running_balance' => $van_selling_ledger_latest[0]->running_balance + $total,
            //                         'date' => $date,
            //                         'remarks' => $employee_name->name,
            //                     ]);

            //                     $van_selling_upload_ledger->save();
            //                 }
            //             }
            //         }
            //     }
            // } else {
            //     $price_add = new Sku_price_details([
            //         'sku_id'    => $sku_id,
            //         'unit_cost' => $unit_cost,
            //         'price_1' => $price_1,
            //         'price_2' => $price_2,
            //         'price_3' => $price_3,
            //         'price_4' => $price_4,
            //         'price_5' => $price_5,
            //     ]);
            //     $price_add->save();
            // }
        }

        return 'saved';






















        // foreach ($request->input('sku_id') as $key => $data) {
        // $van_selling_ledger_latest = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data->sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

        // $unit_cost = str_replace(',', '', $request->input('unit_cost')[$data]);
        // $price_1 = str_replace(',', '', $request->input('price_1')[$data]);
        // $price_2 = str_replace(',', '', $request->input('price_2')[$data]);
        // $price_3 = str_replace(',', '', $request->input('price_3')[$data]);
        // $price_4 = str_replace(',', '', $request->input('price_4')[$data]);
        // $price_5 = str_replace(',', '', $request->input('price_5')[$data]);

        // $price_add = new Sku_price_details([
        //     'sku_id'    => $data,
        //     'unit_cost' => $unit_cost,
        //     'price_1' => $price_1,
        //     'price_2' => $price_2,
        //     'price_3' => $price_3,
        //     'price_4' => $price_4,
        //     'price_5' => $price_5,
        // ]);
        // $price_add->save();  


        // }
        // return 'saved';

    }
}
