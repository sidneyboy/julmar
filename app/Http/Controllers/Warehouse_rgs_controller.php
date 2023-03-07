<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice_raw;
use App\Sku_principal;
use App\Sku_ledger;
use App\Return_good_stock;
use App\Return_good_stock_details;
use DB;
use Illuminate\Http\Request;

class Warehouse_rgs_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            if ($user->principal_id == 'all') {
                $invoice_raw = Invoice_raw::select('delivery_receipt')
                    ->where('status', 'completed')
                    ->groupby('delivery_receipt')
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $principal_id = $user->principal_id;
                $principal = Sku_principal::select('principal')->find($principal_id);
                if ($principal) {
                    $invoice_raw = Invoice_raw::select('delivery_receipt')
                        ->where('principal', $principal->principal)
                        ->where('status', 'completed')
                        ->groupby('delivery_receipt')
                        ->orderBy('id', 'desc')
                        ->get();
                } else {
                    $invoice_raw[] = 0;
                }
            }

            return view('warehouse_rgs', [
                'user' => $user,
                'invoice_raw' => $invoice_raw,
                'main_tab' => 'manage_custodian_main_tab',
                'sub_tab' => 'manage_custodian_sub_tab',
                'active_tab' => 'warehouse_rgs',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_rgs_proceed(Request $request)
    {
        $barcode_checker = Invoice_raw::where('barcode', $request->input('barcode'))->first();

        if ($barcode_checker) {
            Invoice_raw::where('id', $barcode_checker->id)
                ->update(['rgs' => 'scanned']);

            $invoice = Invoice_raw::where('delivery_receipt', $request->input('delivery_receipt'))->get();

            return view('warehouse_rgs_proceed', [
                'invoice' => $invoice,
            ]);
        } else {
            return 'No Data Found!';
        }
    }

    public function warehouse_rgs_final_summary(Request $request)
    {
        $invoice = Invoice_raw::whereIn('id', $request->input('id'))->get();
        $principal = Sku_principal::select('id')->where('principal', $invoice[0]->principal)->first();
        return view('warehouse_rgs_final_summary', [
            'invoice' => $invoice,
            'principal' => $principal,
            'id' => $request->input('id'),
            'returned_quantity' => $request->input('returned_quantity'),
        ]);
    }

    public function warehouse_rgs_saved(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        //return $request->input();

        $new_rgs = new Return_good_stock([
            'delivery_receipt' => $request->input('delivery_receipt_main'),
            'user_id' => auth()->user()->id,
            'principal_id' => $request->input('principal_id'),
            'sku_type' => $request->input('sku_type_main'),
        ]);

        $new_rgs->save();

        foreach ($request->input('id') as $key => $data) {
            $new_rgs_details = new Return_good_stock_details([
                'return_good_stock_id' => $new_rgs->id,
                'sku_id' => $request->input('sku_id')[$data],
                'quantity' => $request->input('returned_quantity')[$data],
            ]);

            $new_rgs_details->save();

            // $sku_id = $request->input('sku_id')[$data];
            // $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            // $count_ledger_row = count($ledger_results);

            // if ($count_ledger_row > 0) {
            //     $running_balance = $ledger_results[0]->running_balance - $request->input('returned_quantity')[$data];
            //     $new_sku_ledger = new Sku_ledger([
            //         'sku_id' => $request->input('sku_id')[$data],
            //         'quantity' => $request->input('returned_quantity')[$data],
            //         'running_balance' => $running_balance,
            //         'user_id' => auth()->user()->id,
            //         'transaction_type' => 'releasing',
            //         'all_id' => $request->input('delivery_receipt')[$data],
            //         'principal_id' => $request->input('principal_id'),
            //         'sku_type' => $request->input('sku_type')[$data],
            //     ]);

            //     $new_sku_ledger->save();
            // } else {
            //     $new_sku_ledger = new Sku_ledger([
            //         'sku_id' => $request->input('sku_id')[$data],
            //         'quantity' => $request->input('returned_quantity')[$data],
            //         'running_balance' => $request->input('returned_quantity')[$data],
            //         'user_id' => auth()->user()->id,
            //         'transaction_type' => 'releasing',
            //         'all_id' => $request->input('delivery_receipt')[$data],
            //         'principal_id' => $request->input('principal_id'),
            //         'sku_type' => $request->input('sku_type')[$data],
            //     ]);

            //     $new_sku_ledger->save();
            // }
        }
    }
}
