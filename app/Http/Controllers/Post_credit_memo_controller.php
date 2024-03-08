<?php

namespace App\Http\Controllers;

use App\Bad_order;
use App\Bad_order_details;
use App\Bad_order_discounts;
use App\Customer_principal_price;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Return_good_stock_discounts;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_details;
use App\Sku_ledger;
use App\Sku_price_details;
use App\Sku_price_history;
use App\User;
use Carbon\Carbon;
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
                ->where('confirm_status', null)
                ->get();

            $bad_order = Bad_order::select('pcm_number', 'id')
                ->where('status', 'verified')
                ->where('confirm_status', null)
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

    public function post_credit_memo_proceed(Request $request)
    {
        $explode = explode('-', $request->input('cm_id'));
        $transaction = $explode[0];
        $cm_id = $explode[1];

        if ($transaction == 'RGS') {
            $cm_data = Return_good_stock::find($cm_id);
            $sales_invoice = Sales_invoice::select('id', 'delivery_receipt')->where('customer_id', $cm_data->customer_id)
                ->where('payment_status',  null)
                ->orWhere('payment_status', 'partial')
                ->get();
        } elseif ($transaction == 'BO') {
            $cm_data = Bad_order::find($cm_id);
            $sales_invoice = Sales_invoice::select('id', 'delivery_receipt')->where('customer_id', $cm_data->customer_id)
                ->where('payment_status',  null)
                ->orWhere('payment_status', 'partial')
                ->get();
        }

        return view('post_credit_memo_proceed', [
            'cm_data' => $cm_data,
            'cm_id' => $cm_id,
            'sales_invoice' => $sales_invoice,
        ])->with('transaction', $transaction);
    }

    public function post_credit_generate_final_summary(Request $request)
    {
        //return $request->input();
        if ($request->input('transaction') == 'RGS') {
            $cm_data = Return_good_stock::find($request->input('cm_id'));

            if ($request->input('si_id') == 'unidentified') {
                $sales_invoice = $request->input('si_id');
                $customer_discount = 0;
                $customer_price_level = Customer_principal_price::select('price_level')
                    ->where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $request->input('principal_id'))
                    ->first();

                $total_invoice_amount = 0;

                foreach ($cm_data->return_good_stock_details as $key => $details) {
                    $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as price_level')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $sku_ledger = Sku_ledger::select('running_balance', 'running_amount')
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();


                    if ($price_history) {
                        $unit_price[$details->sku_id] = $price_history->price_level;

                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    } else {
                        $price_details = Sku_price_details::select($customer_price_level->price_level . ' as price_level')
                            ->where('sku_id', $details->sku_id)
                            ->first();

                        $unit_price[$details->sku_id] = $price_details->price_level;

                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    }

                    $final_unit_cost[$details->sku_id] = $details->sku->sku_ledger_get_average_cost->final_unit_cost;
                }
            } else {
                $sales_invoice = Sales_invoice::select('id', 'discount_rate', 'delivery_receipt', 'total', 'total_returned_amount')->find($request->input('si_id'));
                $customer_discount = explode('-', $sales_invoice->discount_rate);
                $customer_price_level = Customer_principal_price::select('price_level')
                    ->where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $request->input('principal_id'))
                    ->first();

                $total_invoice_amount = $sales_invoice->total + $sales_invoice->total_returned_amount;

                foreach ($cm_data->return_good_stock_details as $key => $details) {
                    $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as price_level')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();
                    $sku_ledger = Sku_ledger::select('running_balance', 'running_amount')
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($price_history) {
                        $unit_price[$details->sku_id] = $price_history->price_level;

                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    } else {
                        $price_details = Sku_price_details::select($customer_price_level->price_level . ' as price_level')
                            ->where('sku_id', $details->sku_id)
                            ->first();

                        $unit_price[$details->sku_id] = $price_details->price_level;

                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    }
                }

                foreach ($sales_invoice->sales_invoice_details_sku as $key_2 => $invoice_details) {
                    $final_unit_cost[$invoice_details->sku_id] = $invoice_details->final_unit_cost;
                }
            }


            return view('post_credit_generate_final_summary', [
                'cm_data' => $cm_data,
                'final_unit_cost' => $final_unit_cost,
                'sales_invoice' => $sales_invoice,
                'average_cost' => $average_cost,
                'unit_price' => $unit_price,
                'customer_discount' => $customer_discount,
                'total_invoice_amount' => $total_invoice_amount,
            ])->with('transaction', $request->input('transaction'))
                ->with('si_id', $request->input('si_id'));
        } else if ($request->input('transaction') == 'BO') {
            $cm_data = Bad_order::find($request->input('cm_id'));

            if ($request->input('si_id') == 'unidentified') {
                $sales_invoice = $request->input('si_id');
                $customer_discount = 0;
                $customer_price_level = Customer_principal_price::select('price_level')
                    ->where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $request->input('principal_id'))
                    ->first();

                $total_invoice_amount = 0;

                foreach ($cm_data->bad_order_details_sku_id as $key => $details) {
                    $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as price_level')
                        ->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $sku_ledger = Sku_ledger::select('running_balance', 'running_amount')
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();



                    if ($price_history) {
                        $unit_price[$details->sku_id] = $price_history->price_level;
                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    } else {
                        $price_details = Sku_price_details::select($customer_price_level->price_level . ' as price_level')
                            ->where('sku_id', $details->sku_id)
                            ->first();

                        $unit_price[$details->sku_id] = $price_details->price_level;
                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    }
                }
            } else {
                $sales_invoice = Sales_invoice::select('id', 'discount_rate', 'delivery_receipt', 'total', 'total_returned_amount')->find($request->input('si_id'));
                $customer_discount = explode('-', $sales_invoice->discount_rate);
                $customer_price_level = Customer_principal_price::select('price_level')
                    ->where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $request->input('principal_id'))
                    ->first();

                $total_invoice_amount = $sales_invoice->total + $sales_invoice->total_returned_amount;

                foreach ($cm_data->bad_order_details as $key => $details) {
                    $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as price_level')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    $sku_ledger = Sku_ledger::select('running_balance', 'running_amount')
                        ->where('sku_id', $details->sku_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($price_history) {
                        $unit_price[$details->sku_id] = $price_history->price_level;
                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    } else {

                        $price_details = Sku_price_details::select($customer_price_level->price_level . ' as price_level')
                            ->where('sku_id', $details->sku_id)
                            ->first();

                        $unit_price[$details->sku_id] = $price_details->price_level;
                        $average_cost[$details->sku_id] = $sku_ledger->running_amount / $sku_ledger->running_balance;
                    }
                }
            }


            return view('post_credit_generate_final_summary', [
                'cm_data' => $cm_data,
                'sales_invoice' => $sales_invoice,
                'average_cost' => $average_cost,
                'unit_price' => $unit_price,
                'customer_discount' => $customer_discount,
                'total_invoice_amount' => $total_invoice_amount,
            ])->with('transaction', $request->input('transaction'))
                ->with('si_id', $request->input('si_id'));
        }
    }

    public function post_credit_memo_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $checker = Sales_invoice_accounts_receivable::select('running_balance')
            ->where('customer_id', $request->input('customer_id'))
            ->where('principal_id', $request->input('principal_id'))
            ->orderBy('id', 'desc')
            ->first();

        if ($request->input('total_amount') > $checker->running_balance) {
            return 'exceed';
        } else {
            if ($request->input('transaction') == 'RGS') {
                if ($request->input('si_id') == 'unidentified') {
                    Return_good_stock::where('id', $request->input('cm_id'))
                        ->update([
                            'total_amount' => $request->input('total_amount'),
                            'confirmed_date' => $date,
                            'confirm_status' => 'confirmed',
                            'confirmed_by' => auth()->user()->id,
                            'sales_return_and_allowances' => $request->input('total_amount'),
                            'accounts_receivable' => $request->input('total_amount'),
                            'inventory' => $request->input('final_average_cost_total'),
                            'cost_of_goods_sold' => $request->input('final_average_cost_total'),
                        ]);

                    foreach ($request->input('quantity_returned') as $key => $quantity) {

                        $sku_ledger = Sku_ledger::select('sku_type', 'running_balance', 'running_amount', 'with_invoice_quantity', 'with_invoice_net_balance')
                            ->where('sku_id', $key)->orderBy('id', 'desc')->first();

                        if ($sku_ledger) {
                            $running_balance = $sku_ledger->running_balance + $request->input('quantity_returned')[$key];
                            $running_amount = $sku_ledger->running_amount + $request->input('final_total_cost_per_sku')[$key];
                            $with_invoice_quantity = $sku_ledger->with_invoice_quantity;
                            $with_invoice_net_balance = $sku_ledger->with_invoice_net_balance;
                            $new_sku_ledger = new Sku_ledger([
                                'sku_id' => $key,
                                'quantity' => $request->input('quantity_returned')[$key],
                                'running_balance' => $running_balance,
                                'user_id' => auth()->user()->id,
                                'transaction_type' => 'rgs - ' . $request->input('delivery_receipt'),
                                'all_id' => $request->input('cm_id'),
                                'principal_id' => $request->input('principal_id'),
                                'sku_type' => $sku_ledger->sku_type,
                                'final_unit_cost' => $request->input('final_unit_cost')[$key],
                                'amount' => $request->input('final_total_cost_per_sku')[$key],
                                'running_amount' => $running_amount,
                                'with_invoice_quantity' => $with_invoice_quantity,
                                'with_invoice_net_balance' => $with_invoice_net_balance,
                            ]);

                            $new_sku_ledger->save();
                        } else {
                            $with_invoice_quantity = 0;
                            $with_invoice_net_balance = 0;
                            $new_sku_ledger = new Sku_ledger([
                                'sku_id' => $key,
                                'quantity' => $request->input('quantity_returned')[$key],
                                'running_balance' => $request->input('quantity_returned')[$key],
                                'user_id' => auth()->user()->id,
                                'transaction_type' => 'rgs - ' . $request->input('delivery_receipt'),
                                'all_id' => $request->input('cm_id'),
                                'principal_id' => $request->input('principal_id'),
                                'sku_type' => $sku_ledger->sku_type,
                                'final_unit_cost' => $request->input('final_unit_cost')[$key],
                                'amount' => $request->input('final_total_cost_per_sku')[$key],
                                'running_amount' => $request->input('final_total_cost_per_sku')[$key],
                                'with_invoice_quantity' => $request->input('quantity_returned')[$key],
                                'with_invoice_net_balance' => $request->input('quantity_returned')[$key],
                            ]);

                            $new_sku_ledger->save();
                        }
                    }
                } else {
                    //return $request->input();
                    foreach ($request->input('quantity_returned') as $key => $quantity) {

                        $sku_ledger = Sku_ledger::select('sku_type', 'running_balance', 'running_amount', 'with_invoice_quantity', 'with_invoice_net_balance')->where('sku_id', $key)->orderBy('id', 'desc')->first();

                        if ($sku_ledger) {
                            $running_balance = $sku_ledger->running_balance + $request->input('quantity_returned')[$key];
                            $running_amount = $sku_ledger->running_amount + $request->input('final_total_cost_per_sku')[$key];
                            $with_invoice_quantity = $sku_ledger->with_invoice_quantity;
                            $with_invoice_net_balance = $sku_ledger->with_invoice_net_balance;
                            $new_sku_ledger = new Sku_ledger([
                                'sku_id' => $key,
                                'quantity' => $request->input('quantity_returned')[$key],
                                'running_balance' => $running_balance,
                                'user_id' => auth()->user()->id,
                                'transaction_type' => 'rgs - ' . $request->input('delivery_receipt'),
                                'all_id' => $request->input('cm_id'),
                                'principal_id' => $request->input('principal_id'),
                                'sku_type' => $sku_ledger->sku_type,
                                'final_unit_cost' => $request->input('final_unit_cost')[$key],
                                'amount' => $request->input('final_total_cost_per_sku')[$key],
                                'running_amount' => $running_amount,
                                'with_invoice_quantity' => $with_invoice_quantity,
                                'with_invoice_net_balance' => $with_invoice_net_balance,
                            ]);

                            $new_sku_ledger->save();
                        } else {
                            $with_invoice_quantity = 0;
                            $with_invoice_net_balance = 0;
                            $new_sku_ledger = new Sku_ledger([
                                'sku_id' => $key,
                                'quantity' => $request->input('quantity_returned')[$key],
                                'running_balance' => $request->input('quantity_returned')[$key],
                                'user_id' => auth()->user()->id,
                                'transaction_type' => 'rgs - ' . $request->input('delivery_receipt'),
                                'all_id' => $request->input('cm_id'),
                                'principal_id' => $request->input('principal_id'),
                                'sku_type' => $sku_ledger->sku_type,
                                'final_unit_cost' => $request->input('final_unit_cost')[$key],
                                'amount' => $request->input('final_total_cost_per_sku')[$key],
                                'running_amount' => $request->input('final_total_cost_per_sku')[$key],
                                'with_invoice_quantity' => $request->input('quantity_returned')[$key],
                                'with_invoice_net_balance' => $request->input('quantity_returned')[$key],
                            ]);

                            $new_sku_ledger->save();
                        }

                        $sales_invoice_details_data = Sales_invoice_details::select('quantity_returned')
                            ->where('sales_invoice_id', $request->input('si_id'))
                            ->where('sku_id', $key)
                            ->first();

                        $new_quantity = $sales_invoice_details_data->quantity_returned + $quantity;

                        Sales_invoice_details::where('sales_invoice_id', $request->input('si_id'))
                            ->where('sku_id', $key)
                            ->update(['quantity_returned' => $new_quantity]);

                        Return_good_stock_details::where('return_good_stock_id', $request->input('cm_id'))
                            ->where('sku_id', $key)
                            ->update(['unit_price' => $request->input('unit_price')[$key]]);
                    }

                    if ($request->input('customer_discount') != 0) {
                        foreach ($request->input('customer_discount') as $key_2 => $final_customer_discount) {
                            $add_new_cm_discount = new Return_good_stock_discounts([
                                'return_good_stock_id' => $request->input('cm_id'),
                                'discount_rate' => $final_customer_discount,
                            ]);

                            $add_new_cm_discount->save();
                        }
                    }

                    
                    // Sales_invoice::where('id', $request->input('si_id'))
                    //     ->update([
                    //         'total_returned_amount' => $request->input('total_amount'),
                    //     ]);

                    Return_good_stock::where('id', $request->input('cm_id'))
                        ->update([
                            'total_amount' => $request->input('total_amount'),
                            'confirmed_date' => $date,
                            'confirm_status' => 'confirmed',
                            'confirmed_by' => auth()->user()->id,
                            'si_id' => $request->input('si_id'),
                            'sales_return_and_allowances' => $request->input('total_amount'),
                            'accounts_receivable' => $request->input('total_amount'),
                            'inventory' => $request->input('final_average_cost_total'),
                            'cost_of_goods_sold' => $request->input('final_average_cost_total'),
                        ]);
                }
            } else if ($request->input('transaction') == 'BO') {
                if ($request->input('si_id') == 'unidentified') {
                    Bad_order::where('id', $request->input('cm_id'))
                        ->update([
                            'total_amount' => $request->input('total_amount'),
                            'confirm_status' => 'confirmed',
                            'confirmed_by' => auth()->user()->id,
                            'confirmed_date' => $date,
                            'spoiled_goods' => $request->input('total_amount'),
                            'accounts_receivable' => $request->input('total_amount'),
                        ]);
                } else {
                    foreach ($request->input('quantity_returned') as $key => $quantity) {
                        Bad_order_details::where('bad_order_id', $request->input('cm_id'))
                            ->where('sku_id', $key)
                            ->update(['unit_price' => $request->input('unit_price')[$key]]);
                    }

                    if ($request->input('customer_discount') != 0) {
                        foreach ($request->input('customer_discount') as $key_2 => $final_customer_discount) {
                            $add_new_cm_discount = new Bad_order_discounts([
                                'bad_order_id' => $request->input('cm_id'),
                                'discount_rate' => $final_customer_discount,
                            ]);

                            $add_new_cm_discount->save();
                        }
                    }

                    Bad_order::where('id', $request->input('cm_id'))
                        ->update([
                            'total_amount' => $request->input('total_amount'),
                            'confirm_status' => 'confirmed',
                            'confirmed_by' => auth()->user()->id,
                            'confirmed_date' => $date,
                            'si_id' => $request->input('si_id'),
                            'spoiled_goods' => $request->input('total_amount'),
                            'accounts_receivable' => $request->input('total_amount'),
                        ]);
                }
            }
        }
    }
}
