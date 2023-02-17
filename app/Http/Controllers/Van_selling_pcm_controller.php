<?php

namespace App\Http\Controllers;

use App\Customer;
use App\User;
use App\Van_selling_pcm;
use App\Van_selling_pcm_details;
use App\Sku_add;
use App\Sku_principal;
use App\Van_selling_upload_ledger;
use App\Customer_principal_price;
use DB;
use Cart;

use Illuminate\Http\Request;

class Van_selling_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_pcm_generate_sku_per_principal(Request $request)
    {
        //return $request->input();
        $explode = explode('-', $request->input('salesman_data'));
        $salesman_id = $explode[0];
        $salesman_name = $explode[1];

        $explode_principal = explode('-', $request->input('principal'));
        $principal_name = $explode_principal[0];
        $principal_id = $explode_principal[1];

        if ($request->input('pcm_type') == 'customer') {
            $van_selling_ledger = Sku_add::where('principal_id', $principal_id)
                ->where('sku_type', 'BUTAL')
                ->get();
        } else {
            $van_selling_ledger = DB::table('Van_selling_upload_ledgers')
                ->select('id', 'principal', 'sku_code', 'unit_of_measurement', 'description', 'beg', 'butal_equivalent', 'reference', 'customer_id', 'sku_type')
                ->where('customer_id', $salesman_id)
                ->where('principal', $principal_name)
                ->groupBy('sku_code')
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
        $principal = $explode[3];
        $principal_id = $explode[4];

        $explode_sales = explode('-', $request->input('salesman'));
        $salesman_id = $explode_sales[0];
        $salesman_name = $explode_sales[1];


        $check = Cart::session(auth()->user()->id)->get($sku_code);
        $quantity = $request->input('quantity');



        if ($request->input('pcm_type') != 'customer') {
            $van_selling_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$salesman_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
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
                \Cart::update($sku_code, array(
                    'price' => $unit_price,
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantity,
                    ),
                    'attributes' => array(
                        'principal' => $principal,
                        'remarks' => $request->input('remarks'),
                    ),
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku_code,
                    'name' => $description,
                    'quantity' => $quantity,
                    'price' => $unit_price,
                    'attributes' => array(
                        'principal' => $principal,
                        'remarks' => $request->input('remarks'),
                    ),
                ));
            }
        } else {
            if ($check) {
                \Cart::update($sku_code, array(
                    'price' => $unit_price,
                    'quantity' => array(
                        'relative' => false,
                        'value' => $quantity,
                    ),
                    'attributes' => array(
                        'principal' => $principal,
                        'remarks' => $request->input('remarks'),
                    ),
                ));
            } else {
                \Cart::session(auth()->user()->id)->add(array(
                    'id' => $sku_code,
                    'name' => $description,
                    'quantity' => $quantity,
                    'price' => $unit_price,
                    'attributes' => array(
                        'principal' => $principal,
                        'remarks' => $request->input('remarks'),
                    ),
                ));
            }
        }

        $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();
        $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();

        return view('van_selling_pcm_generate_pcm_data', [
            'van_selling_pcm_data' => $van_selling_pcm_data,
            'customer' => $customer,
        ])->with('salesman_id', $salesman_id)
            ->with('pcm_type', $request->input('pcm_type'))
            ->with('salesman_name', $salesman_name);
    }


    public function van_selling_pcm_generate_final_summary(Request $request)
    {
        //return $request->input();
        $check_pcm_number = Van_selling_pcm::select('id')->where('pcm_number', $request->input('pcm_number'))->first();


        if ($check_pcm_number) {
            return 'existing_pcm_number';
        } else {
            $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();
            return view('van_selling_pcm_generate_final_summary_page', [
                'van_selling_pcm_data' => $van_selling_pcm_data,
            ])->with('store_name', $request->input('store_name'))
                ->with('agent_id', $request->input('agent_id'))
                ->with('agent_name', $request->input('agent_name'))
                ->with('price', $request->input('price'))
                ->with('remitted_by', $request->input('remitted_by'))
                ->with('pcm_number', $request->input('pcm_number'))
                ->with('pcm_type', $request->input('pcm_type'));
        }
    }

    public function van_selling_pcm_save(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $van_selling_pcm_data = \Cart::session(auth()->user()->id)->getContent();
        $van_selling_pcm_save = new Van_selling_pcm([
            'pcm_number' => $request->input('pcm_number'),
            'customer_id' => $request->input('agent_id'),
            'remitted_by' => $request->input('remitted_by'),
            'store_name' => $request->input('store_name'),
            'user_id' => auth()->user()->id,
            'date' => $date,
            'remarks' => 'to_be_posted',
            'pcm_type' => $request->input('pcm_type'),
            'amount' => $request->input('amount'),
            'created_at' => $date,
        ]);

        $van_selling_pcm_save->save();
        $van_selling_pcm_save_last_id = $van_selling_pcm_save->id;

        if ($request->input('pcm_type') != 'customer') {
            foreach ($van_selling_pcm_data as $key => $data) {
                $van_selling_pcm_details_save = new Van_selling_pcm_details([
                    'van_selling_pcm_id' => $van_selling_pcm_save_last_id,
                    'sku_code' => $data->id,
                    'principal' => $data->attributes->principal,
                    'description' => $data->name,
                    'quantity' => $data->quantity,
                    'unit_price' => $request->input('price')[$data->id],
                    'remarks' => $data->attributes->remarks,
                    'created_at' => $date,
                ]);

                $van_selling_pcm_details_save->save();
            }
        } else {
            foreach ($van_selling_pcm_data as $key => $data) {
                $van_selling_pcm_details_save = new Van_selling_pcm_details([
                    'van_selling_pcm_id' => $van_selling_pcm_save_last_id,
                    'sku_code' => $data->id,
                    'principal' => $data->attributes->principal,
                    'description' => $data->name,
                    'quantity' => $data->quantity,
                    'unit_price' => $request->input('price')[$data->id],
                    'remarks' => $data->attributes->remarks,
                    'created_at' => $date,
                ]);

                $van_selling_pcm_details_save->save();
            }
        }

        return 'saved';
    }
}
