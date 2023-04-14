<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Sku_add;
use App\Sku_principal;
use App\Vs_pcm;
use App\Vs_pcm_details;
use App\Vs_inventory_ledger;
use App\Customer_principal_price;
use DB;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Van_selling_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            Cart::session(auth()->user()->id)->clear();
            $principal = Sku_principal::where('principal', '!=', 'NONE')->get();
            $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_pcm', [
                'user' => $user,
                'customer' => $customer,
                'principal' => $principal,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_pcm',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_pcm_generate_sku_per_principal(Request $request)
    {
        //return $request->input();

        if ($request->input('pcm_type') == 'customer') {
            $van_selling_ledger = Sku_add::where('principal_id', $request->input('principal_id'))
                ->where('sku_type', 'BUTAL')
                ->get();
        } else {
            $van_selling_ledger = Vs_inventory_ledger::where('customer_id', $request->input('customer_id'))
                ->where('principal_id', $request->input('principal_id'))
                ->groupBy('sku_id')
                ->get();
        }

        return view('van_selling_pcm_generate_sku', [
            'van_selling_ledger' => $van_selling_ledger,
        ])->with('pcm_type', $request->input('pcm_type'));
    }

    public function van_selling_pcm_generate_pcm_data(Request $request)
    {
        //return $request->input();
        $explode = explode(',', $request->input('sku'));
        $sku_code = $explode[0];
        $description = $explode[1];
        $sku_id = $explode[2];
        $principal_id = $explode[3];


        $salesman_id = $request->input('salesman');


        $check = Cart::session(auth()->user()->id)->get($sku_code);
        $quantity = $request->input('quantity');



        if ($request->input('pcm_type') != 'customer') {
            $van_selling_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$salesman_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $unit_price = $van_selling_ledger_result[0]->unit_price;
        } else {
            $customer_principal_price = Customer_principal_price::select('id', 'price_level')->where('customer_id', $salesman_id)->where('principal_id', $principal_id)->first();
            $van_selling_ledger_result = Sku_add::find($sku_id);

            if ($customer_principal_price->price_level == 'price_1') {
                $unit_price = $van_selling_ledger_result->sku_price_details_one->price_1;
            } else if ($customer_principal_price->price_level == 'price_2') {
                $unit_price = $van_selling_ledger_result->sku_price_details_one->price_2;
            } else if ($customer_principal_price->price_level == 'price_3') {
                $unit_price = $van_selling_ledger_result->sku_price_details_one->price_3;
            } else if ($customer_principal_price->price_level == 'price_4') {
                $unit_price = $van_selling_ledger_result->sku_price_details_one->price_4;
            } else if ($customer_principal_price->price_level == 'price_5') {
                $unit_price = $van_selling_ledger_result->sku_price_details_one->price_5;
            }
        }

        if ($request->input('pcm_type') == 'customer') {
            if ($check) {
                \Cart::update($sku_id, array(
                    'price' => $unit_price,
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantity,
                    ),
                    'attributes' => array(
                        'remarks' => $request->input('remarks'),
                        'sku_code' => $sku_code,
                    ),
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku_id,
                    'name' => $description,
                    'quantity' => $quantity,
                    'price' => $unit_price,
                    'attributes' => array(
                        'remarks' => $request->input('remarks'),
                        'sku_code' => $sku_code,
                    ),
                ));
            }
        } else {
            if ($check) {
                \Cart::update($sku_id, array(
                    'price' => $unit_price,
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantity,
                    ),
                    'attributes' => array(
                        'remarks' => $request->input('remarks'),
                        'sku_code' => $sku_code,
                    ),
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku_id,
                    'name' => $description,
                    'quantity' => $quantity,
                    'price' => $unit_price,
                    'attributes' => array(
                        'remarks' => $request->input('remarks'),
                        'sku_code' => $sku_code,
                    ),
                ));
            }
        }

        $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();
        return view('van_selling_pcm_generate_pcm_data', [
            'van_selling_pcm_data' => $van_selling_pcm_data,
            'customer_id' => $salesman_id,
            'principal_id' => $principal_id,
        ])->with('salesman_id', $salesman_id)
            ->with('pcm_type', $request->input('pcm_type'));
    }


    public function van_selling_pcm_generate_final_summary(Request $request)
    {
        //return $request->input();
        $check_pcm_number = Vs_pcm::select('id')->where('reference', $request->input('pcm_number'))->first();


        if ($check_pcm_number) {
            return 'existing_pcm_number';
        } else {
            $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();
            return view('van_selling_pcm_generate_final_summary_page', [
                'van_selling_pcm_data' => $van_selling_pcm_data,
            ])->with('store_name', $request->input('store_name'))
                ->with('customer_id', $request->input('customer_id'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('price', $request->input('price'))
                ->with('remitted_by', $request->input('remitted_by'))
                ->with('pcm_number', $request->input('pcm_number'))
                ->with('pcm_type', $request->input('pcm_type'));
        }
    }

    public function van_selling_pcm_save(Request $request)
    {

        //return $request->input();

        $new = new Vs_pcm([
            'user_id' => auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'principal_id' => $request->input('principal_id'),
            'total_amount' => $request->input('amount'),
            'reference' => $request->input('pcm_number'),
            'pcm_type' => $request->input('pcm_type'),
            'store_name' => $request->input('store_name'),
            'remitted_by' => $request->input('remitted_by'),
        ]);

        $new->save();

        $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();

        foreach ($van_selling_pcm_data as $key => $data) {
            $details = new Vs_pcm_details([
                'vs_pcm_id' => $new->id,
                'sku_id' => $data->id,
                'quantity' => $data->quantity,
                'unit_price' => $data->price,
                'remarks' => $data->attributes->remarks,
            ]);

            $details->save();
        }
    }
}
