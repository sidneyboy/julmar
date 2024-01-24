<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Bad_order;
use App\Chart_of_accounts;
use App\Chart_of_accounts_details;
use App\Customer_principal_code;
use App\General_ledger;
use App\Return_good_stock;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_collection_jer;
use App\Sales_invoice_collection_receipt;
use App\Sales_invoice_collection_receipt_details;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Collection_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $agent = Agent::select('id', 'full_name')->get();
            return view('collection', [
                'user' => $user,
                'agent' => $agent,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'collection',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function collection_show_customers(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $customer = Sales_invoice::select('customer_id')
            ->where('agent_id', $request->input('agent_id'))
            ->groupBy('customer_id')
            ->get();

        return view('collection_show_customers', [
            'customer' => $customer,
        ]);
    }

    public function collection_sales_invoice_show_copy(Request $request)
    {
        //return $request->input();
        $sales_invoice = Sales_invoice::select('id', 'user_id', 'discount_rate', 'total', 'agent_id', 'customer_id', 'principal_id', 'delivery_receipt', 'created_at', 'sales_order_draft_id', 'mode_of_transaction', 'id')->find($request->input('sales_invoice_id'));
        $customer_principal_code = Customer_principal_code::where('customer_id', $sales_invoice->customer_id)
            ->where('principal_id', $sales_invoice->principal_id)
            ->first();

        return view('collection_sales_invoice_show_copy', [
            'sales_invoice' => $sales_invoice,
            'customer_principal_code' => $customer_principal_code,
        ]);
    }

    public function collection_proceed(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        if ($request->input('transaction') == 'collection') {
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'total_returned_amount', 'cm_amount_deducted')
                ->where('customer_id', $request->input('customer_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            $get_bank = Chart_of_accounts::select('id')->where('account_name', 'CASH IN BANK')->first();

            $get_rgs = Return_good_stock::select('id', 'pcm_number', 'total_amount')
                ->where('confirm_status', 'confirmed')
                ->get();

            $get_bo = Bad_order::select('id', 'pcm_number', 'total_amount')
                ->where('confirm_status', 'confirmed')
                ->get();

            if ($get_bank) {
                if (count($sales_invoice) == 0) {
                    return 'no_data_found';
                } else {
                    return view('collection_proceed', [
                        'sales_invoice' => $sales_invoice,
                        'get_bank' => $get_bank,
                        'get_rgs' => $get_rgs,
                        'get_bo' => $get_bo,
                    ])->with('disbursement', $request->input('disbursement'))
                        ->with('date', $date)
                        ->with('customer_id', $request->input('customer_id'));
                }
            } else {
                return 'No chart of account';
            }
        } else if ($request->input('transaction') == 'post_bo') {
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'cm_amount_deducted')
                ->where('customer_id', $request->input('customer_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            $bad_order = Bad_order::select('id', 'pcm_number', 'total_amount', 'posted_amount')
                ->where('agent_id', $request->input('agent_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->where('confirm_status', 'confirmed')
                ->where('final_status', null)
                ->get();

            return view('collection_post_bo', [
                'sales_invoice' => $sales_invoice,
                'bad_order' => $bad_order,
            ])->with('date', $date)
                ->with('customer_id', $request->input('customer_id'))
                ->with('agent_id', $request->input('agent_id'));
        } else if ($request->input('transaction') == 'post_rgs') {
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'cm_amount_deducted')
                ->where('customer_id', $request->input('customer_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            $return_good_stock = Return_good_stock::select('id', 'pcm_number', 'total_amount')
                ->where('agent_id', $request->input('agent_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->where('confirm_status', 'confirmed')
                ->where('final_status', null)
                ->get();


            return view('collection_post_rgs', [
                'sales_invoice' => $sales_invoice,
                'return_good_stock' => $return_good_stock,
            ])->with('date', $date)
                ->with('customer_id', $request->input('customer_id'))
                ->with('agent_id', $request->input('agent_id'));
        }
    }

    public function collection_post_rgs_final_summary(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $get_sales_return_and_allowances = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'SALES RETURNS AND ALLOWANCES')
            ->first();


        $get_customer_ar = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('customer_id', $request->input('customer_id'))
            ->first();

        $get_cost_of_goods_sold = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'COST OF GOODS SOLD')
            ->first();


        if ($get_sales_return_and_allowances && $get_customer_ar) {
            $rgs = Return_good_stock::select('total_amount', 'customer_id', 'agent_id', 'pcm_number', 'principal_id', 'cost_of_goods_sold', 'deducted_cost_of_goods_sold', 'deducted_inventory')
                ->find($request->input('cm_id'));
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'cm_amount_deducted')
                ->whereIn('id', $request->input('sales_invoice_id'))
                ->get();

            $originalAmount = $rgs->total_amount;

            foreach ($sales_invoice as $data) {
                $outstanding_balance =  $data->total - $data->cm_amount_deducted - $data->total_payment;
                $originalAmount -= $outstanding_balance;
                if ($originalAmount > 0) {
                    $rgs_amount[$data->id] = $outstanding_balance;
                } else {
                    $rgs_amount[$data->id] = $outstanding_balance + $originalAmount;
                }
            }

            $get_general_merchandise = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
                ->where('account_name', 'MERCHANDISE INVENTORY - ' . $rgs->principal->principal)
                ->where('principal_id', $rgs->principal_id)
                ->first();



            return view('collection_post_rgs_final_summary', [
                'get_general_merchandise' => $get_general_merchandise,
                'get_sales_return_and_allowances' => $get_sales_return_and_allowances,
                'get_cost_of_goods_sold' => $get_cost_of_goods_sold,
                'get_customer_ar' => $get_customer_ar,
                'date' => $date,
                'remarks' => $request->input('remarks'),
                'date' => $date,
                'rgs' => $rgs,
                'sales_invoice' => $sales_invoice,
                'rgs_amount' => $rgs_amount,
            ])->with('cm_id', $request->input('cm_id'))
                ->with('customer_id', $request->input('customer_id'));
        } else {
            return 'No chart of accounts';
        }
    }

    public function collection_post_rgs_save(Request $request)
    {
        //foreach ($request->input('rgs_amount') as $si_id => $data) {
        // $get_sales_invoice_returned_amount = Sales_invoice::select('cm_amount_deducted', 'total')
        //     ->find($si_id);

        // $new_cm_amount_deducted = $get_sales_invoice_returned_amount->cm_amount_deducted + $data;

        // if ($get_sales_invoice_returned_amount->total <= $new_cm_amount_deducted) {
        //     Sales_invoice::where('id', $si_id)
        //         ->update([
        //             'cm_amount_deducted' => $new_cm_amount_deducted,
        //             'payment_status' => 'paid',
        //         ]);
        // } else {
        //     Sales_invoice::where('id', $si_id)
        //         ->update([
        //             'cm_amount_deducted' => $new_cm_amount_deducted,
        //         ]);
        // }

        // $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
        //     ->where('principal_id', $request->input('principal_id'))
        //     ->orderBy('id', 'desc')
        //     ->first();

        // if ($get_last_row_sales_invoice_accounts_receivable) {
        //     $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $data;
        // } else {
        //     $sales_invoice_ar_running_balance = $data;
        // }

        // $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
        //     'user_id' => auth()->user()->id,
        //     'principal_id' => $request->input('principal_id'),
        //     'customer_id' => $request->input('customer_id'),
        //     'transaction' => 'credit memo rgs',
        //     'all_id' => $request->input('cm_id'),
        //     'debit_record' => 0,
        //     'credit_record' => $data,
        //     'running_balance' => $sales_invoice_ar_running_balance,
        // ]);

        // $new_sales_invoice_accounts_receivable->save();
        // }

        // $get_rgs_data = Return_good_stock::select('deducted_inventory', 'deducted_cost_of_goods_sold')->find($request->input('cm_id'));

        // $new_deducted_inventory_amount = $get_rgs_data->deducted_inventory + $request->input('deducted_inventory');
        // $new_deducted_cost_of_goods_sold = $get_rgs_data->deducted_cost_of_goods_sold + $request->input('deducted_cost_of_goods_sold');

        // Return_good_stock::where('id', $request->input('cm_id'))
        //     ->update([
        //         'deducted_inventory' => $new_deducted_inventory_amount,
        //         'deducted_cost_of_goods_sold' => $new_deducted_cost_of_goods_sold,
        //     ]);

        // Return_good_stock::where('id', $request->input('cm_id'))
        //     ->update(['posted_amount' => $request->input('accounts_receivable_amount')]);
        //return $request->input();


        $get_sales_return_and_allowances_account_name = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_sales_return_and_allowances_account_name'))
            ->where('account_number', $request->input('get_sales_return_and_allowances_account_number'))
            ->orderBy('id', 'DESC')
            ->first();


        if ($get_sales_return_and_allowances_account_name) {
            $running_balance = $get_sales_return_and_allowances_account_name->running_balance + $request->input('sales_return_and_allowances_amount');

            $get_sales_return_and_allowances_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_sales_return_and_allowances_account_name'),
                'account_number' => $request->input('get_sales_return_and_allowances_account_number'),
                'debit_record' => $request->input('sales_return_and_allowances_amount'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_sales_return_and_allowances_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_sales_return_and_allowances_new_general_ledger->save();
        } else {
            $get_sales_return_and_allowances_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_sales_return_and_allowances_account_name'),
                'account_number' => $request->input('get_sales_return_and_allowances_account_number'),
                'debit_record' => $request->input('sales_return_and_allowances_amount'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_sales_return_and_allowances_general_account_number'),
                'running_balance' => $request->input('sales_return_and_allowances_amount'),
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_sales_return_and_allowances_new_general_ledger->save();
        }

        $get_customer_ar_account_name = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_customer_ar_account_name'))
            ->where('account_number', $request->input('get_customer_ar_account_number'))
            ->orderBy('id', 'DESC')
            ->first();


        if ($get_customer_ar_account_name) {
            $customer_ar_running_balance = $get_customer_ar_account_name->running_balance - $request->input('accounts_receivable_amount');

            $get_customer_ar_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('accounts_receivable_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $customer_ar_running_balance,
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_customer_ar_new_general_ledger->save();
        } else {
            $get_customer_ar_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('accounts_receivable_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $request->input('accounts_receivable_amount'),
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_customer_ar_new_general_ledger->save();
        }

        $get_general_merchandise_account_name = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_general_merchandise_account_name'))
            ->where('principal_id', $request->input('principal_id'))
            ->where('account_number', $request->input('get_general_merchandise_account_number'))
            ->orderBy('id', 'DESC')
            ->first();


        if ($get_general_merchandise_account_name) {
            $customer_ar_running_balance = $get_general_merchandise_account_name->running_balance + $request->input('deducted_inventory');

            $get_general_merchandise_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_general_merchandise_account_name'),
                'account_number' => $request->input('get_general_merchandise_account_number'),
                'debit_record' => $request->input('deducted_inventory'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_general_merchandise_general_account_number'),
                'running_balance' => $customer_ar_running_balance,
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_general_merchandise_new_general_ledger->save();
        } else {
            $get_general_merchandise_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_general_merchandise_account_name'),
                'account_number' => $request->input('get_general_merchandise_account_number'),
                'debit_record' => $request->input('deducted_inventory'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_general_merchandise_general_account_number'),
                'running_balance' => $request->input('deducted_inventory'),
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_general_merchandise_new_general_ledger->save();
        }

        $get_cost_of_goods_sold_account_name = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_cost_of_goods_sold_account_name'))
            ->where('account_number', $request->input('get_cost_of_goods_sold_account_number'))
            ->orderBy('id', 'DESC')
            ->first();


        if ($get_cost_of_goods_sold_account_name) {
            $customer_ar_running_balance = $get_cost_of_goods_sold_account_name->running_balance + $request->input('deducted_cost_of_goods_sold');

            $get_cost_of_goods_sold_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_cost_of_goods_sold_account_name'),
                'account_number' => $request->input('get_cost_of_goods_sold_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('deducted_cost_of_goods_sold'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_cost_of_goods_sold_general_account_number'),
                'running_balance' => $customer_ar_running_balance,
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_cost_of_goods_sold_new_general_ledger->save();
        } else {
            $get_cost_of_goods_sold_new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('get_cost_of_goods_sold_account_name'),
                'account_number' => $request->input('get_cost_of_goods_sold_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('deducted_cost_of_goods_sold'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('get_cost_of_goods_sold_general_account_number'),
                'running_balance' => $request->input('deducted_cost_of_goods_sold'),
                'transaction' => 'CREDIT MEMO - RGS',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_cost_of_goods_sold_new_general_ledger->save();
        }








        // return 'JOURNAL ENTRY NALANG KULANG ANI';
    }

    public function collection_post_bo_final_summary(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $get_spoiled_goods = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'SPOILED GOODS')
            ->first();

        $get_customer_ar = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('customer_id', $request->input('customer_id'))
            ->first();


        if ($get_spoiled_goods && $get_customer_ar) {
            $bad_order = Bad_order::select('total_amount', 'customer_id', 'agent_id', 'pcm_number', 'principal_id', 'posted_amount')->find($request->input('cm_id'));
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'cm_amount_deducted')
                ->whereIn('id', $request->input('sales_invoice_id'))
                ->get();

            $originalAmount = $bad_order->total_amount - $bad_order->posted_amount;

            foreach ($sales_invoice as $data) {
                $outstanding_balance =  $data->total - $data->cm_amount_deducted - $data->total_payment;
                $originalAmount -= $outstanding_balance;
                if ($originalAmount > 0) {
                    $bo_amount[$data->id] = $outstanding_balance;
                } else {
                    $bo_amount[$data->id] = $outstanding_balance + $originalAmount;
                }
            }

            return view('collection_post_bo_final_summary', [
                'get_spoiled_goods' => $get_spoiled_goods,
                'get_customer_ar' => $get_customer_ar,
                'date' => $date,
                'remarks' => $request->input('remarks'),
                'date' => $date,
                'bad_order' => $bad_order,
                'sales_invoice' => $sales_invoice,
                'bo_amount' => $bo_amount,
            ])->with('cm_id', $request->input('cm_id'))
                ->with('customer_id', $request->input('customer_id'));
        } else {
            return 'No chart of accounts';
        }
    }

    public function collection_post_bo_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        foreach ($request->input('bo_amount') as $si_id => $data) {
            $get_sales_invoice_returned_amount = Sales_invoice::select('cm_amount_deducted', 'total')
                ->find($si_id);

            $new_cm_amount_deducted = $get_sales_invoice_returned_amount->cm_amount_deducted + $data;

            if ($get_sales_invoice_returned_amount->total <= $new_cm_amount_deducted) {
                Sales_invoice::where('id', $si_id)
                    ->update([
                        'cm_amount_deducted' => $new_cm_amount_deducted,
                        'payment_status' => 'paid',
                    ]);
            } else {
                Sales_invoice::where('id', $si_id)
                    ->update([
                        'cm_amount_deducted' => $new_cm_amount_deducted,
                    ]);
            }

            $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
                ->where('principal_id', $request->input('principal_id'))
                ->orderBy('id', 'desc')
                ->first();

            if ($get_last_row_sales_invoice_accounts_receivable) {
                $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $data;
            } else {
                $sales_invoice_ar_running_balance = $data;
            }

            $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'customer_id' => $request->input('customer_id'),
                'transaction' => 'credit memo bo',
                'all_id' => $request->input('cm_id'),
                'debit_record' => 0,
                'credit_record' => $data,
                'running_balance' => $sales_invoice_ar_running_balance,
            ]);

            $new_sales_invoice_accounts_receivable->save();
        }

        Bad_order::where('id', $request->input('cm_id'))
            ->update(['posted_amount' => $request->input('spoiled_goods_amount')]);

        $get_spoiled_goods = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_spoiled_goods_account_name'))
            ->where('account_number', $request->input('get_spoiled_goods_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_spoiled_goods) {
            $get_spoined_goods_running_balance = $get_spoiled_goods->running_balance + $request->input('spoiled_goods_amount');

            $get_spoined_goods_new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_spoiled_goods_account_name'),
                'account_number' => $request->input('get_spoiled_goods_account_number'),
                'debit_record' => $request->input('spoiled_goods_amount'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'general_account_number' => $request->input('get_spoiled_goods_general_account_number'),
                'running_balance' => $get_spoined_goods_running_balance,
                'transaction' => 'CREDIT MEMO - BO',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_spoined_goods_new_general_ledger->save();
        } else {
            $get_spoined_goods_new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_spoiled_goods_account_name'),
                'account_number' => $request->input('get_spoiled_goods_account_number'),
                'debit_record' => $request->input('spoiled_goods_amount'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'general_account_number' => $request->input('get_spoiled_goods_general_account_number'),
                'running_balance' => $request->input('spoiled_goods_amount'),
                'transaction' => 'CREDIT MEMO - BO',
                'customer_id' => $request->input('customer_id'),
            ]);

            $get_spoined_goods_new_general_ledger->save();
        }

        $get_customer_ar = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_customer_ar_account_name'))
            ->where('customer_id', $request->input('customer_id'))
            ->where('account_number', $request->input('get_customer_ar_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_customer_ar) {
            $running_balance = $get_customer_ar->running_balance - $request->input('spoiled_goods_amount');

            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('spoiled_goods_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'CREDIT MEMO - BO',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('spoiled_goods_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $request->input('spoiled_goods_amount'),
                'transaction' => 'CREDIT MEMO - BO',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        }
    }

    public function collection_final_summary(Request $request)
    {

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $explode_bank = explode('|', $request->input('bank'));
        $chart_of_account_details_id = $explode_bank[0];
        $bank = $explode_bank[1];

        $get_bank = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('id', $chart_of_account_details_id)
            ->first();

        $get_customer_ar = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('customer_id', $request->input('customer_id'))
            ->first();

        if ($get_bank && $get_customer_ar) {
            $amount_collected_filtered = array_filter($request->input('amount_collected'));
            foreach ($amount_collected_filtered as $key => $value) {
                if ($request->input('outstanding_balance')[$key] < str_replace(',', '', $value)) {
                    return 'cannot proceed';
                }
            }

            $amount_collected = array_filter(str_replace(',', '', $request->input('amount_collected')));
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'cm_amount_deducted')
                ->whereIn('id', array_keys($amount_collected))
                ->get();

            return view('collection_final_summary', [
                'get_customer_ar' => $get_customer_ar,
                'amount_collected' => $amount_collected,
                'sales_invoice' => $sales_invoice,
                'get_bank' => $get_bank,
            ])->with('customer_id', $request->input('customer_id'))
                ->with('bank', $bank)
                ->with('date', $date)
                ->with('check_ref_cash', strtoupper($request->input('check_ref_cash')))
                ->with('disbursement', $request->input('disbursement'))
                ->with('official_receipt_no', strtoupper($request->input('official_receipt_no')))
                ->with('payment_date', $request->input('payment_date'))
                ->with('remarks', $request->input('remarks'));
        } else {
            return 'No chart of account';
        }
    }

    public function collection_saved(Request $request)
    {
        $new = new Sales_invoice_collection_receipt([
            'user_id' => auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'agent_id' => $request->input('agent_id'),
            'check_ref_cash' => $request->input('check_ref_cash'),
            'official_receipt' => $request->input('official_receipt_no'),
            'bank' => $request->input('bank'),
            'payment_date' => $request->input('payment_date'),
        ]);

        $new->save();

        $new_jer = new Sales_invoice_collection_jer([
            'sicrd_id' => $new->id,
            'debit_record' => $request->input('debit_record'),
            'credit_record' => $request->input('credit_record'),
        ]);

        $new_jer->save();

        $get_bank = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_bank_account_name'))
            // ->where('customer_id', $request->input('customer_id'))
            ->where('account_number', $request->input('get_bank_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_bank) {
            $running_balance = $get_bank->running_balance + $request->input('cash_in_bank_total');

            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_bank_account_name'),
                'account_number' => $request->input('get_bank_account_number'),
                'debit_record' => $request->input('cash_in_bank_total'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('payment_date'),
                'general_account_number' => $request->input('get_bank_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'COLLECTION',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_bank_account_name'),
                'account_number' => $request->input('get_bank_account_number'),
                'debit_record' => $request->input('cash_in_bank_total'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('payment_date'),
                'general_account_number' => $request->input('get_bank_general_account_number'),
                'running_balance' => $request->input('cash_in_bank_total'),
                'transaction' => 'COLLECTION',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        }

        $get_customer_ar = General_ledger::select('running_balance')
            ->where('account_name', $request->input('get_customer_ar_account_name'))
            ->where('customer_id', $request->input('customer_id'))
            ->where('account_number', $request->input('get_customer_ar_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_customer_ar) {
            $running_balance = $get_customer_ar->running_balance - $request->input('customer_ar_total');

            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('customer_ar_total'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('payment_date'),
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'COLLECTION',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'account_name' => $request->input('get_customer_ar_account_name'),
                'account_number' => $request->input('get_customer_ar_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('customer_ar_total'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('payment_date'),
                'general_account_number' => $request->input('get_customer_ar_general_account_number'),
                'running_balance' => $request->input('customer_ar_total'),
                'transaction' => 'COLLECTION',
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_general_ledger->save();
        }

        foreach ($request->input('amount_collected') as $key => $value) {
            $sales_invoice_checker = Sales_invoice::select('total_payment', 'total', 'principal_id', 'customer_id')->find($key);

            $total_payment = $sales_invoice_checker->total_payment + $value;

            if ($total_payment > $sales_invoice_checker->total) {
                Sales_invoice::where('id', $key)
                    ->update([
                        'total_payment' => $total_payment,
                        'payment_status' => 'paid',
                    ]);

                $new_details = new Sales_invoice_collection_receipt_details([
                    'sicrd_id' => $new->id,
                    'si_id' => $key,
                    'ar_balance' => $request->input('outstanding_balance')[$key],
                    'amount_collected' => $value,
                    'outstanding_balance' => $request->input('new_outstanding_balance')[$key],
                    'remarks' => $request->input('remarks')[$key],
                    'status' => 'paid',
                ]);

                $new_details->save();

                $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $sales_invoice_checker->principal_id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($get_last_row_sales_invoice_accounts_receivable) {
                    $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $value;
                } else {
                    $sales_invoice_ar_running_balance = $value;
                }

                $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                    'user_id' => auth()->user()->id,
                    'principal_id' => $sales_invoice_checker->principal_id,
                    'customer_id' => $request->input('customer_id'),
                    'transaction' => 'collection receipt',
                    'all_id' => $new->id,
                    'debit_record' => 0,
                    'credit_record' => $value,
                    'running_balance' => $sales_invoice_ar_running_balance,
                    'status' => 'paid',
                ]);

                $new_sales_invoice_accounts_receivable->save();
            } else {
                Sales_invoice::where('id', $key)
                    ->update([
                        'total_payment' => $total_payment,
                        'payment_status' => 'partial',
                    ]);

                $new_details = new Sales_invoice_collection_receipt_details([
                    'sicrd_id' => $new->id,
                    'si_id' => $key,
                    'ar_balance' => $request->input('outstanding_balance')[$key],
                    'amount_collected' => $value,
                    'outstanding_balance' => $request->input('new_outstanding_balance')[$key],
                    'remarks' => $request->input('remarks')[$key],
                    'status' => 'partial',
                ]);

                $new_details->save();

                $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $sales_invoice_checker->principal_id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($get_last_row_sales_invoice_accounts_receivable) {
                    $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $value;
                } else {
                    $sales_invoice_ar_running_balance = $value;
                }

                $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                    'user_id' => auth()->user()->id,
                    'principal_id' => $sales_invoice_checker->principal_id,
                    'customer_id' => $request->input('customer_id'),
                    'transaction' => 'collection receipt',
                    'all_id' => $new->id,
                    'debit_record' => 0,
                    'credit_record' => $value,
                    'running_balance' => $sales_invoice_ar_running_balance,
                ]);

                $new_sales_invoice_accounts_receivable->save();
            }
        }
    }
}
