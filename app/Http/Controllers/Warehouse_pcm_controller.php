<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Bad_order;
use App\Bad_order_details;
use App\Return_good_stock;
use App\Return_good_stock_details;
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
            $bo = Bad_order::select('id', 'pcm_number', 'principal_id', 'agent_id')
                ->where('principal_id', $user->principal_id)
                ->orderBy('id', 'desc')
                ->get();
            $rgs = Return_good_stock::select('id', 'pcm_number', 'principal_id', 'agent_id')
                ->where('principal_id', $user->principal_id)
                ->orderBy('id', 'desc')
                ->get();
            return view('warehouse_pcm', [
                'user' => $user,
                'bo' => $bo,
                'rgs' => $rgs,
                'main_tab' => 'manage_warehouse_main_tab',
                'sub_tab' => 'manage_warehouse_sub_tab',
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
            $pcm = Return_good_stock::find($id);
            $pcm_details = Return_good_stock_details::where('return_good_stock_id', $id)
                ->get();
        } else if ($type == 'bo') {
            $pcm = Bad_order::find($id);
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

                    return view('warehouse_pcm_final_summary', [
                        'pcm' => $pcm,
                        'cart' => $cart,
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

                    return view('warehouse_pcm_final_summary', [
                        'pcm' => $pcm,
                        'cart' => $cart,
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
        if ($request->input('type') == 'rgs') {
            $cart = Cart::session(auth()->user()->id)->getContent();
            Return_good_stock::where('id', $request->input('id'))
                ->update([
                    'status' => 'scanned',
                ]);
            foreach ($cart as $key => $data) {
                Return_good_stock_details::where('sku_id', $data->id)
                    ->where('return_good_stock_id', $request->input('id'))
                    ->update([
                        'confirmed_quantity' => $data->quantity,
                        'user_id' => auth()->user()->id,
                    ]);

                $sku_id_data = $data->id;
                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                $running_balance = $ledger_results[0]->running_balance + $data->quantity;
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $sku_id_data,
                    'quantity' => $data->quantity,
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'booking cm',
                    'all_id' => $request->input('id'),
                    'principal_id' => $ledger_results[0]->principal_id,
                    'sku_type' => $ledger_results[0]->sku_type,
                ]);

                $new_sku_ledger->save();
            }
        } else {
            $cart = Cart::session(auth()->user()->id)->getContent();
            Bad_order::where('id', $request->input('id'))
                ->update([
                    'status' => 'scanned',
                ]);
            foreach ($cart as $key => $data) {
                Bad_order_details::where('sku_id', $data->id)
                    ->where('bad_order_id', $request->input('id'))
                    ->update([
                        'confirmed_quantity' => $data->quantity,
                        'user_id' => auth()->user()->id,
                    ]);
            }
        }
    }
}
