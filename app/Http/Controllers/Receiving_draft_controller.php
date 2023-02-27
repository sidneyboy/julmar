<?php

namespace App\Http\Controllers;

use App\Receiving_draft;
use App\Receiving_draft_main;
use App\User;
use App\Sku_add;
use App\Purchase_order;
use App\Purchase_order_details;
use Illuminate\Http\Request;

class Receiving_draft_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            date_default_timezone_set('Asia/Manila');
            $date = date('Ymd');
            $time = date('his');
            $session_id = $date . "" . $time;
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $purchase_order = Purchase_order::select('id', 'purchase_id')->where('status', 'confirmed')->orderBy('id', 'desc')->get();
            return view('receiving_draft', [
                'user' => $user,
                'purchase_order' => $purchase_order,
                'session_id' => $session_id,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'receiving_draft',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function receiving_draft_proceed(Request $request)
    {
        //return $request->input('purchase_id');
        $po_sku_type = Purchase_order::select('sku_type')->find($request->input('purchase_id'));
        $sku = Sku_add::select('id')->where('barcode', $request->input('barcode'))->where('sku_type', $po_sku_type->sku_type)->first();

        if ($sku) {
            $check_po_details = Purchase_order_details::select('freight','unit_cost')->where('purchase_order_id', $request->input('purchase_id'))->where('sku_id', $sku->id)->first();
            if ($check_po_details) {
                $check_draft = Receiving_draft::where('sku_id', $sku->id)->where('session_id', $request->input('session_id'))->count();
                if ($check_draft == 0) {
                    $new_draft = new Receiving_draft([
                        'sku_id' => $sku->id,
                        'session_id' => $request->input('session_id'),
                        'user_id' => auth()->user()->id,
                        'unit_cost' => $check_po_details->unit_cost,
                        'freight' => $check_po_details->freight,
                    ]);

                    $new_draft->save();

                    Purchase_order_details::where('sku_id', $sku->id)
                        ->where('purchase_order_id', $request->input('purchase_id'))
                        ->update(['scanned_remarks' => 'scanned']);

                    $receiving_draft = Receiving_draft::select('id', 'sku_id', 'user_id', 'session_id','unit_cost','freight')->where('session_id', $request->input('session_id'))->get();

                    $purchase_order_details = Purchase_order_details::select('purchase_order_id', 'quantity', 'sku_id', 'scanned_remarks', 'receive')->where('purchase_order_id', $request->input('purchase_id'))->get();



                    return view('receiving_draft_proceed', [
                        'receiving_draft' => $receiving_draft,
                        'purchase_order_details' => $purchase_order_details,
                        'check_po_details' => $check_po_details,
                    ])->with('session_id', $request->input('session_id'));
                } else {
                    $receiving_draft = Receiving_draft::select('id', 'sku_id', 'user_id', 'session_id','unit_cost','freight')->where('session_id', $request->input('session_id'))->get();

                    $purchase_order_details = Purchase_order_details::select('purchase_order_id', 'quantity', 'sku_id', 'scanned_remarks', 'receive')->where('purchase_order_id', $request->input('purchase_id'))->get();


                    return view('receiving_draft_proceed', [
                        'receiving_draft' => $receiving_draft,
                        'purchase_order_details' => $purchase_order_details,
                        'check_po_details' => $check_po_details,
                    ])->with('session_id', $request->input('session_id'));
                }
            } else {
                return 'Sku Not in the PO';
            }
        } else {
            return 'Non Existing SKU Barcode';
        }
    }

    public function receiving_draft_final_saved(Request $request)
    {
        //return $request->input();
        $new = new Receiving_draft_main([
            'purchase_order_id' => $request->input('purchase_order_id'),
            'session_id' => $request->input('session_id'),
            'user_id' => auth()->user()->id,
        ]);

        $new->save();

        foreach ($request->input('quantity_received') as $key => $value) {
            Receiving_draft::where('id', $key)
                ->where('session_id', $request->input('session_id'))
                ->update([
                    'quantity' => $request->input('quantity_received')[$key],
                    'remarks' => $request->input('remarks')[$key],
                ]);
        }

        Purchase_order::where('id', $request->input('purchase_order_id'))
            ->update(['status' => 'drafted']);

        return 'saved';
    }
}
