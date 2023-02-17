<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Location;
use App\Van_selling_transfer_inventory;
use App\Van_selling_upload_ledger;
use App\Van_selling_ar_ledger;
use DB;
use Illuminate\Http\Request;

class Van_selling_transfer_inventory_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'kind_of_business')->where('kind_of_business', 'VAN SELLING')
                ->where('status', 'UNLOCKED')
                ->get();
            $location = Location::get();
            $van_selling_transfer = Van_selling_transfer_inventory::select('customer_id', 'id', 'transfered_amount')->where('status', 'NOT_YET_TRANSFERED')->get();
            return view('van_selling_transfer_inventory', [
                'user' => $user,
                'customer' => $customer,
                'location' => $location,
                'van_selling_transfer' => $van_selling_transfer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_transfer_inventory',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_transfer_inventory_proceed(Request $request)
    {

        $from_explode = explode('-', $request->input('transfer_from'));
        $transfer_id = $from_explode[0];
        $from_customer_id = $from_explode[1];
        $from_store_name = $from_explode[2];
        $from_transfered_amount = $from_explode[3];

        $to_explode = explode('-', $request->input('transfer_to'));
        $to_customer_id = $to_explode[0];
        $to_store_name = $to_explode[1];

        $van_selling_transfer = Van_selling_transfer_inventory::find($transfer_id);
        return view('van_selling_transfer_inventory_proceed_page', [
            'van_selling_transfer' => $van_selling_transfer,
        ])->with('transfer_id', $transfer_id)
            ->with('from_customer_id', $from_customer_id)
            ->with('from_store_name', $from_store_name)
            ->with('from_transfered_amount', $from_transfered_amount)
            ->with('to_customer_id', $to_customer_id)
            ->with('to_store_name', $to_store_name)
            ->with('remarks', $request->input('remarks'));
    }

    public function van_selling_transfer_inventory_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        Van_selling_transfer_inventory::where('id', $request->input('transfer_id'))
            ->update(['status' => 'DONE_TRANSFER']);

        //return $request->input('total_transfer');
        $customer_id = $request->input('to_customer_id');
        $van_search = Van_selling_ar_ledger::where('customer_id', $customer_id)->latest()->first();
        if ($van_search) {
            $running_balance = round($request->input('total_transfer'), 2) + $van_search->running_balance;
            $van_over_short = $van_search->over_short;
        } else {
            $running_balance = round($request->input('total_transfer'), 2);
            $van_over_short = 0;
        }


        $van_selling_ledger_save = new Van_selling_ar_ledger([
            'customer_id' => $customer_id,
            'vs_inv_clear_id' => '',
            'adjustments' => round($request->input('total_transfer'), 2),
            'inventory_adjustments' => 0,
            'cm_amount' => 0,
            'price_update' => 0,
            'actual_stocks_on_hand' => 0,
            'charge_payment' => 0,
            'clearing' => 0,
            'amount' => 0,
            'collection' => 0,
            'over_short' => $van_over_short,
            'running_balance' => $running_balance,
            'outstanding_balance' => $running_balance,
            'should_be' => 0,
            'user_id' => auth()->user()->id,
            'date' => $date,
            'remarks' => $request->input('remarks'),
        ]);

        $van_selling_ledger_save->save();



        foreach ($request->input('sku_code') as $key => $data) {
            $sku_ledger_data = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


            if (count($sku_ledger_data) != 0) {
                $beg = $sku_ledger_data[0]->end;
                $end = $request->input('quantity')[$data] + $sku_ledger_data[0]->end;
                $total = $request->input('quantity')[$data] * $request->input('unit_price')[$data];
                $sku_running_balance = $sku_ledger_data[0]->running_balance + $total;
                $van_selling_upload_ledger = new Van_selling_upload_ledger([
                    'customer_id' => $customer_id,
                    'principal' => $request->input('principal')[$data],
                    'sku_code' => $data,
                    'description' => $request->input('description')[$data],
                    'unit_of_measurement' => $request->input('unit_of_measurement')[$data],
                    'sku_type' => $request->input('sku_type')[$data],
                    'butal_equivalent' => $request->input('butal_equivalent')[$data],
                    'reference' => 'TRANSFERED INVENTORY',
                    'beg' => $beg,
                    'van_load' => $request->input('quantity')[$data],
                    'sales' => 0,
                    'adjustments' => 0,
                    'clearing' => 0,
                    'end' => $end,
                    'unit_price' => $request->input('unit_price')[$data],
                    'total' => $total,
                    'running_balance' => $sku_running_balance,
                    'date' => $date,
                    'remarks' => $request->input('from_store_name'),


                ]);

                $van_selling_upload_ledger->save();
            } else {
                //echo $sku_ledger_data[0]->sku_code;
                $van_selling_upload_ledger = new Van_selling_upload_ledger([
                    'customer_id' => $customer_id,
                    'principal' => $request->input('principal')[$data],
                    'sku_code' => $data,
                    'description' => $request->input('description')[$data],
                    'unit_of_measurement' => $request->input('unit_of_measurement')[$data],
                    'sku_type' => $request->input('sku_type')[$data],
                    'butal_equivalent' => $request->input('butal_equivalent')[$data],
                    'reference' => 'TRANSFERED INVENTORY',
                    'beg' => 0,
                    'van_load' => $request->input('quantity')[$data],
                    'adjustments' => 0,
                    'sales' => 0,
                    'clearing' => 0,
                    'end' => $request->input('quantity')[$data],
                    'unit_price' => $request->input('unit_price')[$data],
                    'total' => $request->input('quantity')[$data] * $request->input('unit_price')[$data],
                    'running_balance' => $request->input('quantity')[$data] * $request->input('unit_price')[$data],
                    'date' => $date,
                    'remarks' => $request->input('from_store_name'),
                ]);

                $van_selling_upload_ledger->save();
            }
        }

        return 'saved';
    }
}
