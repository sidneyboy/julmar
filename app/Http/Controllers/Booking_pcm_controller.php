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
use App\Return_good_stock_discounts;
use App\Sales_invoice;
use App\Sales_invoice_details;
use App\Sku_ledger;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->where('status', 'out')
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

        if ($sales_invoice_details[0]->sales_invoice->discount_rate == 'none') {
            $customer_discount = 0;
        } else {
            $customer_discount = explode('-', $sales_invoice_details[0]->sales_invoice->discount_rate);
        }

        return view('booking_pcm_proceed_final_summary', [
            'principal_id' => $request->input('principal_id'),
            'sales_invoice_id' => $request->input('sales_invoice_id'),
            'sku_type' => $request->input('sku_type'),
            'agent_id' => $request->input('agent_id'),
            'customer_id' => $request->input('customer_id'),
            'quantity_returned' => $quantity_returned,
            'sales_invoice_details' => $sales_invoice_details,
            'customer_discount' => $customer_discount,
        ]);
    }

    public function booking_pcm_save(Request $request)
    {
        //return $request->input();
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
                'pcm_number' => strtoupper($request->input('pcm_number')),
                'agent_id' => $request->input('agent_id'),
                'customer_id' => $request->input('customer_id'),
                'si_id' => $request->input('sales_invoice_id'),
                'returned_by' => strtoupper($request->input('returned_by')),
                'verified_by_name' => strtoupper($request->input('verified_by')),
                'verified_date' => $request->input('verified_date'),
                'status' => 'verified',
            ]);

            $new_rgs->save();

            foreach ($request->input('quantity_returned') as $key => $data) {
                $new_rgs_details = new Return_good_stock_details([
                    'return_good_stock_id' => $new_rgs->id,
                    'sku_id' => $key,
                    'confirmed_quantity' => $data,
                    'unit_price' => $request->input('unit_price')[$key],
                    'user_id' => auth()->user()->id,
                    'remarks' => $request->input('remarks')[$key],
                ]);

                $new_rgs_details->save();


                $sku_id_data = $key;
                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


                $running_balance = $ledger_results[0]->running_balance + $data;
                $unit_cost_per_sku = $data * $request->input('unit_price')[$sku_id_data];
                $running_amount = $ledger_results[0]->running_amount + $unit_cost_per_sku;
                $with_invoice_quantity = $ledger_results[0]->with_invoice_quantity;
                $with_invoice_net_balance = $ledger_results[0]->with_invoice_net_balance;
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $sku_id_data,
                    'quantity' => $data,
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'booking cm',
                    'all_id' => $new_rgs->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => strtoupper($request->input('sku_type')),
                    'final_unit_cost' => $ledger_results[0]->running_amount / $ledger_results[0]->running_balance,
                    'amount' => $unit_cost_per_sku,
                    'running_amount' => $running_amount,
                    'with_invoice_quantity' => $with_invoice_quantity,
                    'with_invoice_net_balance' => $with_invoice_net_balance,
                ]);

                $new_sku_ledger->save();
            }

            if (count($request->input('customer_discount')) > 0) {
                foreach ($request->input('customer_discount') as $key => $discount_rate) {
                    $new_discount_rate_rgs = new Return_good_stock_discounts([
                        'return_good_stock_id' => $new_rgs->id,
                        'discount_rate' => $discount_rate,
                    ]);

                    $new_discount_rate_rgs->save();
                }
            }
        }
    }
}
