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
        $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'total_returned_amount')
            ->where('customer_id', $request->input('customer_id'))
            ->where('payment_status', null)
            ->orWhere('payment_status', 'partial')
            ->get();

        $get_bank = Chart_of_accounts::select('id')->where('account_name', 'CASH IN BANK')->first();

        $get_rgs = Return_good_stock::select('id','pcm_number','total_amount')
            ->where('confirm_status', 'confirmed')
            ->get();

        $get_bo = Bad_order::select('id','pcm_number','total_amount')
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
    }

    public function collection_final_summary(Request $request)
    {
        //return $request->input('customer_id');
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
          

            // foreach ($request->input('amount_collected') as $key => $value) {
            //     if ($request->input('outstanding_balance')[$key] < str_replace(',', '', $value)) {
            //         return 'cannot proceed';
            //     }
            // }

            // $amount_collected = array_filter(str_replace(',', '', $request->input('amount_collected')));
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'total_returned_amount')
                // ->whereIn('id', array_keys($amount_collected))
                ->whereIn('id', array_keys($request->input('outstanding_balance')))
                ->get();
            return view('collection_final_summary', [
                'amount_collected' => $amount_collected,
                'sales_invoice' => $sales_invoice,
                'get_bank' => $get_bank,
                'get_customer_ar' => $get_customer_ar,
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
        //return $request->input();

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

            if ($total_payment == $sales_invoice_checker->total) {
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
