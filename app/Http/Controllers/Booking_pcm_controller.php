<?php

namespace App\Http\Controllers;

use App\User;
use App\Agent;
use App\Customer;
use App\Sku_principal;
use App\Sku_add;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Bad_order;
use App\Bad_order_details;
use App\Sales_invoice;
use App\Sales_invoice_details;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Booking_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            \Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $agent = Agent::select('id', 'full_name')
                ->where('status', 'active')->get();
            // $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            // $customer = Customer::select('id', 'store_name')->where('kind_of_business', '!=', 'VAN SELLING')->get();
            return view('booking_pcm', [
                'user' => $user,
                'agent' => $agent,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'booking_pcm',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function booking_pcm_show_invoice(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'delivery_receipt')
            ->where('agent_id', $request->input('agent_id'))
            ->where('payment_status', null)
            ->orWhere('payment_status', 'partial')
            ->get();

        return view('booking_pcm_show_invoice', [
            'sales_invoice' => $sales_invoice,
        ]);
    }

    public function booking_pcm_proceed(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'customer_id', 'agent_id', 'delivery_receipt', 'sku_type', 'principal_id')
            ->find($request->input('sales_invoice_id'));

        return view('booking_pcm_proceed', [
            'sales_invoice' => $sales_invoice,
        ]);
    }

    public function booking_pcm_proceed_final_summary(Request $request)
    {
        $quantity_returned = array_filter($request->input('quantity_returned'));
        foreach ($quantity_returned as $key => $quantity_data) {
            if ($request->input('quantity')[$key] < $quantity_data) {
                return 'quantity_exceed';
            }
        }

        $sales_invoice_details = Sales_invoice_details::whereIn('id', array_keys($quantity_returned))
            ->get();

        return view('booking_pcm_proceed_final_summary', [
            'principal_id' => $request->input('principal_id'),
            'sales_invoice_id' => $request->input('sales_invoice_id'),
            'sku_type' => $request->input('sku_type'),
            'agent_id' => $request->input('agent_id'),
            'customer_id' => $request->input('customer_id'),
            'quantity_returned' => $quantity_returned,
            'sales_invoice_details' => $sales_invoice_details,
        ]);
    }

    public function booking_pcm_save(Request $request)
    {
        $checker = Return_good_stock::select('pcm_number')->where('pcm_number', $request->input('pcm_number'))
            ->first();

        if ($checker) {
           return 'existing pcm number';
        } else {
            $new_rgs = new Return_good_stock([
                'delivery_receipt' => $request->input('delivery_receipt'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'total_amount' => $request->input('total_amount'),
                'pcm_number' => $request->input('pcm_number'),
                'agent_id' => $request->input('agent_id'),
                'customer_id' => $request->input('customer_id'),
                'si_id' => $request->input('sales_invoice_id'),
                'returned_by' => strtoupper($request->input('returned_by')),
            ]);

            $new_rgs->save();

            foreach ($request->input('quantity_returned') as $key => $data) {
                $new_rgs_details = new Return_good_stock_details([
                    'return_good_stock_id' => $new_rgs->id,
                    'sku_id' => $key,
                    'quantity' => $data,
                    'unit_price' => $request->input('unit_price')[$key],
                    'user_id' => auth()->user()->id,
                    'remarks' => $request->input('remarks')[$key],
                ]);

                $new_rgs_details->save();
            }
        }
    }
}
