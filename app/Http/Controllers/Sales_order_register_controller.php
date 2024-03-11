<?php

namespace App\Http\Controllers;

use App\User;
use App\Agent;
use App\Sales_invoice;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sales_order_register_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name')->where('kind_of_business', '!=', 'VAN SELLING')->get();
            $agent = Agent::select('id', 'full_name')->get();
            return view('sales_order_register', [
                'user' => $user,
                'agent' => $agent,
                'customer' => $customer,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'sales_order_register',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sales_order_register_show_next_input(Request $request)
    {
        $sales_order = Sales_invoice::select('customer_id','total','total_payment','delivery_receipt')
            ->where('agent_id', $request->input('agent_id'))
            // ->where('payment_status','partial')
            // ->orWhere('payment_status',null)
            ->orderBy('id', 'desc')
            ->groupBy('customer_id')
            ->get();

        return view('sales_order_register_show_next_input_page', [
            'sales_order' => $sales_order,
        ]);
    }

    public function sales_order_register_generate_sales_register(Request $request)
    {
        //return $request->input();
        $sales_invoice_case = Sales_invoice::where('customer_id', $request->input('customer_id'))
            ->where('agent_id', $request->input('agent_id'))
            ->where('sku_type', 'CASE')
            ->orderBy('id', 'desc')
            ->get();

        $sales_invoice_butal = Sales_invoice::where('customer_id', $request->input('customer_id'))
            ->where('agent_id', $request->input('agent_id'))
            ->where('sku_type', 'BUTAL')
            ->orderBy('id', 'desc')
            ->get();

        return view('sales_order_register_generate_sales_register_page', [
            'sales_invoice_case' => $sales_invoice_case,
            'sales_invoice_butal' => $sales_invoice_butal,
        ]);
    }

    public function sales_order_register_view_details(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $sales_invoice = sales_invoice::find($request->input('sales_invoice_id'));
        $sales_register_store_name = preg_replace('/[^A-Za-z0-9\-]/', '', $sales_invoice->customer->store_name);
        return view('sales_order_register_view_details', [
            'sales_invoice' => $sales_invoice,
        ])->with('sales_register_store_name', $sales_register_store_name)
            ->with('date', $date);
    }
}
