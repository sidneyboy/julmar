<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Sales_order_draft;
use App\Sales_order_draft_details;
use App\Sales_invoice;
use App\Sales_invoice_details;
use App\Customer_discount;
use App\Customer_principal_price;
use App\Sales_order_print;
use App\Sales_order_print_details;
use App\Customer_principal_code;
use App\Customer_ledger;
use App\Sku_ledger;
use App\Sales_order_print_jer;
use App\Sales_order_print_jer_details;
use App\Customer;
use App\Ar_ledger;
use App\Location;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Sales_order_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('sales_order', [
                'user' => $user,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'sales_order_migrate',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sales_order_upload(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $fileName = $_FILES["agent_csv_file"]["tmp_name"];
        $csv = array();

        if (($handle = fopen($fileName, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }

        //return $csv;

        $counter = count($csv);

        if ($csv[1][0] == "NEW CUSTOMER") {
            if ($csv[0][9] == 'SO') {
                $sales_order_number_check = Sales_order_draft::where('sales_order_number', $csv[1][9])->count();
                if ($sales_order_number_check == 0) {
                    $new_customer = new Customer([
                        'store_name' => $csv[1][1],
                        'location_id' => $csv[3][4],
                        'detailed_location' => $csv[3][5],
                        'contact_person' => $csv[3][1],
                        'credit_term' => 15,
                        'credit_line_amount' => 0,
                        'contact_number' => $csv[3][2],
                        'kind_of_business' => $csv[3][0],
                        'max_number_of_transactions' => 1,
                        'mode_of_transaction' => 'COD',
                        'status' => 'Pending Approval',
                        'longitude' => $csv[3][6],
                        'latitude' => $csv[3][7],
                    ]);

                    $new_customer->save();

                    $sales_order_save = new Sales_order_draft([
                        'customer_id' => $new_customer->id,
                        'sales_order_number' => $csv[1][9],
                        'agent_id' => $csv[1][4],
                        'principal_id' => $csv[1][2],
                        'mode_of_transaction' => $csv[1][6],
                        'sku_type' => $csv[1][7],
                        'status' => 'draft',
                        'user_id' => auth()->user()->id,
                    ]);

                    $sales_order_save->save();

                    for ($i = 5; $i < $counter; $i++) {
                        $sales_order_details = new Sales_order_draft_details([
                            'sales_order_draft_id' => $sales_order_save->id,
                            'sku_id' => $csv[$i][1],
                            'quantity' => $csv[$i][4],
                        ]);

                        $sales_order_details->save();
                    }
                    //return redirect('sales_order')->with('success', 'Success');
                } else {
                    return 'file_already_uploaded';
                }
            } else {

                return 'incorrect_file_uploaded';
            }
        } else {
            if ($csv[0][9] == 'SO') {
                $sales_order_number_check = Sales_order_draft::where('sales_order_number', $csv[1][9])->count();
                if ($sales_order_number_check != 0) {
                    return 'file_already_uploaded';
                } else {
                    $sales_order_save = new Sales_order_draft([
                        'customer_id' => $csv[1][0],
                        'sales_order_number' => $csv[1][9],
                        'agent_id' => $csv[1][4],
                        'principal_id' => $csv[1][2],
                        'mode_of_transaction' => $csv[1][6],
                        'sku_type' => $csv[1][7],
                        'status' => 'draft',
                        'user_id' => auth()->user()->id,
                    ]);

                    $sales_order_save->save();

                    for ($i = 3; $i < $counter; $i++) {
                        $sales_order_details = new Sales_order_draft_details([
                            'sales_order_draft_id' => $sales_order_save->id,
                            'sku_id' => $csv[$i][1],
                            'quantity' => $csv[$i][4],
                        ]);

                        $sales_order_details->save();
                    }

                    return 'saved';
                }
            } else {
                return 'incorrect_file_uploaded';
            }
        }
    }

    public function sales_order_draft()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $sales_order_draft = Sales_order_draft::where('status', 'draft')->get();
            return view('sales_order_draft', [
                'user' => $user,
                'sales_order_draft' => $sales_order_draft,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'sales_order_draft',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sales_order_draft_generate(Request $request)
    {
        $sales_order_draft = Sales_order_draft::find($request->input('sales_order_id'));

        $customer_check = Customer::find($sales_order_draft->customer_id);

        if ($customer_check->status == "Pending Approval") {
            $location = Location::select('id', 'location')->where('id', '!=', $customer_check->location_id)->get();
            $customer_principal_code = Customer_principal_code::where('customer_id', $customer_check->id)->where('principal_id', $sales_order_draft->principal_id)->first();
            $customer_principal_price = Customer_principal_price::where('customer_id', $customer_check->id)->where('principal_id', $sales_order_draft->principal_id)->first();
            return view('sales_order_draft_update_customer', [
                'customer_check' => $customer_check,
                'customer_principal_code' => $customer_principal_code,
                'customer_principal_price' => $customer_principal_price,
                'sales_order_draft' => $sales_order_draft,
                'location' => $location,
            ]);
        } else {
            $customer_principal_price = Customer_principal_price::select('price_level')->where('customer_id', $sales_order_draft->customer_id)
                ->where('principal_id', $sales_order_draft->principal_id)->first();


            $customer_discount = Customer_discount::select('id', 'customer_discount')->where('customer_id', $sales_order_draft->customer_id)
                ->where('principal_id', $sales_order_draft->principal_id)
                ->get();

            $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $sales_order_draft->customer_id)
                ->where('principal_id', $sales_order_draft->principal_id)->first();

            return view('sales_order_draft_generate_page', [
                'sales_order_draft' => $sales_order_draft,
                'customer_discount' => $customer_discount,
                'customer_principal_price' => $customer_principal_price,
                'customer_principal_code' => $customer_principal_code,
            ]);
        }
    }

    public function sales_order_draft_proceed_to_final_summary(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('h:i:s a');
        $date_receipt = date('Y-m');



        $sales_invoice = Sales_invoice::select('delivery_receipt')->latest()->first();
        $sku_type = strtoupper($request->input('sku_type'));

        if (!is_null($sales_invoice)) {
            // $sales_invoice->delivery_receipt;
            $var_explode = explode('-', $sales_invoice->delivery_receipt);
            $year_and_month = $var_explode[1] . "-" . $var_explode[2];
            $series = $var_explode[3];

            if ($sku_type == 'BUTAL') {
                if ($date_receipt != $year_and_month) {
                    $delivery_receipt = $request->input('principal') . "B-" . $date_receipt  . "-0001";
                } else {
                    $delivery_receipt = $request->input('principal') . "B-" . $date_receipt . "-" . str_pad($series + 1, 4, 0, STR_PAD_LEFT);
                }
            } else {
                if ($date_receipt != $year_and_month) {
                    $delivery_receipt = $request->input('principal') . "C-" . $date_receipt  . "-0001";
                } else {
                    $delivery_receipt = $request->input('principal') . "C-" . $date_receipt . "-" . str_pad($series + 1, 4, 0, STR_PAD_LEFT);
                }
            }
        } else {
            if ($sku_type == 'BUTAL') {
                $delivery_receipt = $request->input('principal') . "B-" . $date_receipt  . "-0001";
            } else {
                $delivery_receipt = $request->input('principal') . "C-" . $date_receipt  . "-0001";
            }
        }

        $discount_checker = $request->input('customer_discount');

        if (isset($discount_checker)) {
            $customer_discount = $request->input('customer_discount');
        } else {
            $customer_discount[] = 0;
        }

        $sales_order_draft = Sales_order_draft::find($request->input('sales_order_id'));


        return view('sales_order_draft_proceed_to_final_summary', [
            'sales_order_draft' => $sales_order_draft,
            'delivery_receipt' => $delivery_receipt,
            'sku_type' => $sku_type,
            'mode_of_transaction' => $request->input('mode_of_transaction'),
            'customer_discount' => $request->input('customer_discount'),
            'agent_id' => $request->input('agent_id'),
            'principal_id' => $request->input('principal_id'),
            'customer_principal_price' => $request->input('customer_principal_price'),
            'final_quantity' => $request->input('final_quantity'),
            'customer_principal_code' => $request->input('customer_principal_code'),
            'unit_price' => $request->input('unit_price'),
            'customer_discount' => $request->input('customer_discount'),
            'customer_id' => $request->input('customer_id'),
        ]);
    }

    public function sales_order_draft_save(Request $request)
    {
        //return $request->input();

        $discount_checker = $request->input('discount_rate');
        if (isset($discount_checker)) {
            $discount_rate = implode('-', $request->input('discount_rate'));
        } else {
            $discount_rate = 'none';
        }
        $sales_invoice_save = new Sales_invoice([
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal_id'),
            'agent_id' => $request->input('agent_id'),
            'mode_of_transaction' => $request->input('mode_of_transaction'),
            'sku_type' => strtoupper($request->input('sku_type')),
            'sales_order_number' => $request->input('sales_order_number'),
            'status' => 'invoice',
            'user_id' => auth()->user()->id,
            'discount_rate' => $discount_rate,
            'total' => $request->input('final_total'),
            'delivery_receipt' => $request->input('delivery_receipt'),
            'sales_order_draft_id' => $request->input('sales_order_draft_id'),
            'customer_discount' => $request->input('customer_discount'),
        ]);

        $sales_invoice_save->save();

        foreach ($request->input('sku_id') as $key => $data) {
            $sales_invoice_details = new Sales_invoice_details([
                'sales_invoice_id' => $sales_invoice_save->id,
                'sku_id' => $data,
                'quantity' => $request->input('final_quantity')[$data],
                'unit_price' => $request->input('unit_price')[$data],
                'total_amount_per_sku' => $request->input('total_amount_per_sku')[$data],
                'agent_id' => $request->input('agent_id'),
                'principal_id' => $request->input('principal_id'),
                'sku_type' => strtoupper($request->input('sku_type')),
            ]);

            $sales_invoice_details->save();
        }

        $so_draft_update = Sales_order_draft::find($request->input('sales_order_draft_id'));
        $so_draft_update->status = 'invoice';
        $so_draft_update->save();


        return 'saved';
    }

    public function sales_order_draft_update_customer_process(Request $request)
    {
        Customer::where('id', $request->input('customer_id'))
            ->update([
                'store_name' => strtoupper($request->input('store_name')),
                'location_id' => strtoupper($request->input('location_id')),
                'detailed_location' => str_replace(',', ' ', strtoupper($request->input('detailed_location'))),
                'contact_person' => strtoupper($request->input('contact_person')),
                'credit_term' => strtoupper($request->input('credit_term')),
                'credit_line_amount' => str_replace(',', '', strtoupper($request->input('credit_line_amount'))),
                'contact_number' => strtoupper($request->input('contact_number')),
                'kind_of_business' => strtoupper($request->input('kind_of_business')),
                'max_number_of_transactions' => strtoupper($request->input('max_number_of_transactions')),
                'mode_of_transaction' => strtoupper($request->input('mode_of_transaction')),
                'status' => "Pending Approval",
                'longitude' => strtoupper($request->input('longitude')),
                'latitude' => strtoupper($request->input('latitude')),
            ]);

        $customer_principal_code = Customer_principal_code::where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal_id'))->first();
        $customer_principal_price = Customer_principal_price::where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal_id'))->first();

        if ($customer_principal_code) {
            Customer_principal_code::where('id', $customer_principal_code->id)
                ->update([
                    'store_code' => strtoupper($request->input('customer_principal_code')),
                ]);
        } else {
            $new_principal_code = new Customer_principal_code([
                'customer_id' => $request->input('customer_id'),
                'principal_id' => $request->input('principal_id'),
                'store_code' => strtoupper($request->input('customer_principal_code')),
                'user_id' => auth()->user()->id,
            ]);

            $new_principal_code->save();
        }

        if ($customer_principal_price) {
            Customer_principal_price::where('id', $customer_principal_price->id)
                ->update([
                    'price_level' => $request->input('customer_principal_price'),
                ]);
        } else {
            $new_principal_price = new Customer_principal_price([
                'customer_id' => $request->input('customer_id'),
                'principal_id' => $request->input('principal_id'),
                'price_level' => $request->input('customer_principal_price'),
                'user_id' => auth()->user()->id,
            ]);

            $new_principal_price->save();
        }
    }

























































    public function sales_order_proceed_to_summary(Request $request)
    {
        //return $request->input();

        //filter ni!!1
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $month = date('m');
        $year = date('y');


        foreach ($request->input('sku') as $key => $data) {
            if ($request->input('final_quantity')[$data] > $request->input('running_balance')[$data]) {
                return  'FINAL QUANTITY IS GREATER THAN RUNNING BALANCE';
            }
        }

        $select_principal_id_in_sales_order_printed = Sales_order_print::select('dr')->where('principal_id', $request->input('principal_id'))->latest()->first();
        if ($select_principal_id_in_sales_order_printed) {
            $variable_explode = explode('-', $select_principal_id_in_sales_order_printed->dr);
            $delivery_receipt_code = $variable_explode[0];
            $delivery_receipt_series = $variable_explode[3];
            $delivery_receipt = $delivery_receipt_code . "-" . $year . "-" . $month . "-" . str_pad($delivery_receipt_series + 1, 4, 0, STR_PAD_LEFT);
        } else {
            if ($request->input('principal') == 'GCI') {
                if ($request->input('sku_type') == 'Case') {
                    $delivery_receipt = 'E12M-0001';
                } else {
                    $delivery_receipt = 'E12B-0001';
                }
            } else {
                if ($request->input('sku_type') == 'Case') {
                    $delivery_receipt = $request->input('principal') . 'C-' . $year . '-' . $month . '-0001';
                } else {
                    $delivery_receipt = $request->input('principal') . 'B-' . $year . '-' . $month . '-0001';
                }
            }
        }


        $discount = $request->input('customer_discount');
        if (isset($discount)) {
            $customer_discount = $request->input('customer_discount');
            $customer_discount_counter = count($customer_discount);
        } else {
            $customer_discount = 0;
            $customer_discount_counter = 0;
        }


        $sku_data = Sku_add::findMany($request->input('sku'));
        $customer_principal_price = Customer_principal_price::select('price_level')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal_id'))->first();
        $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal_id'))->first();

        return view('sales_order_proceed_to_summary')->with('customer_discount', $customer_discount)
            ->with('sku_data', $sku_data)
            ->with('customer_discount_counter', $customer_discount_counter)
            ->with('customer_principal_price', $customer_principal_price)
            ->with('description', $request->input('description'))
            ->with('final_quantity', $request->input('final_quantity'))
            ->with('line_discount_rate_1', $request->input('line_discount_rate_1'))
            ->with('line_discount_rate_2', $request->input('line_discount_rate_2'))
            ->with('quantity', $request->input('quantity'))
            ->with('running_balance', $request->input('running_balance'))
            ->with('sku', $request->input('sku'))
            ->with('sku_code', $request->input('sku_code'))
            ->with('location', $request->input('location'))
            ->with('mode_of_transaction', $request->input('mode_of_transaction'))
            ->with('principal', $request->input('principal'))
            ->with('sku_type', $request->input('sku_type'))
            ->with('store_name', $request->input('store_name'))
            ->with('sales_order_id', $request->input('sales_order_id'))
            ->with('delivery_receipt', $delivery_receipt)
            ->with('customer_id', $request->input('customer_id'))
            ->with('sales_order_number', $request->input('sales_order_number'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('agent_id', $request->input('agent_id'))
            ->with('customer_principal_code', $customer_principal_code);
    }

    public function sales_order_upload_save(Request $request)
    {



        //return $request->input('delivery_receipt');
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');


        if (array_sum($request->input('customer_discount_rate')) != 0) {
            $customer_discount_rate = implode('-', $request->input('customer_discount_rate'));
        } else {
            $customer_discount_rate = 0;
        }

        $sales_order_print_save = new Sales_order_print([
            'customer_id' => $request->input('customer_id'),
            'sales_order_number' =>  $request->input('sales_order_number'),
            'agent_id' =>  $request->input('agent_id'),
            'principal_id' =>  $request->input('principal_id'),
            'user_id' =>  auth()->user()->id,
            'mode_of_transaction' =>  $request->input('mode_of_transaction'),
            'sku_type' =>  $request->input('sku_type'),
            'remarks' =>  'not_yet_printed',
            'status' =>  'not_yet_paid',
            'control' =>  'not_yet_printed',
            'date_paid_or_cancelled' =>  '',
            'dr' =>  $request->input('delivery_receipt'),
            'date' =>  $date,
            'date_delivered' =>  '',
            'remitted_by' =>  '',
            'received_by' =>  '',
            'total_amount' =>  $request->input('total_amount'),
            'total_customer_discount' =>  $request->input('total_customer_discount_amount'),
            'total_line_discount' =>  $request->input('total_category_discount_amount'),
            'customer_discount_rate' =>  $customer_discount_rate,
            'vatable_amount' =>  $request->input('vatable_amount'),
            'vat_amount' =>  $request->input('vat_amount'),
            'total_line_discount_1' =>  array_sum($request->input('line_discount_1')),
            'total_line_discount_2' =>  array_sum($request->input('line_discount_2')),
        ]);


        $sales_order_print_save->save();
        $sales_order_print_save_last_id = $sales_order_print_save->id;

        $sales_order_print_jer_save = new Sales_order_print_jer([
            'sales_order_print_id' => $sales_order_print_save_last_id,
            'accounts_receivable' => $request->input('accounts_receivable'),
            'sales' => $request->input('sales'),
        ]);

        $sales_order_print_jer_save->save();
        $sales_order_print_jer_save_last_id = $sales_order_print_jer_save->id;

        foreach ($request->input('sku') as $key => $data) {
            $sales_order_print_details_save = new Sales_order_print_details([
                'sales_order_print_id' => $sales_order_print_save_last_id,
                'sku_id' => $data,
                'sales_order_number' => $request->input('sales_order_number'),
                'quantity' => $request->input('quantity')[$data],
                'price' => $request->input('price')[$data],
                'amount' => $request->input('amount')[$data],
                'line_discount_1' => $request->input('line_discount_1')[$data],
                'line_discount_2' => $request->input('line_discount_2')[$data],
                'sub_total' => $request->input('sub_total')[$data],
            ]);

            $sales_order_print_details_save->save();

            if ($request->input('quantity')[$data] != 0) {

                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                $ledger_running_balance = $ledger_results[0]->running_balance - $request->input('quantity')[$data];
                $ledger_total_cost = $request->input('quantity')[$data] * $ledger_results[0]->final_unit_cost;
                $ledger_running_total_cost = $ledger_results[0]->running_total_cost - $ledger_total_cost;

                if ($ledger_running_balance == 0) {
                    $ledger_final_unit_cost = $ledger_results[0]->final_unit_cost;
                } else {
                    $ledger_final_unit_cost = $ledger_running_total_cost / $ledger_running_balance;
                }



                $ledger_add_save = new Sku_ledger([
                    'sku_id' => $data,
                    'category_id' => $request->input('category_id')[$data],
                    'sku_type' => $request->input('sku_type_per_sku')[$data],
                    'principal_id' => $request->input('principal_id'),
                    'in_out_adjustments' => 'Out',
                    'rr_dr' => $request->input('delivery_receipt'),
                    'sales_order_number' => $request->input('sales_order_number'),
                    'principal_invoice' => '',
                    'quantity' => ($request->input('quantity')[$data]) * -1,
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

                $sales_order_printed_jer_details_save = new Sales_order_print_jer_details([
                    'sales_order_print_jer_id' => $sales_order_print_jer_save_last_id,
                    'cost_of_sales' => $ledger_results[0]->final_unit_cost * $request->input('quantity')[$data],
                    'inventory' => $ledger_results[0]->final_unit_cost * $request->input('quantity')[$data],
                ]);

                $sales_order_printed_jer_details_save->save();
            }
        }

        $customer_id = $request->input('customer_id');
        $customer_ledger_result = Customer_ledger::where('customer_id', $customer_id)->orderBy('id', 'DESC')->limit(1)->first();

        $accounts_receivable_previous = $customer_ledger_result->accounts_receivable_end;
        $accounts_receivable_end = $accounts_receivable_previous + $request->input('total_amount');
        $credit_line_balance = $customer_ledger_result->credit_line_amount - $accounts_receivable_end;
        $customer_ledger_save = new Customer_ledger([
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal_id'),
            'delivery_receipt' => $request->input('delivery_receipt'),
            'store_code' => $request->input('store_code'),
            'sales_order_number' => $request->input('sales_order_number'),
            'transaction_reference' => 'DR',
            'accounts_receivable_previous' => $accounts_receivable_previous,
            'sales' => $request->input('total_amount'),
            'payment' => 0,
            'bo' => 0,
            'rgs' => 0,
            'adjustments' => 0,
            'accounts_receivable_end' => $accounts_receivable_end,
            'credit_line_amount' => $customer_ledger_result->credit_line_amount,
            'update_credit_line_amount' => 0,
            'credit_line_balance' => $credit_line_balance,
            'date' => $date,

        ]);

        $customer_ledger_save->save();


        $ar_ledger_save = new Ar_ledger([
            'customer_id' => $customer_id,
            'sales_order_print_id' => $sales_order_print_save_last_id,
            'agent_id' => $request->input('agent_id'),
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'date' => $date,
        ]);

        $ar_ledger_save->save();

        Sales_order::where('sales_order_number', $request->input('sales_order_number'))
            ->update(['remarks' => 'done']);

        return 'save';
    }
}
