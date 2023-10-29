<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_cost_of_sales;
use App\Sales_invoice_sales;
use App\Sku_principal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Customer_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $customer = Customer::select('id', 'store_name')->get();
            return view('customer_ledger', [
                'user' => $user,
                'principal' => $principal,
                'customer' => $customer,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'customer_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_ledger_generate(Request $request)
    {
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        if ($request->input('report') == 'Sales Register') {
            $sales_invoice = Sales_invoice::where('principal_id', $request->input('principal_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
                ->get();

            return view('customer_ledger_generate', [
                'sales_invoice' => $sales_invoice,
            ])->with('report', $request->input('report'));
        } elseif ($request->input('report') == 'Accounts Receivable') {
            //return $request->input();
            $accounts_receivable = Sales_invoice_accounts_receivable::where('principal_id', $request->input('principal_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
                ->get();

            return view('customer_ledger_generate', [
                'accounts_receivable' => $accounts_receivable,
            ])->with('report', $request->input('report'));
        } elseif ($request->input('report') == 'Principal Sales') {
            $principal_sales = Sales_invoice_sales::where('principal_id', $request->input('principal_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
                ->get();

            return view('customer_ledger_generate', [
                'principal_sales' => $principal_sales,
            ])->with('report', $request->input('report'));
        } else if ($request->input('report') == 'Cost of Sales') {
            $cost_of_sales = Sales_invoice_cost_of_sales::where('principal_id', $request->input('principal_id'))
                ->where('customer_id', $request->input('customer_id'))
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
                ->get();

            return view('customer_ledger_generate', [
                'cost_of_sales' => $cost_of_sales,
            ])->with('report', $request->input('report'));
        }
    }
}
