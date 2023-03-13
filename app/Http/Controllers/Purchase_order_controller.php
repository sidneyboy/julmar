<?php

namespace App\Http\Controllers;

use App\Sku_add;
use App\Sku_principal;
use Cart;
use App\Purchase_order;
use App\Purchase_order_details;
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
        //return $request->input();
        $sku_principal = Sku_add::select('id', 'description', 'sku_code', 'sku_type')
            ->where('sku_type', $request->input('sku_type'))
            ->where('principal_id', $request->input('principal_id'))->get();

        return view('purchase_order_show_inputs', [
            'sku_principal' => $sku_principal,
        ])->with('principal_id', $request->input('principal_id'))
            ->with('sku_type', $request->input('sku_type'));
    }


    public function purchase_order_cart(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $year = date('Y');
        $month = date('m');

        $description = Sku_add::select('description', 'id', 'sku_code', 'sku_type')->where('id', $request->input('sku'))->first();

        Cart::session(auth()->user()->id)->add([
            'id' => $description->id,
            'name' => $description->description,
            'quantity' => $request->input('quantity'),
            'price' => 0,
            'attributes' => array($description->sku_code, $description->sku_type),
        ]);

        $purchase_order_id = Purchase_order::select('purchase_id')->where('principal_id', $request->input('principal_id'))->orderBy('id', 'desc')->first();
        $principal_name = Sku_principal::select('principal')->find($request->input('principal_id'));
        if ($purchase_order_id) {
            $variableExplode = explode('-', $purchase_order_id->purchase_id);
            $series = $variableExplode[3];
            $code =  $series + 1;
            $po_id = $principal_name->principal . "-" . $month . "-" . $year . "-" . $code;

            return view('purchase_order_show_data', [
                'sku' => Cart::session(auth()->user()->id)->getContent(),
            ])->with('principal_id', $request->input('principal_id'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('po_id', $po_id)
                ->with('purchase_order_id', $purchase_order_id)
                ->with('principal_name', $principal_name->principal);
        } else {
            $po_id = $principal_name->principal . "-" . $month . "-" . $year . "-" . 1;

            return view('purchase_order_show_data', [
                'sku' => Cart::session(auth()->user()->id)->getContent(),
            ])->with('principal_id', $request->input('principal_id'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('po_id', $po_id)
                ->with('purchase_order_id', $purchase_order_id)
                ->with('principal_name', $principal_name->principal);
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
            ->with('particulars', $request->input('particulars'))
            ->with('sales_order_number', $request->input('sales_order_number'));
    }


    public function purchase_order_save(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $cart_data = Cart::session(auth()->user()->id)->getContent();

        $purchase_order = new Purchase_order([
            'purchase_id' => $request->input('purchase_id'),
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'sku_type' => $request->input('sku_type'),
        ]);

        $purchase_order->save();

        foreach ($cart_data as $key => $data) {
            $purchase_details = new Purchase_order_details([
                'purchase_order_id' => $purchase_order->id,
                'sku_id' => $data->id,
                'quantity' => $data->quantity,
            ]);

            $purchase_details->save();
        }

        Cart::session(auth()->user()->id)->clear();


        return 'saved';
    }
}
