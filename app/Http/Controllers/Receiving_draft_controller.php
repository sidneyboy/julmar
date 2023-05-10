<?php

namespace App\Http\Controllers;

use App\Receiving_draft;
use App\Receiving_draft_main;
use App\User;
use App\Sku_add;
use App\Purchase_order;
use App\Purchase_order_details;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Receiving_draft_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            date_default_timezone_set('Asia/Manila');
            $date = date('Ymd');
            $time = date('his');
            $session_id = $date . "" . $time;
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            if ($user->position == 'admin') {
                $purchase_order = Purchase_order::select('id', 'purchase_id', 'van_number')
                    ->where('status', 'confirmed')
                    ->orWhere('status', 'paid')
                    ->orWhere('status', 'staggered')
                    ->orderBy('id', 'desc')
                    ->get();
            } else {
                $purchase_order = Purchase_order::select('id', 'purchase_id', 'van_number')
                    ->where('principal_id', $user->principal_id)
                    ->where('status', 'confirmed')
                    ->orWhere('status', 'paid')
                    ->orWhere('status', 'staggered')
                    ->orderBy('id', 'desc')
                    ->get();
            }

            //return $purchase_order;


            return view('receiving_draft', [
                'user' => $user,
                'purchase_order' => $purchase_order,
                'session_id' => $session_id,
                'main_tab' => 'manage_warehouse_main_tab',
                'sub_tab' => 'manage_warehouse_sub_tab',
                'active_tab' => 'receiving_draft',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function receiving_draft_sku_selection(Request $request)
    {
        //return $request->input();
        $purchase_order_details = Purchase_order_details::select('sku_id', 'purchase_order_id')
            ->where('purchase_order_id', $request->input('purchase_id'))
            ->where('confirmed_quantity', '!=', 0)
            ->get();

        return view('receiving_draft_sku_selection', [
            'purchase_order_details' => $purchase_order_details,
        ])->with('purchase_order_id', $request->input('purchase_id'));
    }

    public function receiving_draft_proceed(Request $request)
    {
        //return $request->input();
        if ($request->input('barcode') != null) {
            $barcode = $request->input('barcode');
            $po_sku_type = Purchase_order::select('sku_type')->find($request->input('purchase_order_id'));
            $sku = Sku_add::select('id', 'sku_type')->where('barcode', $barcode)->where('sku_type', $po_sku_type->sku_type)->first();
            $quantity = $request->input('quantity');
        } else if ($request->input('sku_barcode') != null) {
            $barcode = $request->input('sku_barcode');
            $po_sku_type = Purchase_order::select('sku_type')->find($request->input('purchase_order_id'));
            $sku = Sku_add::select('id', 'sku_type')->where('id', $barcode)->where('sku_type', $po_sku_type->sku_type)->first();
            $quantity = $request->input('sku_quantity');
        }



        if ($sku) {
            $check_po_details = Purchase_order_details::select('freight', 'unit_cost')
                ->where('purchase_order_id', $request->input('purchase_order_id'))
                ->where('sku_id', $sku->id)
                ->first();

            if ($check_po_details) {
                $check_draft = Receiving_draft::where('sku_id', $sku->id)->where('session_id', $request->input('session_id'))->count();
                if ($check_draft == 0) {
                    $new_draft = new Receiving_draft([
                        'sku_id' => $sku->id,
                        'session_id' => $request->input('session_id'),
                        'user_id' => auth()->user()->id,
                        'unit_cost' => $check_po_details->unit_cost,
                        'freight' => $check_po_details->freight,
                        'quantity' => $quantity,
                    ]);

                    $new_draft->save();

                    Purchase_order_details::where('sku_id', $sku->id)
                        ->where('purchase_order_id', $request->input('purchase_order_id'))
                        ->update(['scanned_remarks' => 'scanned']);

                    $receiving_draft = Receiving_draft::select('id', 'sku_id', 'user_id', 'session_id', 'unit_cost', 'freight', 'quantity')->where('session_id', $request->input('session_id'))->get();

                    $purchase_order_details = Purchase_order_details::select('purchase_order_id', 'quantity', 'sku_id', 'scanned_remarks', 'receive', 'confirmed_quantity')
                        ->where('purchase_order_id', $request->input('purchase_order_id'))
                        ->where('remarks', 'staggered')
                        ->orWhere('remarks', null)
                        ->get();

                    if ($purchase_order_details) {
                        return view('receiving_draft_proceed', [
                            'receiving_draft' => $receiving_draft,
                            'purchase_order_details' => $purchase_order_details,
                            'check_po_details' => $check_po_details,
                        ])->with('session_id', $request->input('session_id'));
                    } else {
                        return 'sku_received';
                    }
                } else {
                    Receiving_draft::where('session_id', $request->input('session_id'))
                        ->where('sku_id', $sku->id)
                        ->update(['quantity' => $quantity]);

                    $receiving_draft = Receiving_draft::select('id', 'sku_id', 'user_id', 'session_id', 'unit_cost', 'freight', 'quantity')->where('session_id', $request->input('session_id'))->get();

                    $purchase_order_details = Purchase_order_details::select('purchase_order_id', 'quantity', 'sku_id', 'scanned_remarks', 'receive', 'confirmed_quantity')
                        ->where('purchase_order_id', $request->input('purchase_order_id'))
                        ->where('remarks', 'staggered')
                        ->orWhere('remarks', null)
                        ->get();

                    if (count($purchase_order_details) != 0) {
                        return view('receiving_draft_proceed', [
                            'receiving_draft' => $receiving_draft,
                            'purchase_order_details' => $purchase_order_details,
                            'check_po_details' => $check_po_details,
                        ])->with('session_id', $request->input('session_id'));
                    } else {
                        return 'sku_received';
                    }
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
