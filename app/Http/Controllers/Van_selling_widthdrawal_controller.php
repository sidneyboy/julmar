<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Sku_add;
use App\Sku_principal;
use App\Van_selling_printed;
use App\Van_selling_upload_ledger;
use App\Customer_ledger;
use App\Location;
use DB;
use App\Sku_ledger;
use App\Van_selling_printed_details;
use App\Customer_principal_price;
use App\Customer_principal_code;
use App\Van_selling_ar_ledger;
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
            $customer = Customer::select('id', 'store_name')->where('location_id', $request->input('location_id'))->get();
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

        $van_selling_ar_ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer'))->get();

        if (is_null($customer_principal_price)) {
            return 'no_customer_principal_code_and_price';
        } else if (count($van_selling_ar_ledger) == 0) {
            return 'no_beginning_ar_ledger';
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

        $customer_principal_price = Customer_principal_price::select('price_level')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal'))->first();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        // $customer_ledger_result = Customer_ledger::where('customer_id', $request->input('customer_id'))->orderBy('id','DESC')->limit(1)->first();
        // $accounts_receivable_previous = $customer_ledger_result->accounts_receivable_end;
        // $accounts_receivable_end = $accounts_receivable_previous + $request->input('total_customer_payable_amount');
        // $credit_line_balance = $customer_ledger_result->credit_line_amount - $accounts_receivable_end;
        // $customer_ledger_save = new Customer_ledger([
        // 	'customer_id' => $request->input('customer_id'),
        // 	'principal_id' => $request->input('principal'),
        // 	'delivery_receipt' => $request->input('delivery_receipt'),
        // 	'store_code' => $request->input('store_code'),
        // 	'sales_order_number' => $request->input('sales_order_number'),
        // 	'transaction_reference' => 'VAN WITHDRAWAL',
        // 	'accounts_receivable_previous' => $accounts_receivable_previous,
        // 	'sales' => $request->input('total_customer_payable_amount'),
        // 	'payment' => 0,
        // 	'bo' => 0,
        // 	'rgs' => 0,
        // 	'adjustments' => 0,
        // 	'accounts_receivable_end' => $accounts_receivable_end,
        // 	'credit_line_amount' => $customer_ledger_result->credit_line_amount,
        // 	'update_credit_line_amount' => 0,
        // 	'credit_line_balance' => $credit_line_balance,
        // 	'date' => $date,

        // ]);

        // $customer_ledger_save->save();

        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        $van_selling_printed_save = new Van_selling_printed([
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal'),
            'sales_order_number' => $request->input('sales_order_number'),
            'mode_of_transaction' => 'VAN SELLING WITHDRAWAL',
            'delivery_receipt' => $request->input('delivery_receipt'),
            'price_level' => $customer_principal_price->price_level,
            'date' => $date,
            'sku_type' => $request->input('dr_sku_type'),
            'total_amount' => $request->input('total_customer_payable_amount'),
            'remarks' => '',

        ]);
        $van_selling_printed_save->save();
        $van_selling_printed_save_last_id = $van_selling_printed_save->id;

        $van_search = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();


        if ($van_search) {
            $over_short = $van_search->over_short + 0;
            $running_balance_new = $van_search->running_balance + $request->input('total_customer_payable_amount');
            $outstanding_balance = $van_search->outstanding_balance + $request->input('total_customer_payable_amount');
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'van_selling_print_id' => $van_selling_printed_save_last_id,
                'principal_id' => $request->input('principal'),
                'user_id' => auth()->user()->id,
                'over_short' => $over_short,
                'amount' => $request->input('total_customer_payable_amount'),
                'running_balance' => $running_balance_new,
                'outstanding_balance' => $outstanding_balance,
                'date' => $date,
            ]);

            $van_selling_ledger_save->save();
        } else {
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'van_selling_print_id' => $van_selling_printed_save_last_id,
                'principal_id' => $request->input('principal'),
                'user_id' => auth()->user()->id,
                'over_short' => 0,
                'amount' => $request->input('total_customer_payable_amount'),
                'running_balance' => $request->input('total_customer_payable_amount'),
                'date' => $date,
            ]);

            $van_selling_ledger_save->save();
        }


        foreach ($request->input('sku') as $key => $data) {
            $explode = explode(',', $data);
            $sku_id = $explode[0];
            $sku_code = $explode[1];

            // $$van_selling_ledger_result = Van_selling_upload_ledger::where('customer_id',$request->input('customer_id'))->where('sku_code',$sku_code)->latest()->first();
            $customer_id = $request->input('customer_id');
            $van_selling_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $counter = count($van_selling_ledger_result);

            if ($counter != 0) {
                if ($request->input('sku_type')[$sku_id] == 'Case' or $request->input('sku_type')[$sku_id] == 'CASE') {
                    $van_load = $request->input('quantity')[$sku_id] * $request->input('equivalent_butal_pcs')[$sku_id];
                    $total_price_case = $request->input('sku_price')[$sku_id] * $van_load;
                    $unit_price = $request->input('sku_price')[$sku_id];

                    $total = $van_load * $unit_price;
                    $running_balance = $van_selling_ledger_result[0]->running_balance + $total;
                    $van_selling_upload_ledger = new Van_selling_upload_ledger([
                        'van_selling_printed_id' => $van_selling_printed_save_last_id,
                        'customer_id' => $request->input('customer_id'),
                        'principal' => $request->input('principal_name'),
                        'sku_code' => $sku_code,
                        'description' => $request->input('description')[$sku_id],
                        'unit_of_measurement' => $request->input('unit_of_measurement')[$sku_id],
                        'sku_type' => $request->input('sku_type')[$sku_id],
                        'butal_equivalent' => $request->input('equivalent_butal_pcs')[$sku_id],
                        'reference' => $request->input('delivery_receipt'),
                        'beg' => $van_selling_ledger_result[0]->end,
                        'van_load' => $van_load,
                        'sales' => 0,
                        'end' => $van_load + $van_selling_ledger_result[0]->end,
                        'unit_price' => $unit_price,
                        'total' => $total,
                        'running_balance' => $running_balance,
                        'remarks' => $employee_name->name,
                        'date' => $date,
                    ]);

                    $van_selling_upload_ledger->save();
                } else {
                    $running_balance = $request->input('quantity')[$sku_id] * $request->input('sku_price')[$sku_id] + $van_selling_ledger_result[0]->running_balance;
                    $van_selling_upload_ledger = new Van_selling_upload_ledger([
                        'van_selling_printed_id' => $van_selling_printed_save_last_id,
                        'customer_id' => $request->input('customer_id'),
                        'principal' => $request->input('principal_name'),
                        'sku_code' => $sku_code,
                        'description' => $request->input('description')[$sku_id],
                        'unit_of_measurement' => $request->input('unit_of_measurement')[$sku_id],
                        'sku_type' => $request->input('sku_type')[$sku_id],
                        'butal_equivalent' => $request->input('equivalent_butal_pcs')[$sku_id],
                        'reference' => $request->input('delivery_receipt'),
                        'beg' => $van_selling_ledger_result[0]->end,
                        'van_load' => $request->input('quantity')[$sku_id],
                        'sales' => 0,
                        'end' => $request->input('quantity')[$sku_id] + $van_selling_ledger_result[0]->end,
                        'unit_price' => $request->input('sku_price')[$sku_id],
                        'total' => $request->input('quantity')[$sku_id] * $request->input('sku_price')[$sku_id],
                        'running_balance' => $running_balance,
                        'remarks' => $employee_name->name,
                        'date' => $date,
                    ]);

                    $van_selling_upload_ledger->save();
                }
            } else {
                if ($request->input('sku_type')[$sku_id] == 'Case' or $request->input('sku_type')[$sku_id] == 'CASE') {
                    $van_load = $request->input('quantity')[$sku_id] * $request->input('equivalent_butal_pcs')[$sku_id];
                    $total_price_case = $request->input('sku_price')[$sku_id] * $van_load;
                    $unit_price = $request->input('sku_price')[$sku_id];

                    $van_selling_upload_ledger = new Van_selling_upload_ledger([
                        'van_selling_printed_id' => $van_selling_printed_save_last_id,
                        'customer_id' => $request->input('customer_id'),
                        'principal' => $request->input('principal_name'),
                        'sku_code' => $sku_code,
                        'description' => $request->input('description')[$sku_id],
                        'unit_of_measurement' => $request->input('unit_of_measurement')[$sku_id],
                        'sku_type' => $request->input('sku_type')[$sku_id],
                        'butal_equivalent' => $request->input('equivalent_butal_pcs')[$sku_id],
                        'reference' => $request->input('delivery_receipt'),
                        'beg' => 0,
                        'van_load' => $van_load,
                        'sales' => 0,
                        'end' => $van_load,
                        'unit_price' => $unit_price,
                        'total' => $van_load * $unit_price,
                        'running_balance' => $van_load * $unit_price,
                        'remarks' => $employee_name->name,
                        'date' => $date,
                    ]);

                    $van_selling_upload_ledger->save();
                } else {
                    $van_selling_upload_ledger = new Van_selling_upload_ledger([
                        'van_selling_printed_id' => $van_selling_printed_save_last_id,
                        'customer_id' => $request->input('customer_id'),
                        'principal' => $request->input('principal_name'),
                        'sku_code' => $sku_code,
                        'description' => $request->input('description')[$sku_id],
                        'unit_of_measurement' => $request->input('unit_of_measurement')[$sku_id],
                        'sku_type' => $request->input('sku_type')[$sku_id],
                        'butal_equivalent' => $request->input('equivalent_butal_pcs')[$sku_id],
                        'reference' => $request->input('delivery_receipt'),
                        'beg' => 0,
                        'van_load' => $request->input('quantity')[$sku_id],
                        'sales' => 0,
                        'end' => $request->input('quantity')[$sku_id],
                        'unit_price' => $request->input('sku_price')[$sku_id],
                        'total' => $request->input('quantity')[$sku_id] * $request->input('sku_price')[$sku_id],
                        'running_balance' => $request->input('quantity')[$sku_id] * $request->input('sku_price')[$sku_id],
                        'remarks' => $employee_name->name,
                        'date' => $date,
                    ]);

                    $van_selling_upload_ledger->save();
                }
            }

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $ledger_running_balance = $ledger_results[0]->running_balance - $request->input('quantity')[$sku_id];
            $ledger_total_cost = $request->input('quantity')[$sku_id] * $ledger_results[0]->final_unit_cost;
            $ledger_running_total_cost = $ledger_results[0]->running_total_cost - $ledger_total_cost;
            $ledger_final_unit_cost = $ledger_running_total_cost / $ledger_running_balance;

            $ledger_add_save = new Sku_ledger([
                'sku_id' => $sku_id,
                'category_id' => $request->input('category_id')[$sku_id],
                'sku_type' => $request->input('sku_type')[$sku_id],
                'principal_id' => $request->input('principal_id_per_sku')[$sku_id],
                'in_out_adjustments' => 'VS withdrawal',
                'rr_dr' => $request->input('delivery_receipt'),
                'sales_order_number' => $request->input('sales_order_number'),
                'principal_invoice' => '',
                'quantity' => ($request->input('quantity')[$sku_id]) * -1,
                'running_balance' => $ledger_running_balance,
                'unit_cost' => $ledger_results[0]->final_unit_cost,
                'total_cost' => ($ledger_total_cost) * -1,
                'adjustments' => 0,
                'running_total_cost' => $ledger_running_total_cost,
                'final_unit_cost' => $ledger_final_unit_cost,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add_save->save();

            $van_selling_printed_details = new Van_selling_printed_details([
                'van_selling_printed_id' => $van_selling_printed_save_last_id,
                'customer_id' => $request->input('customer_id'),
                'sales_order_number' => $request->input('sales_order_number'),
                'sku_id' => $sku_id,
                'quantity' => $request->input('quantity')[$sku_id],
                'butal_quantity' => $request->input('equivalent_butal_pcs')[$sku_id],
                'price' => $request->input('sku_price')[$sku_id],
                'amount_per_sku' => $request->input('final_amount_per_sku')[$sku_id],
                'remarks' => '',
            ]);

            $van_selling_printed_details->save();
        }

        return 'saved';
    }





}
