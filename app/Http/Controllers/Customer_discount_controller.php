<?php

namespace App\Http\Controllers;
use App\User;
use App\Sku_principal;
use App\Customer;
use App\Customer_discount;
use Illuminate\Http\Request;

class Customer_discount_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $select_principal = Sku_principal::select('id', 'principal')->where('principal','!=','none')->get();
            $select_store = Customer::select('id', 'store_name', 'location_id')->get();
            return view('customer_discount', [
                'user' => $user,
                'select_principal' => $select_principal,
                'select_store' => $select_store,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer_discount',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_discount_show_input(Request $request)
    {
        return view('customer_discount_show_input')->with('number_of_discounts', $request->input('number_of_discounts'));
    }

    public function customer_discount_save(Request $request)
    {
        foreach ($request->input('customer_discount') as $key => $customer_discount) {
            $customer_discount_save = new Customer_discount([
                'principal_id' => $request->input('principal'),
                'customer_id' => $request->input('store'),
                'customer_discount' => $customer_discount
            ]);
            $customer_discount_save->save();
        }
    }
}
