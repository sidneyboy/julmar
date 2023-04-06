<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_ledger;
use App\Load_sheet;
use App\Load_sheet_details;
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
            $invoice_draft = Invoice_raw::select('id', 'sales_representative')->where('status', null)->groupBy('sales_representative')->orderBy('id', 'desc')->get();
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
        $invoice_draft = Invoice_raw::select('id', 'customer', 'sales_representative')
            ->where('sales_representative', $request->input('sales_representative'))
            ->groupBy('customer')
            ->get();
        return view('invoice_out_proceed', [
            'invoice_draft' => $invoice_draft,
        ])->with('sales_representative', $request->input('sales_representative'));
    }

    public function invoice_out_final_summary(Request $request)
    {
        //return $request->input();
        $invoice_raw = DB::table('invoice_raws')
            ->select('sku_id', 'sku_type', 'sku_code', 'description', 'principal', 'customer', 'barcode', DB::raw('sum(quantity) as total'))
            ->whereIn('customer', $request->input('checkbox_entry'))
            ->groupBy('sku_id')
            ->get();

        return view('invoice_out_final_summary', [
            'invoice_raw' => $invoice_raw
        ])->with('sales_representative', $request->input('sales_representative'))
            ->with('customer', $request->input('checkbox_entry'));
    }

    public function invoice_out_very_final_summary(Request $request)
    {
        if ($request->input('barcode') != null) {
            $barcode = $request->input('barcode');
            $quantity = $request->input('quantity');
        } else if ($request->input('sku_barcode') != null) {
            $barcode = $request->input('sku_barcode');
            $quantity = $request->input('sku_quantity');
        }
        $invoice_raw = Invoice_raw::select('sku_id', 'barcode', 'description')
            ->where('sales_representative', $request->input('sales_representative'))
            ->where('barcode', $barcode)
            ->first();
        if ($invoice_raw) {
            Invoice_raw::where('sales_representative', $request->input('sales_representative'))
                ->where('sku_id', $invoice_raw->sku_id)
                ->whereIn('customer', $request->input('customer_data'))
                ->update(['remarks' => 'scanned']);

            $cart_checker = \Cart::session(auth()->user()->id)->get($invoice_raw->sku_id);
            if ($cart_checker) {
                \Cart::session(auth()->user()->id)->remove($invoice_raw->sku_id);

                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_raw->sku_id,
                    'name' => $invoice_raw->description,
                    'price' => 0,
                    'quantity' => $quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_raw->sku_id,
                    'name' => $invoice_raw->description,
                    'price' => 0,
                    'quantity' => $quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();

            $invoice_data = Invoice_raw::where('sales_representative', $request->input('sales_representative'))
                ->whereIn('customer', $request->input('customer_data'))
                ->get();

            return view('invoice_out_very_final_summary', [
                'cart' => $cart,
                'invoice_data' => $invoice_data,
                'invoice_raw' => $invoice_raw,
                'sales_representative' => $request->input('sales_representative'),
                'customer' => $request->input('customer_data'),
            ]);
        } else {
            return 'invalid';
        }
    }

    public function invoice_out_saved(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $load_sheet_id = uniqid();

        $cart = Cart::session(auth()->user()->id)->getContent();

        foreach ($request->input('customer_data') as $key => $data) {
            $new_load_sheet = new Load_sheet([
                'load_sheet_id' => $load_sheet_id,
                'agent' => $request->input('sales_representative'),
                'customer' => $data,
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id')[0],
                'date' => $date,
            ]);

            $new_load_sheet->save();
        }

        foreach ($cart as $key => $cart_data) {
            $new_load_sheet_details = new Load_sheet_details([
                'load_sheet_id' => $load_sheet_id,
                'sku_id' => $cart_data->id,
                'quantity' => $cart_data->quantity,
                // 'unit_price',
            ]);

            $new_load_sheet_details->save();

            $sku_id = $cart_data->id;
            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $running_balance = $ledger_results[0]->running_balance - $cart_data->quantity;

            $new_sku_ledger = new Sku_ledger([
                'sku_id' => $cart_data->id,
                'quantity' => $cart_data->quantity,
                'running_balance' => $running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'out from warehouse',
                'all_id' => $load_sheet_id,
                'principal_id' => $ledger_results[0]->principal_id,
                'sku_type' => $ledger_results[0]->sku_type,
            ]);

            $new_sku_ledger->save();
        }
    }
}
