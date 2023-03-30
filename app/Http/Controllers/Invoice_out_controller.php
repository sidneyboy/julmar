<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice_draft;
use App\Invoice_draft_details;
use App\Sku_add;
use App\Sku_ledger;
use App\Invoice_raw;
use DB;
use Cart;
use Illuminate\Http\Request;

class Invoice_out_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $invoice_draft = Invoice_raw::select('id', 'delivery_receipt')->where('status', null)->groupBy('delivery_receipt')->orderBy('id', 'desc')->get();
            return view('invoice_out', [
                'user' => $user,
                'invoice_draft' => $invoice_draft,
                'main_tab' => 'manage_warehouse_main_tab',
                'sub_tab' => 'manage_warehouse_sub_tab',
                'active_tab' => 'invoice_out',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_out_proceed(Request $request)
    {
        $invoice_draft = Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))->get();
        return view('invoice_out_proceed', [
            'invoice_draft' => $invoice_draft,
        ])->with('delivery_receipt', $request->input('delivery_receipt'));

        // $sku = Sku_add::select('id')->where('barcode', $request->input('barcode'))->where('sku_type', $invoice_draft->sku_type)->first();

        // if ($sku) {
        //     Invoice_draft_details::where('sku_id', $sku->id)
        //         ->where('invoice_draft_id', $request->input('invoice_id'))
        //         ->update(['scanned_remarks' => 'scanned']);

        //     $invoice_draft_details = Invoice_draft_details::where('invoice_draft_id', $request->input('invoice_id'))->get();

        //     return view('invoice_out_proceed', [
        //         'invoice_draft_details' => $invoice_draft_details,
        //     ])->with('invoice_id', $request->input('invoice_id'));
        // } else {
        //     return 'Non Existing SKU Barcode';
        // }
    }

    public function invoice_out_final_summary(Request $request)
    {
        $invoice_raw = Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))
            ->where('barcode', $request->input('barcode'))
            ->first();

        if ($invoice_raw) {
            Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))
                ->where('barcode', $request->input('barcode'))
                ->update(['remarks' => 'scanned']);

            $cart_checker = \Cart::session(auth()->user()->id)->get($invoice_raw->sku_id);
            if ($cart_checker) {
                \Cart::session(auth()->user()->id)->remove($invoice_raw->sku_id);

                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_raw->sku_id,
                    'name' => $invoice_raw->sku->description,
                    'price' => 0,
                    'quantity' => $request->input('confirmed_quantity'),
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_raw->sku_id,
                    'name' => $invoice_raw->sku->description,
                    'price' => 0,
                    'quantity' => $request->input('confirmed_quantity'),
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();

            $invoice_data = Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))
                ->get();

            return view('invoice_out_final_summary', [
                'cart' => $cart,
                'invoice_data' => $invoice_data,
                'invoice_raw' => $invoice_raw,
                'delivery_receipt' => $request->input('delivery_receipt'),
            ]);
        } else {
            return 'invalid';
        }
    }

    public function invoice_out_saved(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->getContent();
        foreach ($cart as $key => $data) {
            Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))
                ->where('sku_id', $data->id)
                ->update([
                    'final_quantity' => $data->quantity,
                    'user_id' => auth()->user()->id,
                    'status' => 'complete',
                ]);

            $sku_id = $data->id;

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {
                $running_balance = $ledger_results[0]->running_balance - $data->quantity;
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data->id,
                    'quantity' => $data->quantity,
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'out from warehouse',
                    'all_id' => $request->input('delivery_receipt'),
                    'principal_id' => $ledger_results[0]->principal_id,
                    'sku_type' => $ledger_results[0]->sku_type,
                ]);

                $new_sku_ledger->save();
            } else {
                return 'ledger_error';
            }
        }
    }
}
