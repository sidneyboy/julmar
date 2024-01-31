<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer_principal_code;
use App\Sales_invoice;
use App\Sales_invoice_status_logs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Sales_invoice_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $sales_invoice = Sales_invoice::select('delivery_receipt', 'id')
                    ->where('status', 'invoice')
                    ->get();
            return view('sales_invoice', [
                'user' => $user,
                'sales_invoice' => $sales_invoice,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'sales_invoice',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sales_invoice_generate(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date_time = date('Y-m-d H:i:s');
        $date_now = date('Y-m-d');


        $sales_invoice = Sales_invoice::select('user_id', 'discount_rate', 'total', 'agent_id', 'customer_id', 'principal_id', 'delivery_receipt', 'created_at', 'sales_order_draft_id', 'mode_of_transaction', 'id')->find($request->input('sales_invoice_id'));
        $customer_principal_code = Customer_principal_code::where('customer_id', $sales_invoice->customer_id)
            ->where('principal_id', $sales_invoice->principal_id)
            ->first();

        Sales_invoice::where('id', $request->input('sales_invoice_id'))
            ->update([
                'sales_invoice_printed' => $date_now,
                'status' => 'printed',
            ]);

        $sales_invoice_status_logs_save = new Sales_invoice_status_logs([
            'sales_invoice_id' => $request->input('sales_invoice_id'),
            'posted' => $date_now,
            'updated' => '',
            'status' => 'Printed DR',
            'user_id' => auth()->user()->id,
        ]);

        $sales_invoice_status_logs_save->save();

        return view('sales_invoice_generate', [
            'sales_invoice' => $sales_invoice,
            'customer_principal_code' => $customer_principal_code,
        ]);
    }
}
