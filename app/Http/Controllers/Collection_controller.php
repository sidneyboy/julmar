<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Customer_principal_code;
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
        $sales_invoice = Sales_invoice::select('user_id', 'discount_rate', 'total', 'agent_id', 'customer_id', 'principal_id', 'delivery_receipt', 'created_at', 'sales_order_draft_id', 'mode_of_transaction', 'id')->find($request->input('sales_invoice_id'));
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

        if (count($sales_invoice) == 0) {
            return 'no_data_found';
        } else {
            return view('collection_proceed', [
                'sales_invoice' => $sales_invoice,
            ])->with('disbursement', $request->input('disbursement'))
                ->with('date', $date)
                ->with('customer_id', $request->input('customer_id'));
        }
    }

    public function collection_final_summary(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        foreach ($request->input('amount_collected') as $key => $value) {
            if ($request->input('outstanding_balance')[$key] < str_replace(',', '', $value)) {
                return 'cannot proceed';
            }
        }

        $amount_collected = array_filter(str_replace(',', '', $request->input('amount_collected')));
        $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment', 'delivered_date', 'total_returned_amount')
            ->whereIn('id', array_keys($amount_collected))
            ->get();
        return view('collection_final_summary', [
            'amount_collected' => $amount_collected,
            'sales_invoice' => $sales_invoice,
        ])->with('customer_id', $request->input('customer_id'))
            ->with('bank', $request->input('bank'))
            ->with('date', $date)
            ->with('check_ref_cash', strtoupper($request->input('check_ref_cash')))
            ->with('disbursement', $request->input('disbursement'))
            ->with('official_receipt_no', strtoupper($request->input('official_receipt_no')))
            ->with('payment_date', $request->input('payment_date'))
            ->with('remarks', $request->input('remarks'));
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

        foreach ($request->input('amount_collected') as $key => $value) {
            $sales_invoice_checker = Sales_invoice::select('total_payment', 'total', 'principal_id')->find($key);

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
