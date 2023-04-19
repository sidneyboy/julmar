<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Sku_add;
use App\Sku_principal;
use App\Sku_price_details;
use App\Van_selling_printed;
use Cart;
use App\Location;
use App\Van_selling_ar_ledger;
use App\Vs_withdrawal;
use App\Vs_withdrawal_details;
use App\Customer_principal_price;
use App\Customer_principal_code;
use App\Vs_inventory_ledger;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Van_selling_widthdrawal_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $location = Location::select('id', 'location')->get();
            return view('van_selling_withdrawal', [
                'user' => $user,
                'principal' => $principal,
                'location' => $location,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_withdrawal',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_generate_sku(Request $request)
    {
        // return $request->input();
        if (is_null($request->input('location_id')) or is_null($request->input('sku_type'))) {
            return 'no_location';
        } else {
            $customer = Customer::select('id', 'store_name')->where('kind_of_business', 'VAN SELLING')->where('location_id', $request->input('location_id'))->get();
            $sku = Sku_add::select('id', 'sku_code', 'description')->where('principal_id', $request->input('principal'))->where('sku_type', $request->input('sku_type'))->get();
            return view('van_selling_generate_sku', [
                'sku' => $sku,
            ])->with('customer', $customer)
                ->with('price_level', $request->input('price_level'));
        }
    }

    public function van_selling_generate_sku_quantity(Request $request)
    {
        //return $request->input();
        $sku = Sku_add::find($request->input('sku'));
        $customer = Customer_principal_price::select('price_level')->where('customer_id', $request->input('customer'))
            ->where('principal_id', $request->input('principal'))
            ->first();
        $sku_price_details = Sku_price_details::select($customer->price_level)->where('sku_id', $request->input('sku'))
            ->first();

        if ($sku_price_details) {
            if ($customer->price_level == 'price_1') {
                $unit_price = $sku_price_details->price_1;
            } else if ($customer->price_level == 'price_2') {
                $unit_price = $sku_price_details->price_2;
            } else if ($customer->price_level == 'price_3') {
                $unit_price = $sku_price_details->price_3;
            } else if ($customer->price_level == 'price_4') {
                $unit_price = $sku_price_details->price_4;
            } else if ($customer->price_level == 'price_5') {
                $unit_price = $sku_price_details->price_5;
            }
        }else{
            if ($customer->price_level == 'price_1') {
                $unit_price = 0;
            } else if ($customer->price_level == 'price_2') {
                $unit_price = 0;
            } else if ($customer->price_level == 'price_3') {
                $unit_price = 0;
            } else if ($customer->price_level == 'price_4') {
                $unit_price = 0;
            } else if ($customer->price_level == 'price_5') {
                $unit_price = 0;
            }
        }

        if ($sku) {
            $cart_checker = \Cart::session(auth()->user()->id)->get($sku->id);
            if ($cart_checker) {
                \Cart::session(auth()->user()->id)->remove($sku->id);

                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku->id,
                    'name' => $sku->description,
                    'price' => $unit_price,
                    'quantity' => $request->input('quantity'),
                    'attributes' => array(),
                    'associatedModel' => $sku,
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku->id,
                    'name' => $sku->description,
                    'price' => $unit_price,
                    'quantity' => $request->input('quantity'),
                    'attributes' => array(),
                    'associatedModel' => $sku,
                ));
            }

            $cart = Cart::session(auth()->user()->id)->getContent();

            return view('van_selling_generate_sku_quantity', [
                'cart' => $cart,
                'customer_id' => $request->input('customer'),
                'principal_id' => $request->input('principal'),
            ]);
        } else {
            return 'invalid';
        }
    }

    public function van_selling_generate_final_summary(Request $request)
    {
        foreach ($request->input('quantity') as $key => $data) {
            if ($request->input('quantity')[$key] > $request->input('running_balance')[$key]) {
                return 'quantity_is_greater';
            }
        }

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');


        $delivery_receipt = strtoupper($request->input('delivery_receipt'));
        $dr_filter = Vs_withdrawal::select('delivery_receipt')->where('delivery_receipt', $delivery_receipt)->first();

        if ($dr_filter) {
            return 'existing';
        } else {
            $cart_update = Cart::session(auth()->user()->id)->getContent();

            foreach ($cart_update as $key => $data) {
                \Cart::session(auth()->user()->id)->update($data->id, [
                    'price' => $request->input('unit_price')[$data->id],
                ]);
            }

            $cart = Cart::session(auth()->user()->id)->getContent();
            $customer = Customer::select('store_name')->find($request->input('customer_id'));
            return view('van_selling_generate_final_summary', [
                'cart' => $cart,
                'customer' => $customer,
            ])->with('delivery_receipt', $delivery_receipt)
                ->with('principal_id', $request->input('principal_id'))
                ->with('customer_id', $request->input('customer_id'));
        }
    }

    public function van_selling_save(Request $request)
    {
        //return $request->input();
        $customer_id = $request->input('customer_id');
        $new_withdrawal_saved = new Vs_withdrawal([
            'user_id' => auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal_id'),
            'delivery_receipt' => $request->input('delivery_receipt'),
            'total_amount' => $request->input('total_amount'),
        ]);

        $new_withdrawal_saved->save();

        $cart = Cart::session(auth()->user()->id)->getContent();

        foreach ($cart as $key => $data) {
            $new_details = new Vs_withdrawal_details([
                'vs_withdrawal_id' => $new_withdrawal_saved->id,
                'sku_id' => $data->id,
                'quantity' => $data->quantity,
                'unit_price' => $data->price,
                'sku_type' => $data->associatedModel->sku_type,
                'sku_code' => $data->associatedModel->sku_code,
            ]);

            $new_details->save();

            $sku_id = $data->id;
            $ledger_results =  DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_id = '$sku_id' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);


            if ($count_ledger_row > 0) {
                $new_inventory_ledger = new Vs_inventory_ledger([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $request->input('customer_id'),
                    'principal_id' => $request->input('principal_id'),
                    'transaction' => 'withdrawal',
                    'sku_id' => $data->id,
                    'beginning_inventory' => $ledger_results[0]->ending_inventory,
                    'quantity' => $data->quantity,
                    'ending_inventory' => $ledger_results[0]->ending_inventory + $data->quantity,
                    'unit_price' => $data->price,
                    'all_id' => $new_withdrawal_saved->id,
                    'sku_code' => $data->associatedModel->sku_code,
                ]);
                $new_inventory_ledger->save();
            } else {
                $new_inventory_ledger = new Vs_inventory_ledger([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $request->input('customer_id'),
                    'principal_id' => $request->input('principal_id'),
                    'transaction' => 'withdrawal',
                    'sku_id' => $data->id,
                    'beginning_inventory' => 0,
                    'quantity' => $data->quantity,
                    'ending_inventory' => $data->quantity,
                    'unit_price' => $data->price,
                    'all_id' => $new_withdrawal_saved->id,
                    'sku_code' => $data->associatedModel->sku_code,
                ]);
                $new_inventory_ledger->save();
            }
        }


        $ar_checker = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->orderBy('id', 'desc')->limit(1)->first();

        if ($ar_checker) {
            $running_balance = $ar_checker->outstanding_balance;
            $outstanding_balance = $running_balance + $request->input('total_customer_payable_amount');
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'transaction' => 'withdrawal',
                'all_id' => $new_withdrawal_saved->id,
                'running_balance' => $running_balance,
                'amount' => $request->input('total_amount'),
                'short' => 0,
                'outstanding_balance' => $outstanding_balance + $request->input('total_amount'),
                'remarks' => 'n/a',
            ]);

            $van_selling_ledger_save->save();
        } else {
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'transaction' => 'withdrawal',
                'all_id' => $new_withdrawal_saved->id,
                'running_balance' => 0,
                'amount' => $request->input('total_amount'),
                'short' => 0,
                'outstanding_balance' => $request->input('total_amount'),
                'remarks' => 'n/a',
            ]);

            $van_selling_ledger_save->save();
        }
    }
}
