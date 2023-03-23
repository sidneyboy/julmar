<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Sku_add;
use App\Sku_principal;
use App\Van_selling_printed;

use App\Location;
use App\Van_selling_ar_ledger;
use App\Vs_withdrawal;
use App\Vs_withdrawal_details;
use App\Customer_principal_price;
use App\Customer_principal_code;
use App\Vs_inventory_ledger;
use DB;
use Illuminate\Http\Request;

class Van_selling_widthdrawal_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $location = Location::select('id', 'location')->get();
            return view('van_selling_withdrawal', [
                'user' => $user,
                'principal' => $principal,
                'location' => $location,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_withdrawal',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_generate_sku(Request $request)
    {
        // return $request->input();
        if (is_null($request->input('location_id')) or is_null($request->input('sku_type'))) {
            return 'no_location';
        } else {
            $customer = Customer::select('id', 'store_name')->where('kind_of_business', 'VAN SELLING')->where('location_id', $request->input('location_id'))->get();
            $sku = Sku_add::select('id', 'sku_code', 'description')->where('principal_id', $request->input('principal'))->where('sku_type', $request->input('sku_type'))->get();
            return view('van_selling_generate_sku', [
                'sku' => $sku,
            ])->with('customer', $customer)
                ->with('price_level', $request->input('price_level'));
        }
    }

    public function van_selling_generate_sku_quantity(Request $request)
    {
        //return $request->input();
        $explode = explode(',', $request->input('principal'));
        $principal_id = $explode[0];
        $principal_name = $explode[1];

        $sku = Sku_add::select('id', 'sku_code', 'description', 'sku_type', 'principal_id', 'category_id', 'equivalent_sku_entryNo', 'equivalent_butal_pcs')->findMany($request->input('sku'));

        foreach ($sku as $key => $data) {
            $sku_butal[$data->id] = Sku_add::find($data->equivalent_sku_entryNo);
        }


        $customer_principal_price = Customer_principal_price::select('id', 'price_level')->where('customer_id', $request->input('customer'))->where('principal_id', $principal_id)->first();

        // $van_selling_ar_ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer'))->get();

        if (is_null($customer_principal_price)) {
            return 'no_customer_principal_code_and_price';
        } else {
            return view('van_selling_generate_sku_quantity', [
                'sku' => $sku,
                'sku_butal' => $sku_butal
            ])
                ->with('customer', $request->input('customer'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('location_id', $request->input('location_id'))
                ->with('customer_principal_price', $customer_principal_price);
        }
    }

    public function van_selling_generate_final_summary(Request $request)
    {


        //return $request->input();
        foreach ($request->input('sku') as $key => $data) {
            if ($request->input('quantity')[$data] > $request->input('running_balance')[$data]) {
                return 'quantity_is_greater';
            }
        }

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');


        $delivery_receipt = strtoupper($request->input('delivery_receipt'));
        $dr_filter = Van_selling_printed::select('delivery_receipt')->where('delivery_receipt', $delivery_receipt)->first();

        if ($dr_filter) {
            return 'existing';
        } else {
            $sales_order_number = "VS-" . $request->input('customer_id') . "-" . $request->input('principal_id') . "-" . $date . "" . $time;
            $customer = Customer::where('id', $request->input('customer_id'))->first();
            $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal_id'))->first();
            $sku = Sku_add::findMany($request->input('sku'));
            return view('van_selling_generate_final_summary', [
                'sku' => $sku,
            ])
                ->with('customer', $customer)
                ->with('price_level', $request->input('price_level'))
                ->with('description', $request->input('description'))
                ->with('sku_code', $request->input('sku_code'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('principal', $request->input('principal_id'))
                ->with('principal_name', $request->input('principal_name'))
                ->with('delivery_receipt', $delivery_receipt)
                ->with('quantity', $request->input('quantity'))
                ->with('sales_order_number', $sales_order_number)
                ->with('customer_principal_code', $customer_principal_code)
                ->with('price_butal', $request->input('price_butal'))
                ->with('price_case', $request->input('price_case'))
                ->with('equivalent_butal_pcs', $request->input('equivalent_butal_pcs'));
        }
    }

    public function van_selling_save(Request $request)
    {
        //return $request->input();
        $customer_id = $request->input('customer_id');
        $new_withdrawal_saved = new Vs_withdrawal([
            'user_id' => auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal'),
            'delivery_receipt' => $request->input('delivery_receipt'),
            'total_amount' => $request->input('total_customer_payable_amount'),
        ]);

        $new_withdrawal_saved->save();

        foreach ($request->input('sku') as $key => $data) {
            $new_details = new Vs_withdrawal_details([
                'vs_withdrawal_id' => $new_withdrawal_saved->id,
                'sku_id' => $data,
                'quantity' => $request->input('quantity')[$data],
                'unit_price' => $request->input('sku_price')[$data],
                'sku_type' => $request->input('sku_type')[$data],
                'sku_code' => $request->input('sku_code')[$data],
            ]);

            $new_details->save();


            $ledger_results =  DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_id = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);


            if ($count_ledger_row > 0) {
                $new_inventory_ledger = new Vs_inventory_ledger([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $request->input('customer_id'),
                    'principal_id' => $request->input('principal'),
                    'transaction' => 'withdrawal',
                    'sku_id' => $data,
                    'beginning_inventory' => $ledger_results[0]->ending_inventory,
                    'quantity' => $request->input('quantity')[$data],
                    'ending_inventory' => $ledger_results[0]->ending_inventory + $request->input('quantity')[$data],
                    'unit_price' => $request->input('sku_price')[$data],
                    'all_id' => $new_withdrawal_saved->id,
                    'sku_code' => $request->input('sku_code')[$data],
                ]);
                $new_inventory_ledger->save();
            } else {
                $new_inventory_ledger = new Vs_inventory_ledger([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $request->input('customer_id'),
                    'principal_id' => $request->input('principal'),
                    'transaction' => 'withdrawal',
                    'sku_id' => $data,
                    'beginning_inventory' => 0,
                    'quantity' => $request->input('quantity')[$data],
                    'ending_inventory' => $request->input('quantity')[$data],
                    'unit_price' => $request->input('sku_price')[$data],
                    'all_id' => $new_withdrawal_saved->id,
                    'sku_code' => $request->input('sku_code')[$data],
                ]);
                $new_inventory_ledger->save();
            }
        }


        $ar_checker = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->orderBy('id', 'desc')->limit(1)->first();

        if ($ar_checker) {
            $running_balance = $ar_checker->outstanding_balance;
            $outstanding_balance = $running_balance + $request->input('total_customer_payable_amount');
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal'),
                'transaction' => 'withdrawal',
                'all_id' => $new_withdrawal_saved->id,
                'running_balance' => $running_balance,
                'amount' => $request->input('total_customer_payable_amount'),
                'short' => 0,
                'outstanding_balance' => $outstanding_balance,
                'remarks' => 'n/a',
            ]);

            $van_selling_ledger_save->save();
        } else {
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal'),
                'transaction' => 'withdrawal',
                'all_id' => $new_withdrawal_saved->id,
                'running_balance' => 0,
                'amount' => $request->input('total_customer_payable_amount'),
                'short' => 0,
                'outstanding_balance' => $request->input('total_customer_payable_amount'),
                'remarks' => 'n/a',
            ]);

            $van_selling_ledger_save->save();
        }
    }
}
