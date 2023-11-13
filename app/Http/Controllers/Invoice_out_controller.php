<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_ledger;
use App\Load_sheet;
use App\Load_sheet_details;
use App\Invoice_raw;
use App\Vs_withdrawal;
use App\Vs_withdrawal_details;
use App\Sku_add;
use App\Sales_invoice;
use App\Sales_invoice_details;
use DB;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Invoice_out_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            if ($user->position == 'admin') {
                $invoice_draft = Invoice_raw::select('id', 'sales_representative')
                    ->where('status', null)
                    ->groupBy('sales_representative')
                    ->orderBy('id', 'desc')
                    ->get();
                $van_selling = Vs_withdrawal::select('id', 'delivery_receipt')
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();

                $sales_invoice = Sales_invoice::select('id', 'delivery_receipt', 'principal_id')
                    ->where('status', 'printed')
                    ->get();
            } else {

                // $invoice_draft = Invoice_raw::select('id', 'sales_representative')
                //     ->where('principal_id', $user->principal_id)
                //     ->where('status', null)
                //     ->groupBy('sales_representative')
                //     ->orderBy('id', 'desc')
                //     ->get();

                $van_selling = Vs_withdrawal::select('id', 'delivery_receipt')
                    ->where('principal_id', $user->principal_id)
                    ->where('status', null)
                    ->orderBy('id', 'desc')
                    ->get();

                $sales_invoice = Sales_invoice::select('id', 'delivery_receipt', 'principal_id')
                    ->where('status', 'printed')
                    ->get();
            }
            return view('invoice_out', [
                'user' => $user,
                // 'invoice_draft' => $invoice_draft,
                'van_selling' => $van_selling,
                'sales_invoice' => $sales_invoice,
                'main_tab' => 'manage_warehouse_main_tab',
                'sub_tab' => 'manage_warehouse_sub_tab',
                'active_tab' => 'invoice_out',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_out_proceed(Request $request)
    {
        $explode = explode('-', $request->input('sales_representative'));
        $transaction = $explode[0];
        $rep_dr = $explode[1];

        if ($transaction == 'booking') {
            $invoice_draft = Invoice_raw::select('id', 'customer', 'sales_representative')
                ->where('sales_representative', $rep_dr)
                ->where('status', null)
                ->groupBy('customer')
                ->get();
            return view('invoice_out_proceed', [
                'invoice_draft' => $invoice_draft,
            ])->with('sales_representative', $rep_dr)
                ->with('transaction', $transaction);
        } elseif ($transaction == 'van') {
            $van_selling_draft = Vs_withdrawal_details::where('vs_withdrawal_id', $rep_dr)
                ->get();
            return view('invoice_out_van_proceed', [
                'van_selling_draft' => $van_selling_draft,
            ])->with('rep_dr', $rep_dr)
                ->with('transaction', $transaction);
        } else if ($transaction == 'agent_booking') {

            $sales_invoice_details = Sales_invoice_details::where('sales_invoice_id', $rep_dr)
                ->get();

            return view('invoice_out_sales_invoice_proceed', [
                'sales_invoice_details' => $sales_invoice_details,
            ])->with('rep_dr', $rep_dr)
                ->with('transaction', $transaction);
        }
    }

    public function invoice_out_final_summary(Request $request)
    {
        //return $request->input();
        $invoice_raw = Invoice_raw::select('sku_id', 'sku_type', 'sku_code', 'description', 'principal', 'customer', 'barcode', DB::raw('sum(quantity) as total'))
            ->whereIn('customer', $request->input('checkbox_entry'))
            ->where('status', null)
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
            $invoice_raw = Invoice_raw::select('sku_id', 'barcode', 'description', DB::raw('sum(quantity) as total_quantity'))
                ->where('sales_representative', $request->input('sales_representative'))
                ->where('barcode', $barcode)
                ->groupBy('sku_id')
                ->first();
        } else if ($request->input('sku_barcode') != null) {
            $barcode = $request->input('sku_barcode');
            $invoice_raw = Invoice_raw::select('sku_id', 'barcode', 'description', DB::raw('sum(quantity) as total_quantity'))
                ->where('sales_representative', $request->input('sales_representative'))
                ->where('sku_id', $barcode)
                ->groupBy('sku_id')
                ->first();
        }

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
                    'quantity' => $invoice_raw->total_quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_raw->sku_id,
                    'name' => $invoice_raw->description,
                    'price' => 0,
                    'quantity' => $invoice_raw->total_quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_raw,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();

            $invoice_data = Invoice_raw::select('*', DB::raw('sum(quantity) as total_quantity'))
                ->where('sales_representative', $request->input('sales_representative'))
                ->whereIn('customer', $request->input('customer_data'))
                ->groupBy('sku_id')
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


            Invoice_raw::where('sku_id', $sku_id)
                ->where('sales_representative', $request->input('sales_representative'))
                ->whereIn('customer', $request->input('customer_data'))
                ->update(['status' => 'out']);


            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $running_balance = $ledger_results[0]->running_balance - $cart_data->quantity;
            $amount = $ledger_results[0]->running_amount / $ledger_results[0]->running_balance;
            $running_amount = $ledger_results[0]->running_amount - $amount;
            $new_sku_ledger = new Sku_ledger([
                'sku_id' => $cart_data->id,
                'quantity' => $cart_data->quantity,
                'running_balance' => $running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'out from warehouse uploaded data from peachtree',
                'all_id' => $load_sheet_id,
                'principal_id' => $ledger_results[0]->principal_id,
                'sku_type' => $ledger_results[0]->sku_type,
                'amount' => $amount,
                'running_amount' => $running_amount,
            ]);

            $new_sku_ledger->save();
        }
    }

    public function invoice_out_van_final_summary(Request $request)
    {
        if ($request->input('barcode') != null) {
            $barcode = $request->input('barcode');
            $sku_add = Sku_add::select('id', 'barcode')
                ->where('barcode', $barcode)
                ->first();
            $vs_details = Vs_withdrawal_details::where('vs_withdrawal_id', $request->input('rep_dr'))
                ->where('sku_id', $sku_add->id)
                ->first();
        } else if ($request->input('sku_barcode') != null) {
            $barcode = $request->input('sku_barcode');
            $vs_details = Vs_withdrawal_details::where('vs_withdrawal_id', $request->input('rep_dr'))
                ->where('sku_id', $barcode)
                ->first();
        }

        if ($vs_details) {
            Vs_withdrawal_details::where('vs_withdrawal_id', $request->input('rep_dr'))
                ->where('sku_id', $vs_details->sku_id)
                ->update(['remarks' => 'scanned']);

            $cart_checker = \Cart::session(auth()->user()->id)->get($vs_details->sku_id);
            if ($cart_checker) {
                \Cart::session(auth()->user()->id)->remove($vs_details->sku_id);

                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $vs_details->sku_id,
                    'name' => $vs_details->sku->description,
                    'price' => 0,
                    'quantity' => $vs_details->quantity,
                    'attributes' => array(),
                    'associatedModel' => $vs_details,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $vs_details->sku_id,
                    'name' => $vs_details->sku->description,
                    'price' => 0,
                    'quantity' => $vs_details->quantity,
                    'attributes' => array(),
                    'associatedModel' => $vs_details,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();
            $vs_withdrawal_details = Vs_withdrawal_details::where('vs_withdrawal_id', $request->input('rep_dr'))
                ->get();

            return view('invoice_out_van_final_summary', [
                'cart' => $cart,
                'vs_withdrawal_details' => $vs_withdrawal_details,
                'vs_details' => $vs_details,
                'rep_dr' => $request->input('rep_dr'),
            ]);
        } else {
            return 'invalid';
        }
    }

    public function invoice_out_van_saved(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $load_sheet_id = uniqid();

        $cart = Cart::session(auth()->user()->id)->getContent();

        foreach ($cart as $key => $cart_data) {
            $sku_id = $cart_data->id;
            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $running_balance = $ledger_results[0]->running_balance - $cart_data->quantity;
            $amount = $ledger_results[0]->running_amount / $ledger_results[0]->running_balance;
            $running_amount = $ledger_results[0]->running_amount - $amount;
            $new_sku_ledger = new Sku_ledger([
                'sku_id' => $cart_data->id,
                'quantity' => $cart_data->quantity,
                'running_balance' => $running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'out from warehouse van selling',
                'all_id' => $request->input('rep_dr'),
                'principal_id' => $ledger_results[0]->principal_id,
                'sku_type' => $ledger_results[0]->sku_type,
                'amount' => $amount,
                'running_amount' => $running_amount,
            ]);

            $new_sku_ledger->save();
        }
    }

    public function invoice_out_sales_invoice_final_summary(Request $request)
    {
        //return $request->input();
        if ($request->input('barcode') != null) {
            $barcode = $request->input('barcode');
            $sku_add = Sku_add::select('id', 'barcode')
                ->where('barcode', $barcode)
                ->first();
            $invoice_details = Sales_invoice_details::where('sales_invoice_id', $request->input('rep_dr'))
                ->where('sku_id', $sku_add->id)
                ->groupBy('sku_id')
                ->first();
        } else if ($request->input('sku_barcode') != null) {
            $barcode = $request->input('sku_barcode');
            $invoice_details = Sales_invoice_details::where('sales_invoice_id', $request->input('rep_dr'))
                ->where('sku_id', $barcode)
                ->groupBy('sku_id')
                ->first();
        }


        if ($invoice_details) {
            Sales_invoice_details::where('sales_invoice_id', $request->input('rep_dr'))
                ->where('sku_id', $invoice_details->sku_id)
                ->update(['remarks' => 'scanned']);


            $cart_checker = \Cart::session(auth()->user()->id)->get($invoice_details->sku_id);
            if ($cart_checker) {
                \Cart::session(auth()->user()->id)->remove($invoice_details->sku_id);

                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_details->sku_id,
                    'name' => $invoice_details->sku->description,
                    'price' => 0,
                    'quantity' => $invoice_details->quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_details,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $invoice_details->sku_id,
                    'name' => $invoice_details->sku->description,
                    'price' => 0,
                    'quantity' => $invoice_details->quantity,
                    'attributes' => array(),
                    'associatedModel' => $invoice_details,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();

            $sales_invoice_details = Sales_invoice_details::where('sales_invoice_id', $request->input('rep_dr'))
                // ->where('remarks', 'scanned')
                // ->orWhere('remarks', null)
                // ->groupBy('sku_id')
                ->get();

            return view('invoice_out_sales_invoice_final_summary', [
                'cart' => $cart,
                'sales_invoice_details' => $sales_invoice_details,
                'invoice_details' => $invoice_details,
                'rep_dr' => $request->input('rep_dr'),
            ]);
        } else {
            return 'invalid';
        }
    }

    public function invoice_out_sales_invoice_saved(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $load_sheet_id = uniqid();

        $cart = Cart::session(auth()->user()->id)->getContent();

        Sales_invoice::where('id', $request->input('rep_dr'))
            ->update(['status' => 'out']);

        foreach ($cart as $key => $cart_data) {
            $sku_id = $cart_data->id;
            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));




            $final_unit_cost = $ledger_results[0]->running_amount / $ledger_results[0]->running_balance;
            $amount = ($cart_data->quantity * -1) * $final_unit_cost;

            $running_balance = $ledger_results[0]->running_balance - $cart_data->quantity;
            $running_amount = $ledger_results[0]->running_amount + $amount;
            $new_sku_ledger = new Sku_ledger([
                'sku_id' => $cart_data->id,
                'quantity' => $cart_data->quantity * -1,
                'running_balance' => $running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'out from warehouse booking',
                'all_id' => $request->input('rep_dr'),
                'principal_id' => $ledger_results[0]->principal_id,
                'sku_type' => $ledger_results[0]->sku_type,
                'amount' => $amount,
                'final_unit_cost' => $final_unit_cost,
                'running_amount' => $running_amount,
            ]);

            $new_sku_ledger->save();

            Sales_invoice_details::where('sales_invoice_id', $request->input('rep_dr'))
                ->where('sku_id', $sku_id)
                ->update(['remarks' => 'out']);
        }
    }
}
