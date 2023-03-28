<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice_draft;
use App\Invoice_draft_details;
use App\Sku_add;
use App\Sku_ledger;
use DB;
use Illuminate\Http\Request;

class Invoice_out_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $invoice_draft = Invoice_draft::select('id', 'delivery_receipt')->where('status', null)->orderBy('id','desc')->get();
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
        $invoice_draft = Invoice_draft::find($request->input('invoice_id'));

        $sku = Sku_add::select('id')->where('barcode', $request->input('barcode'))->where('sku_type', $invoice_draft->sku_type)->first();

        if ($sku) {
            Invoice_draft_details::where('sku_id', $sku->id)
                ->where('invoice_draft_id', $request->input('invoice_id'))
                ->update(['scanned_remarks' => 'scanned']);

            $invoice_draft_details = Invoice_draft_details::where('invoice_draft_id', $request->input('invoice_id'))->get();

            return view('invoice_out_proceed', [
                'invoice_draft_details' => $invoice_draft_details,
            ])->with('invoice_id', $request->input('invoice_id'));
        } else {
            return 'Non Existing SKU Barcode';
        }
    }

    public function invoice_out_final_summary(Request $request)
    {
        $invoice_draft_details = Invoice_draft_details::where('invoice_draft_id', $request->input('invoice_draft_id'))->whereIn('sku_id', $request->input('sku_id'))->get();

        $invoice_draft = Invoice_draft::find($request->input('invoice_draft_id'));

        return view('invoice_out_final_summary', [
            'invoice_draft_details' => $invoice_draft_details,
            'invoice_draft' => $invoice_draft,
            'final_quantity' => $request->input('final_quantity'),
        ])->with('invoice_draft_id', $request->input('invoice_draft_id'));
    }

    public function invoice_out_saved(Request $request)
    {
        //return $request->input();

        Invoice_draft::where('id', $request->input('invoice_draft_id'))
            ->update([
                'total_amount' => $request->input('total_amount'),
                'scanned_by' => auth()->user()->id,
                'status' => 'scanned',
            ]);

        foreach ($request->input('sku_id') as $key => $data) {
            Invoice_draft_details::where('id', $request->input('invoice_draft_id'))
                ->where('sku_id', $data)
                ->update(['quantity_out' => $request->input('quantity')[$data]]);


            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {
                $running_balance = $ledger_results[0]->running_balance - $request->input('quantity')[$data];
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('quantity')[$data],
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'out from warehouse',
                    'all_id' => $request->input('invoice_draft_id'),
                    'principal_id' => $request->input('principal_id'),
                ]);

                $new_sku_ledger->save();
            } else {
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('quantity')[$data],
                    'running_balance' => $request->input('quantity')[$data],
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'out from warehouse',
                    'all_id' => $request->input('invoice_draft_id'),
                    'principal_id' => $request->input('principal_id'),
                ]);

                $new_sku_ledger->save();
            }
        }

        return 'saved';
    }
}
