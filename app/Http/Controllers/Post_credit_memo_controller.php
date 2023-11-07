<?php

namespace App\Http\Controllers;

use App\Bad_order;
use App\Return_good_stock;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_details;
use App\User;
use App\Sales_invoice_collection_receipt_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Post_credit_memo_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $return_good_stock = Return_good_stock::select('pcm_number', 'id')
                ->where('status', 'verified')
                ->get();

            $bad_order = Bad_order::select('pcm_number', 'id')
                ->where('status', 'verified')
                ->get();

            return view('post_credit_memo', [
                'user' => $user,
                'return_good_stock' => $return_good_stock,
                'bad_order' => $bad_order,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'post_credit_memo',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function credit_memo_proceed(Request $request)
    {
        $explode = explode('-', $request->input('cm_id'));
        $transaction = $explode[0];
        $cm_id = $explode[1];

        if ($transaction == 'RGS') {
            $cm_data = Return_good_stock::find($cm_id);
            if (count($cm_data->return_good_stock_discount) != 0) {
                foreach ($cm_data->return_good_stock_discount as $key => $discount_rate_data) {
                    $customer_discount[] = $discount_rate_data->discount_rate;
                }
            } else {
                $customer_discount = 0;
            }
        } elseif ($transaction == 'BO') {
            $cm_data = Bad_order::find($cm_id);
        }



        return view('credit_memo_proceed', [
            'cm_data' => $cm_data,
            'cm_id' => $cm_id,
            'customer_discount' => $customer_discount,
        ])->with('transaction', $transaction);
    }

    public function post_credit_memo_save(Request $request)
    {
        // return $request->input();
        foreach ($request->input('quantity_returned') as $key => $quantity) {
            Sales_invoice_details::where('sales_invoice_id', $request->input('si_id'))
                ->where('sku_id', $key)
                ->update(['quantity_returned' => $quantity]);
        }

        Sales_invoice::where('id', $request->input('si_id'))
            ->update(['total_returned_amount' => $request->input('total_amount')]);

        $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
            ->where('principal_id', $request->input('principal_id'))
            ->orderBy('id', 'desc')
            ->first();

        if ($get_last_row_sales_invoice_accounts_receivable) {
            $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $request->input('total_amount');
        } else {
            $sales_invoice_ar_running_balance = $request->input('total_amount');
        }

        $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
            'user_id' => auth()->user()->id,
            'principal_id' => $request->input('principal_id'),
            'customer_id' => $request->input('customer_id'),
            'transaction' => 'credit memo rgs',
            'all_id' => $request->input('cm_id'),
            'debit_record' => 0,
            'credit_record' => $request->input('total_amount'),
            'running_balance' => $sales_invoice_ar_running_balance,
        ]);

        $new_sales_invoice_accounts_receivable->save();
    }
}
