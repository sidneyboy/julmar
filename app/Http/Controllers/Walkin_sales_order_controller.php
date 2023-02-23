<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Agent;
use App\Sku_principal;
use App\Sku_add;
use App\Sales_order_print;
use App\Invoice_draft;
use App\Invoice_draft_details;
use App\Sales_order_print_details;
use App\Customer_principal_code;
use App\Customer_discount;
use DB;
use App\Customer_ledger;
use App\Sales_order_print_jer;
use App\Sales_order_print_jer_details;
use App\Sku_ledger;
use App\Sales_order;
use App\Customer_principal_price;
use App\Ar_ledger;
use Illuminate\Http\Request;

class Walkin_sales_order_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name')->get();
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('walkin_sales_order', [
                'user' => $user,
                'customer' => $customer,
                'principal' => $principal,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'walkin_sales_order',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function walk_sales_order_generate_sku(Request $request)
    {
        //return $request->input();

        if (empty($request->input('customer'))) {
            return 'all_data_input_needed';
        } else if (empty($request->input('type'))) {
            return 'all_data_input_needed';
        } else if (empty($request->input('price_level'))) {
            return 'all_data_input_needed';
        } else {

            $sku = Sku_add::select('id', 'sku_code', 'description', 'sku_type')->where('principal_id', $request->input('principal_id'))->where('sku_type', 'CASE')->get();
            return view('walk_sales_order_generate_sku_page', [
                'sku' => $sku
            ]);
        }
    }

    public function walkin_sales_order_generate_form(Request $request)
    {
        //return$request->input();
        $explode = explode(',', $request->input('customer'));
        $customer_id = $explode[0];
        $store_name = $explode[1];

        $explode_principal = explode(',', $request->input('principal_id'));
        $principal_id = $explode_principal[0];
        $principal_name = $explode_principal[1];

        $sku_data = Sku_add::select('id', 'sku_code', 'description', 'category_id', 'sku_type')->findMany($request->input('sku'));
        // $customer_discount = Customer_discount::where('customer_id', $customer_id)->get();
        // $customer_principal_price = Customer_principal_price::select('price_level')->where('customer_id', $customer_id)->where('principal_id', $principal_id)->first();

        return view('walkin_sales_order_generate_page')
            ->with('customer_id', $customer_id)
            ->with('store_name', $store_name)
            ->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name)
            ->with('type', $request->input('type'))
            // ->with('customer_discount', $customer_discount)
            ->with('sku', $request->input('sku'))
            ->with('sku_data', $sku_data);
        // ->with('customer_principal_price', $customer_principal_price)
    }

    public function walkin_sales_order_generate_final_summary(Request $request)
    {
        //return $request->input();
        return view('walkin_sales_order_generate_final_summary_page')
            ->with('customer_id', $request->input('customer_id'))
            ->with('description', $request->input('description'))
            ->with('line_discount_rate_1', $request->input('line_discount_rate_1'))
            ->with('total_other_discount', $request->input('total_other_discount'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('principal_name', $request->input('principal_name'))
            ->with('quantity', $request->input('quantity'))
            ->with('remaining_balance', $request->input('remaining_balance'))
            ->with('sku', $request->input('sku'))
            ->with('sku_code', $request->input('sku_code'))
            ->with('unit_price', str_replace(',', '', $request->input('unit_price')))
            ->with('sku_type', $request->input('sku_type'))
            ->with('agent', $request->input('agent'))
            ->with('store_name', $request->input('store_name'))
            ->with('type', $request->input('type'))
            ->with('delivery_receipt', $request->input('delivery_receipt'))
            ->with('mode_of_transaction', $request->input('mode_of_transaction'));
    }

    public function walkin_sales_order_save(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');


        $new_invoice_draft = new Invoice_draft([
            'agent' => $request->input('agent'),
            'principal_id' => $request->input('principal_id'),
            'customer_id' => $request->input('customer_id'),
            'user_id' => auth()->user()->id,
            'mode_of_transaction' => $request->input('mode_of_transaction'),
            'sku_type' => $request->input('sku_type'),
            'other_discount' => $request->input('other_discount'),
            'total_amount' => $request->input('total_amount'),
            'delivery_receipt' => $request->input('delivery_receipt'),
        ]);

        $new_invoice_draft->save();


        foreach ($request->input('sku_id') as $key => $data) {
            $new_invoice_draft_details = new Invoice_draft_details([
                'invoice_draft_id' => 1,
                'sku_id' => $data,
                'quantity' => $request->input('quantity')[$data],
                'unit_price' => $request->input('unit_price')[$data],
                'line_discount' => $request->input('line_discount')[$data],
            ]);

            $new_invoice_draft_details->save();
        }




        // $sales_order_print_save = new Sales_order_print([
        //     'customer_id' => $request->input('customer_id'),
        //     'sales_order_number' =>  $request->input('sales_order_number'),
        //     'agent_id' =>  $request->input('agent_id'),
        //     'principal_id' =>  $request->input('principal_id'),
        //     'user_id' =>  auth()->user()->id,
        //     'mode_of_transaction' =>  $request->input('mode_of_transaction'),
        //     'sku_type' =>  $request->input('sku_type'),
        //     'remarks' =>  'not_yet_printed',
        //     'status' =>  'not_yet_paid',
        //     'control' =>  'not_yet_printed',
        //     'date_paid_or_cancelled' =>  '',
        //     'dr' =>  $request->input('delivery_receipt'),
        //     'date' =>  $date,
        //     'total_amount' =>  $request->input('total_amount'),
        //     'total_customer_discount' =>  $request->input('total_customer_discount_amount'),
        //     'total_line_discount' =>  $request->input('total_line_discount'),
        //     'customer_discount_rate' =>  $customer_discount_rate,
        //     'vatable_amount' =>  $request->input('vatable_amount'),
        //     'vat_amount' =>  $request->input('vat_amount'),
        //     'total_line_discount_1' =>  array_sum($request->input('line_discount_1')),
        //     'total_line_discount_2' =>  array_sum($request->input('line_discount_2')),

        // ]);


        // $sales_order_print_save->save();
        // $sales_order_print_save_last_id = $sales_order_print_save->id;

        // $sales_order_print_jer_save = new Sales_order_print_jer([
        //     'sales_order_print_id' => $sales_order_print_save_last_id,
        //     'accounts_receivable' => $request->input('accounts_receivable'),
        //     'sales' => $request->input('sales'),
        // ]);

        // $sales_order_print_jer_save->save();
        // $sales_order_print_jer_save_last_id = $sales_order_print_jer_save->id;

        // foreach ($request->input('sku') as $key => $data) {
        //     $sales_order_print_details_save = new Sales_order_print_details([
        //         'sales_order_print_id' => $sales_order_print_save_last_id,
        //         'sku_id' => $data,
        //         'sales_order_number' => $request->input('sales_order_number'),
        //         'quantity' => $request->input('quantity')[$data],
        //         'price' => $request->input('price')[$data],
        //         'amount' => $request->input('amount')[$data],
        //         'line_discount_1' => $request->input('line_discount_1')[$data],
        //         'line_discount_2' => $request->input('line_discount_2')[$data],
        //         'line_discount_rate_1' => $request->input('line_discount_rate_1')[$data],
        //         'line_discount_rate_2' => $request->input('line_discount_rate_2')[$data],
        //         'sub_total' => $request->input('sub_total')[$data],
        //     ]);

        //     $sales_order_print_details_save->save();

        //     $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
        //     $ledger_running_balance = $ledger_results[0]->running_balance - $request->input('quantity')[$data];
        //     $ledger_total_cost = $request->input('quantity')[$data] * $ledger_results[0]->final_unit_cost;
        //     $ledger_running_total_cost = $ledger_results[0]->running_total_cost - $ledger_total_cost;

        //     if ($ledger_running_balance == 0) {
        //         $ledger_final_unit_cost = $ledger_results[0]->final_unit_cost;
        //     } else {
        //         $ledger_final_unit_cost = $ledger_running_total_cost / $ledger_running_balance;
        //     }

        //     //$ledger_results[0]->category_id;

        //     $ledger_add_save = new Sku_ledger([
        //         'sku_id' => $data,
        //         'category_id' => $ledger_results[0]->category_id,
        //         'sku_type' => $ledger_results[0]->sku_type,
        //         'principal_id' => $ledger_results[0]->principal_id,
        //         'in_out_adjustments' => 'Out',
        //         'rr_dr' => $request->input('delivery_receipt'),
        //         'sales_order_number' => $request->input('sales_order_number'),
        //         'principal_invoice' => '',
        //         'quantity' => ($request->input('quantity')[$data]) * -1,
        //         'running_balance' => $ledger_running_balance,
        //         'unit_cost' => $ledger_results[0]->final_unit_cost,
        //         'total_cost' => ($ledger_total_cost) * -1,
        //         'adjustments' => 0,
        //         'running_total_cost' => $ledger_running_total_cost,
        //         'final_unit_cost' => $ledger_final_unit_cost,
        //         'transaction_date' => $date,
        //         'user_id' => auth()->user()->id
        //     ]);

        //     $ledger_add_save->save();


        //     $sales_order_printed_jer_details_save = new Sales_order_print_jer_details([
        //         'sales_order_print_jer_id' => $sales_order_print_jer_save_last_id,
        //         'cost_of_sales' => $ledger_results[0]->final_unit_cost * $request->input('quantity')[$data],
        //         'inventory' => $ledger_results[0]->final_unit_cost * $request->input('quantity')[$data],
        //     ]);

        //     $sales_order_printed_jer_details_save->save();
        // }



        // $customer_id = $request->input('customer_id');
        // $customer_ledger_result = Customer_ledger::where('customer_id', $customer_id)->orderBy('id', 'DESC')->limit(1)->first();

        // $accounts_receivable_previous = $customer_ledger_result->accounts_receivable_end;
        // $accounts_receivable_end = $accounts_receivable_previous + $request->input('total_amount');
        // $credit_line_balance = $customer_ledger_result->credit_line_amount - $accounts_receivable_end;
        // $customer_ledger_save = new Customer_ledger([
        //     'customer_id' => $request->input('customer_id'),
        //     'principal_id' => $request->input('principal_id'),
        //     'delivery_receipt' => $request->input('delivery_receipt'),
        //     'store_code' => $request->input('store_code'),
        //     'sales_order_number' => $request->input('sales_order_number'),
        //     'transaction_reference' => 'WALK IN - ' . $sales_order_print_save_last_id,
        //     'accounts_receivable_previous' => $accounts_receivable_previous,
        //     'sales' => $request->input('total_amount'),
        //     'payment' => 0,
        //     'bo' => 0,
        //     'rgs' => 0,
        //     'adjustments' => 0,
        //     'accounts_receivable_end' => $accounts_receivable_end,
        //     'credit_line_amount' => $customer_ledger_result->credit_line_amount,
        //     'update_credit_line_amount' => 0,
        //     'credit_line_balance' => $credit_line_balance,
        //     'date' => $date,

        // ]);

        // $customer_ledger_save->save();

        // Sales_order::where('sales_order_number', $request->input('sales_order_number'))
        //     ->update(['remarks' => 'done']);

        // $ar_ledger_save = new Ar_ledger([
        //     'customer_id' => $customer_id,
        //     'sales_order_print_id' => $sales_order_print_save_last_id,
        //     'agent_id' => $request->input('agent_id'),
        //     'principal_id' => $request->input('principal_id'),
        //     'user_id' => auth()->user()->id,
        //     'date' => $date,
        // ]);

        // $ar_ledger_save->save();

        return 'saved';
    }
}
