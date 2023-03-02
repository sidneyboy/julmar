<?php

namespace App\Http\Controllers;

use App\User;
use App\Purchase_order;
use App\Purchase_order_details;
use App\Principal_discount;
use App\Principal_discount_details;
use App\Purchase_order_other_discount_details;
use App\Purchase_order_discount_details;
use Illuminate\Http\Request;

class Purchase_order_confirmation_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $purchase_order = Purchase_order::select('id', 'purchase_id')->where('status', null)->orderBy('id', 'desc')->get();
            return view('purchase_order_confirmation', [
                'user' => $user,
                'purchase_order' => $purchase_order,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'purchase_order_confirmation',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function purchase_order_confirmation_proceed(Request $request)
    {
        $purchase_order = Purchase_order::find($request->input('purchase_id'));

        $principal_discount = Principal_discount::where('principal_id', $purchase_order->principal_id)->get();

        return view('purchase_order_confirmation_proceed', [
            'purchase_order' => $purchase_order,
            'principal_discount' => $principal_discount,
        ]);
    }

    public function purchase_order_confirmation_final_summary(Request $request)
    {
        //return $request->input();
        $unit_cost = str_replace(',', '', $request->input('unit_cost'));
        $freight = str_replace(',', '', $request->input('freight'));
        $discount_selected = Principal_discount::find($request->input('discount_id'));
        $check_less_other_discounts = $request->input('less_other_discount_selected');
        if (isset($check_less_other_discounts)) {
            $less_other_discount_selected = Principal_discount_details::select('discount_name', 'discount_rate')->whereIn('id', $request->input('less_other_discount_selected'))->get();

            return view('purchase_order_confirmation_final_summary', [
                'discount_selected' => $discount_selected,
                'less_other_discount_selected' => $less_other_discount_selected,
                'sku_id' => $request->input('sku_id'),
                'quantity_confirmed' => $request->input('quantity_confirmed'),
                'sku_code' => $request->input('sku_code'),
                'description' => $request->input('description'),
                'unit_cost' => $unit_cost,
                'freight' => $freight,
            ])->with('discount_type', $request->input('discount_type'))
                ->with('purchase_order_id', $request->input('purchase_order_id'))
                ->with('delivery_term', $request->input('delivery_term'))
                ->with('payment_term', $request->input('payment_term'))
                ->with('sales_order_number', $request->input('sales_order_number'));
        } else {
            return view('purchase_order_confirmation_final_summary', [
                'discount_selected' => $discount_selected,
                'sku_id' => $request->input('sku_id'),
                'quantity_confirmed' => $request->input('quantity_confirmed'),
                'sku_code' => $request->input('sku_code'),
                'description' => $request->input('description'),
                'unit_cost' => $unit_cost,
                'freight' => $freight,
            ])->with('discount_type', $request->input('discount_type'))
                ->with('purchase_order_id', $request->input('purchase_order_id'))
                ->with('delivery_term', $request->input('delivery_term'))
                ->with('payment_term', $request->input('payment_term'))
                ->with('sales_order_number', $request->input('sales_order_number'));
        }
    }

    public function purchase_order_confirmation_saved(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        Purchase_order::where('id', $request->input('purchase_order_id'))
            ->update([
                'payment_term' => $request->input('payment_term'),
                'delivery_term' => $request->input('delivery_term'),
                'sales_order_number' => $request->input('sales_order_number'),
                'status' => 'confirmed',
                'discount_type' => $request->input('discount_type'),
                'gross_purchase' => $request->input('gross_purchases'),
                'total_less_discount' => $request->input('total_less_discount'),
                'bo_discount' => $request->input('bo_discount'),
                'vatable_purchase' => $request->input('vatable_purchase'),
                'vat' => $request->input('vat'),
                'freight' => $request->input('freight'),
                'total_final_cost' => $request->input('total_final_cost'),
                'total_less_other_discount' => $request->input('total_less_other_discount'),
                'net_payable' => $request->input('net_payable'),
                'bo_allowance_discount_rate' => $request->input('bo_allowance_discount_rate'),
            ]);

        $check_less_other_discount_selected_name = $request->input('less_other_discount_selected_name');

        if (isset($check_less_other_discount_selected_name)) {
            for ($i = 0; $i < count($check_less_other_discount_selected_name); $i++) {
                $new_received_purchase_order_other_discount = new Purchase_order_other_discount_details([
                    'purchase_order_id' => $request->input('purchase_order_id'),
                    'discount_name' => $check_less_other_discount_selected_name[$i],
                    'discount_rate' => $request->input('less_other_discount_selected_rate')[$i],
                ]);

                $new_received_purchase_order_other_discount->save();
            }
        }

        for ($i = 0; $i < count($request->input('discount_selected_name')); $i++) {
            $new_received_purchase_order_discount = new Purchase_order_discount_details([
                'purchase_order_id' => $request->input('purchase_order_id'),
                'discount_name' => $request->input('discount_selected_name')[$i],
                'discount_rate' => $request->input('discount_selected_rate')[$i],
            ]);

            $new_received_purchase_order_discount->save();
        }


        foreach ($request->input('sku_id') as $key => $data) {
            Purchase_order_details::where('purchase_order_id',  $request->input('purchase_order_id'))
                ->where('sku_id', $data)
                ->update([
                    'confirmed_quantity' => $request->input('confirmed_quantity')[$data],
                    'freight' => $request->input('freight_per_sku')[$data],
                    'unit_cost' => $request->input('unit_cost')[$data],
                    'final_unit_cost' => $request->input('final_unit_cost')[$data],
                ]);
        }

        return 'saved';
    }
}
