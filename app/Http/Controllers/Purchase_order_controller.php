<?php

namespace App\Http\Controllers;


use App\Sku_add;
use App\Sku_principal;
use Session;
use Cart;
use App\Purchase_order;
use App\Purchase_order_details;
use App\Principal_discount;
use App\User;
use Illuminate\Http\Request;

class Purchase_order_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'contact_number', 'principal')->where('principal', '!=', 'none')->get();

            Cart::session(auth()->user()->id)->clear();
            return view('purchase_order', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'purchase_order',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function purchase_order_show_input(Request $request)
    {
        $user_id = auth()->user()->id;
        $select_principal = Sku_principal::select('id', 'principal')->where('id', $request->input('principal_id'))->first();

        $principal_discount = Principal_discount::where('principal_id', $select_principal->id)->get();

        if ($select_principal->principal == 'EPI') {
            $sku_principal = Sku_add::select('id', 'description', 'sku_code', 'sku_type')
                ->where('sku_type', 'Butal')
                ->where('principal_id', $request->input('principal_id'))->get();
        } else {
            $sku_principal = Sku_add::select('id', 'description', 'sku_code', 'sku_type')
                ->where('sku_type', 'Case')
                ->where('principal_id', $request->input('principal_id'))->get();
        }

        return view('purchase_order_show_inputs', [
            'sku_principal' => $sku_principal,
            'principal_discount' => $principal_discount,
        ])->with('principal_id', $request->input('principal_id'));
    }


    public function purchase_order_cart(Request $request)
    {


        $principal_discount = Principal_discount::find($request->input('discount'));


        if ($request->input('sku') == NULL) {
            return '<center><h3 style="font-weight:bold;color:red;">SKU AND QUANTITY FIELD NEEDED!!!</h3></center>';
        } elseif ($request->input('quantity') == NULL) {
            return '<center><h3 style="font-weight:bold;color:red;">SKU AND QUANTITY FIELD NEEDED!!!</h3></center>';
        } elseif ($request->input('quantity') == 0) {
            return '<center><h3 style="font-weight:bold;color:red;">QUANTITY FIELD CANNOT BE 0!!!</h3></center>';
        } else {
            date_default_timezone_set('Asia/Manila');
            $year = date('Y');
            $month = date('m');
            $description = Sku_add::select('description', 'id', 'sku_code', 'sku_type')->where('id', $request->input('sku'))->first();
            $user_id = auth()->user()->id;

            Cart::session($user_id)->add([
                'id' => $description->id,
                'name' => $description->description,
                'quantity' => $request->input('quantity'),
                'price' => $description->sku_price_details_one->unit_cost,
                'attributes' => array($description->sku_code, $description->sku_type),
            ]);

            $principal_explode = explode('-', $request->input('principal_id'));
            $principal_id = $principal_explode[0];
            $principal_name = $principal_explode[1];

            $purchase_order_id = Purchase_order::where('principal_id', $principal_id)->orderBy('id', 'desc')->first();
            $cart_total_quantity = Cart::getTotalQuantity();

            if ($purchase_order_id) {
                $variableExplode = explode('-', $purchase_order_id->purchase_id);
                $series = $variableExplode[2];
                $code =  $series + 1;
                $po_id = $principal_name . "-" . $month . "-" . $code . "-" . $year;

                return view('purchase_order_show_data', [
                    'sku' => Cart::session($user_id)->getContent()
                ])->with('principal_id', $request->input('principal_id'))
                    ->with('payment_term', $request->input('payment_term'))
                    ->with('delivery_term', $request->input('delivery_term'))
                    ->with('po_id', $po_id)
                    ->with('cart_total_quantity', $cart_total_quantity)
                    ->with('particulars', $request->input('particulars'))
                    ->with('sales_order_number', $request->input('sales_order_number'))
                    ->with('discount', $principal_discount);
            } else {
                $po_id = $principal_name . "-" . $month . "-" . 1 . "-" . $year;
                return view('purchase_order_show_data', [
                    'sku' => Cart::session($user_id)->getContent()
                ])->with('principal_id', $request->input('principal_id'))
                    ->with('payment_term', $request->input('payment_term'))
                    ->with('delivery_term', $request->input('delivery_term'))
                    ->with('po_id', $po_id)
                    ->with('cart_total_quantity', $cart_total_quantity)
                    ->with('particulars', $request->input('particulars'))
                    ->with('sales_order_number', $request->input('sales_order_number'))
                    ->with('discount', $principal_discount);
            }
        }
    }

    public function purchase_order_remove_cart(Request $request)
    {



        // $variable_explode = explode('=', $request->input('selected_sku'));
        // $selected_sku_id_to_remove = $variable_explode[1];
        $quantity = $request->input('quantity');
        $user_id = auth()->user()->id;

        //return $request->input();

        $variable_explode_first = explode('=', $request->input('dataString'));
        $principal_data = $variable_explode_first[1];
        $variable_explode_second = explode('-', $principal_data);
        $principal_id = $variable_explode_second[0];


        foreach ($request->input('sku_id') as $key => $value) {
            Cart::session($user_id)->update($value, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity[$value]
                ),
            ));
        }

        Cart::session($user_id)->remove($request->input('cart_id'));
        $cart_total_quantity = Cart::getTotalQuantity();

        return view('purchase_order_show_data', [
            'sku' => Cart::session($user_id)->getContent()
        ])->with('principal_id', $principal_id)
            ->with('payment_term', $request->input('payment_term'))
            ->with('delivery_term', $request->input('delivery_term'))
            ->with('po_id', $request->input('po_id'))
            ->with('cart_total_quantity', $cart_total_quantity)
            ->with('particulars', $request->input('particulars'));
    }


    public function purchase_order_save(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $user_id = auth()->user()->id;
        $cart_data = Cart::session($user_id)->getContent();

        $principal_explode = explode('-', $request->input('principal_id'));
        $principal_id = $principal_explode[0];
        $principal_name = $principal_explode[1];
        $quantity = $request->input('quantity');
        $unit_cost = $request->input('unit_cost');
        $purchase_order = new Purchase_order([
            'purchase_id' => $request->input('po_id'),
            'principal_id' => $principal_id,
            'sales_order_number' => $request->input('sales_order_number'),
            'user_id' => auth()->user()->id,
            'email' => '',
            'payment_term' => $request->input('payment_term'),
            'delivery_term' => $request->input('delivery_term'),
            'particulars' => $request->input('particulars'),
            'po_confirmation_image' => '',
            'remarks' => '',
            'date' => $date
        ]);

        $purchase_order->save();
        $purchase_order_last_id = $purchase_order->id;


        foreach ($request->input('sku_id') as $key => $value) {
            $purchase_order_details_save = new Purchase_order_details();
            $purchase_order_details_save->purchase_order_id = $purchase_order_last_id;
            $purchase_order_details_save->sku_id = $value;
            $purchase_order_details_save->quantity = $quantity[$value];
            $purchase_order_details_save->receive = 0;
            $purchase_order_details_save->unit_cost = $request->input('final_unit_cost')[$value];
            $purchase_order_details_save->discount_rate = $request->input('discount_rate')[$value];
            $purchase_order_details_save->remarks = '';
            $purchase_order_details_save->save();
        }

        Session::flash('success');
        Cart::session(auth()->user()->id)->clear();

        return 'Saved';
    }
}
