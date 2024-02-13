<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Bad_order;
use App\Bad_order_details;
use App\Bad_order_discounts;
use App\Customer_discount;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Return_good_stock_discounts;
use Cart;
use DB;
use App\Sku_ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Warehouse_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            if ($user->position == 'admin') {
                $bo = Bad_order::select('id', 'pcm_number', 'principal_id', 'agent_id')
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();
                $rgs = Return_good_stock::select('id', 'pcm_number', 'principal_id', 'agent_id')
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $bo = Bad_order::select('id', 'pcm_number', 'principal_id', 'agent_id')
                    ->where('principal_id', $user->principal_id)
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();
                $rgs = Return_good_stock::select('id', 'pcm_number', 'principal_id', 'agent_id')
                    ->where('principal_id', $user->principal_id)
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();
            }

            return view('warehouse_pcm', [
                'user' => $user,
                'bo' => $bo,
                'rgs' => $rgs,
                'main_tab' => 'manage_pcm_custodian_main_tab',
                'sub_tab' => 'manage_pcm_custodian_sub_tab',
                'active_tab' => 'warehouse_pcm',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_pcm_proceed(Request $request)
    {
        $explode = explode('-', $request->input('pcm_id'));
        $type = $explode[0];
        $id = $explode[1];

        if ($type == 'rgs') {
            $pcm = Return_good_stock::select('id', 'customer_id', 'principal_id')->find($id);
            $pcm_details = Return_good_stock_details::where('return_good_stock_id', $id)
                ->get();
        } else if ($type == 'bo') {
            $pcm = Bad_order::select('id', 'customer_id', 'principal_id')->find($id);
            $pcm_details = Bad_order_details::where('bad_order_id', $id)
                ->get();
        }

        return view('warehouse_pcm_proceed', [
            'pcm' => $pcm,
            'pcm_details' => $pcm_details,
        ])->with('type', $type)
            ->with('id', $id);
    }


    public function warehouse_pcm_final_summary(Request $request)
    {
        if ($request->input('type') == 'rgs') {
            if ($request->input('barcode') != null) {
                $barcode = $request->input('barcode');
                $quantity = $request->input('quantity');
                $checker = Sku_add::select('id')->where('barcode', $barcode)->first();
            } else if ($request->input('sku_barcode') != null) {
                $barcode = $request->input('sku_barcode');
                $quantity = $request->input('sku_quantity');
                $checker = Sku_add::select('id')->where('id', $barcode)->first();
            }

            if ($checker) {
                $pcm_details = Return_good_stock_details::where('return_good_stock_id', $request->input('id'))
                    ->where('sku_id', $checker->id)
                    ->first();

                if ($pcm_details) {
                    $pcm = Return_good_stock::find($request->input('id'));
                    Return_good_stock_details::where('id', $pcm_details->id)
                        ->update([
                            'scanned_by' => auth()->user()->id,
                            'remarks' => 'scanned',
                        ]);


                    $cart_checker = \Cart::session(auth()->user()->id)->get($pcm_details->sku_id);


                    if ($cart_checker) {
                        \Cart::session(auth()->user()->id)->remove($pcm_details->sku_id);

                        \Cart::session(auth()->user()->id)->add(array(
                            'id' => $pcm_details->sku_id,
                            'name' => $pcm_details->sku->description,
                            'price' => $pcm_details->unit_price,
                            'quantity' => $quantity,
                            'attributes' => array(),
                            'associatedModel' => $pcm_details,
                        ));
                    } else {
                        \Cart::session(auth()->user()->id)->add(array(
                            'id' => $pcm_details->sku_id,
                            'name' => $pcm_details->sku->description,
                            'price' => $pcm_details->unit_price,
                            'quantity' => $quantity,
                            'attributes' => array(),
                            'associatedModel' => $pcm_details,
                        ));
                    }

                    $cart = Cart::session(auth()->user()->id)->getContent();

                    $customer_discount = Customer_discount::select('id', 'customer_discount')
                        ->where('customer_id', $request->input('customer_id'))
                        ->where('principal_id', $request->input('principal_id'))
                        ->get();

                    return view('warehouse_pcm_final_summary', [
                        'pcm' => $pcm,
                        'cart' => $cart,
                        'customer_discount' => $customer_discount,
                    ])->with('type', $request->input('type'))
                        ->with('id', $request->input('id'));
                } else {
                    return 'invalid';
                }
            } else {
                return 'invalid';
            }
        } else if ($request->input('type') == 'bo') {
            if ($request->input('barcode') != null) {
                $barcode = $request->input('barcode');
                $quantity = $request->input('quantity');
                $checker = Sku_add::select('id')->where('barcode', $barcode)->first();
            } else if ($request->input('sku_barcode') != null) {
                $barcode = $request->input('sku_barcode');
                $quantity = $request->input('sku_quantity');
                $checker = Sku_add::select('id')->where('id', $barcode)->first();
            }

            if ($checker) {
                $pcm_details = Bad_order_details::where('bad_order_id', $request->input('id'))
                    ->where('sku_id', $checker->id)
                    ->first();

                if ($pcm_details) {
                    $pcm = Bad_order::find($request->input('id'));
                    Bad_order_details::where('id', $pcm_details->id)
                        ->update([
                            'user_id' => auth()->user()->id,
                            'remarks' => 'scanned',
                        ]);


                    $cart_checker = \Cart::session(auth()->user()->id)->get($pcm_details->sku_id);


                    if ($cart_checker) {
                        \Cart::session(auth()->user()->id)->remove($pcm_details->sku_id);

                        \Cart::session(auth()->user()->id)->add(array(
                            'id' => $pcm_details->sku_id,
                            'name' => $pcm_details->sku->description,
                            'price' => $pcm_details->unit_price,
                            'quantity' => $quantity,
                            'attributes' => array(),
                            'associatedModel' => $pcm_details,
                        ));
                    } else {
                        \Cart::session(auth()->user()->id)->add(array(
                            'id' => $pcm_details->sku_id,
                            'name' => $pcm_details->sku->description,
                            'price' => $pcm_details->unit_price,
                            'quantity' => $quantity,
                            'attributes' => array(),
                            'associatedModel' => $pcm_details,
                        ));
                    }

                    $cart = Cart::session(auth()->user()->id)->getContent();

                    // $customer_discount = Customer_discount::select('id', 'customer_discount')
                    //     ->where('customer_id', $request->input('customer_id'))
                    //     ->where('principal_id', $request->input('principal_id'))
                    //     ->get();

                    return view('warehouse_pcm_final_summary', [
                        'pcm' => $pcm,
                        'cart' => $cart,
                        // 'customer_discount' => $customer_discount,
                    ])->with('type', $request->input('type'))
                        ->with('id', $request->input('id'));
                } else {
                    return 'invalid';
                }
            } else {
                return 'invalid';
            }
        }
    }

    public function warehouse_pcm_save(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        return $request->input();
        if ($request->input('type') == 'rgs') {
            $cart = Cart::session(auth()->user()->id)->getContent();

            Return_good_stock::where('id', $request->input('id'))
                ->update([
                    'status' => 'verified',
                    'verified_date' => $date,
                    'verified_by' => auth()->user()->id,
                    'total_amount' => 0,
                ]);

            foreach ($cart as $key => $data) {
                Return_good_stock_details::where('sku_id', $data->id)
                    ->where('return_good_stock_id', $request->input('id'))
                    ->update([
                        'confirmed_quantity' => $data->quantity,
                        'user_id' => auth()->user()->id,
                    ]);

                // $get_sku_ledger = Sku_ledger::where('sku_id', $data->id)->orderBy('id', 'desc')->first();
                // $running_balance = $get_sku_ledger->running_balance + $data->quantity;
                // $new_sku_ledger = new Sku_ledger([
                //     'sku_id' => $data->id,
                //     'quantity' => $data->quantity,
                //     'running_balance' => $running_balance,
                //     'user_id' => auth()->user()->id,
                //     'transaction_type' => "rgs verified cm",
                //     'all_id' => $request->input('id'),
                //     'principal_id' => $get_sku_ledger->principal_id,
                //     'sku_type' => $get_sku_ledger->sku_type,
                //     'amount' => $get_sku_ledger->amount,
                //     'running_amount' => $get_sku_ledger->running_amount,
                //     'final_unit_cost' => $get_sku_ledger->final_unit_cost,
                //     'with_invoice_quantity' => $request->input('final_quantity')[$data],
                //     'with_invoice_net_balance' => $get_sku_ledger->running_balance - $request->input('final_quantity')[$data],
                // ]);

                // $new_sku_ledger->save();
            }

            // foreach ($request->input('discount_rate') as $key => $discount_rate) {
            //     $new_discount_rate_rgs = new Return_good_stock_discounts([
            //         'return_good_stock_id' => $request->input('id'),
            //         'discount_rate' => $discount_rate,
            //     ]);

            //     $new_discount_rate_rgs->save();
            // }
        } else {
            $cart = Cart::session(auth()->user()->id)->getContent();
            Bad_order::where('id', $request->input('id'))
                ->update([
                    'status' => 'verified',
                    'verified_date' => $date,
                    'verified_by' => auth()->user()->id,
                    'total_amount' => 0,
                ]);
            foreach ($cart as $key => $data) {
                Bad_order_details::where('sku_id', $data->id)
                    ->where('bad_order_id', $request->input('id'))
                    ->update([
                        'confirmed_quantity' => $data->quantity,
                        'user_id' => auth()->user()->id,
                    ]);
            }

            // foreach ($request->input('discount_rate') as $key => $discount_rate) {
            //     $new_discount_rate_bo = new Bad_order_discounts([
            //         'bad_order_id' => $request->input('id'),
            //         'discount_rate' => $discount_rate,
            //     ]);

            //     $new_discount_rate_bo->save();
            // }
        }
    }
}
