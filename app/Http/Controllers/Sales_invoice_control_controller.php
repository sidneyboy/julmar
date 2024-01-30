<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Sales_invoice;
use App\Sales_invoice_details;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Sales_invoice_control_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $agent = Agent::select('id', 'full_name')->get();
            return view('sales_invoice_control', [
                'user' => $user,
                'agent' => $agent,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'sales_invoice_control',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sales_invoice_control_generate(Request $request)
    {
        $sales_invoice = Sales_invoice::select(
            'id',
            'delivery_receipt',
            'mode_of_transaction',
            'customer_id',
            'sales_invoice_printed',
            'total',
            'customer_discount',
            'agent_id'
        )
            ->where('agent_id', $request->input('agent_id'))
            ->where('control', null)
            ->get();

        if (count($sales_invoice) != 0) {
            $sales_invoice_for_2nd_control = Sales_invoice::select('id')
                ->where('agent_id', $request->input('agent_id'))
                ->where('control', null)
                ->get()
                ->toArray();


            $sales_invoice_details = Sales_invoice_details::select('sku_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_amount_per_sku) as total_amount'))
                ->whereIn('sales_invoice_id', $sales_invoice_for_2nd_control)
                ->groupBy('sku_id')
                ->get();

            return view('sales_invoice_control_generate', [
                'sales_invoice' => $sales_invoice,
                'sales_invoice_details' => $sales_invoice_details,
            ]);
        }else{
            return 'no_data';
        }
    }

    public function sales_invoice_control_print(Request $request)
    {
        $sales_invoice = Sales_invoice::select(
            'id',
            'delivery_receipt',
            'mode_of_transaction',
            'customer_id',
            'sales_invoice_printed',
            'total',
            'customer_discount',
            'agent_id'
        )
            ->whereIn('id', $request->input('sales_invoice_id'))
            ->get();

        $sales_invoice_details = Sales_invoice_details::select('sku_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_amount_per_sku) as total_amount'))
            ->whereIn('sales_invoice_id', $request->input('sales_invoice_id'))
            ->groupBy('sku_id')
            ->get();

        Sales_invoice::whereIn('id', $request->input('sales_invoice_id'))
            ->update(['control' => 'printed']);

        return view('sales_invoice_control_print', [
            'sales_invoice' => $sales_invoice,
            'sales_invoice_details' => $sales_invoice_details,
        ]);
    }
}
