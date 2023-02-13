<?php

namespace App\Http\Controllers;
use App\User;
use App\Location;
use App\Sku_principal;
use App\Customer;
use App\Customer_principal_code;
use App\Customer_principal_price;
use Illuminate\Http\Request;

class Customer_principal_code_price_level_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::get();
            return view('customer_principal_code_price_level', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer_principal_code_price_level',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_principal_code_price_level_proceed(Request $request)
    {
        $request->input();
        $variable_explode = explode(',', $request->input('customer'));
        $customer_id = $variable_explode[0];
        $store_name = $variable_explode[1];

        $customer_principal_code = Customer_principal_code::select('store_code', 'principal_id')->where('customer_id', $customer_id)->get();

        if (count($customer_principal_code) != 0) {
            foreach ($customer_principal_code as $key => $data) {
                $principal_code_id[] = $data->principal_id;
            }
            $principal = Sku_principal::where('principal', '!=', 'none')->whereNotIn('id', $principal_code_id)->get();
        } else {
            $principal = Sku_principal::where('principal', '!=', 'none')->get();
        }

        return view('customer_principal_code_price_level_proceed')->with('customer_id', $customer_id)
            ->with('store_name', $store_name)
            ->with('principal', $principal);
    }

    public function customer_principal_code_price_level_saved(Request $request)
    {
        //return $request->input();
        foreach ($request->input('principal_id') as $data) {
            $save_customer_principal_code = new Customer_principal_code([
                'customer_id'  => $request->input('customer_id'),
                'principal_id' => $data,
                'store_code'   => $request->input('store_code')[$data],
                'user_id' => auth()->user()->id,
            ]);
            $save_customer_principal_code->save();

            $save_customer_principal_price_level = new Customer_principal_price([
                'customer_id'  => $request->input('customer_id'),
                'principal_id' => $data,
                'price_level'   => $request->input('price_level')[$data],
                'user_id' => auth()->user()->id,
            ]);
            $save_customer_principal_price_level->save();
        }

        return 'saved';
    }
}
