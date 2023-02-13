<?php

namespace App\Http\Controllers;
use App\User;
use App\Location;
use App\Location_details;
use App\Personnel_add;
use App\Customer;
use App\Customer_ledger;
use App\Sku_principal;
use Illuminate\Http\Request;

class Customer_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::get();
            $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
            $agent = Personnel_add::select('id', 'full_name')->get();
            $customer = Customer::get();
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('customer', [
                'user' => $user,
                'agent' => $agent,
                'location' => $location,
                'principal' => $principal,
                'employee_name' => $employee_name,
                'customer' => $customer,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_show_location_details(Request $request)
    {
        $select_location_details = Location_details::select('id', 'barangay', 'street')->where('location_id', $request->input('location_id'))->get();

        return view('customer_show_location_details', [
            'location_id' => $select_location_details,
        ]);
    }

    public function customer_save(Request $request)
    {

        //eturn $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd');
        $time = date('His');
        $credit_line_amount = str_replace(',', '', $request->input('credit_line_amount'));
        $save_new_customer = new Customer([
            'store_name'    => strtoupper($request->input('store_name')),
            'location_id'    => $request->input('location_id'),
            'detailed_location'    => strtoupper($request->input('detailed_location')),
            'credit_term'    => $request->input('credit_term'),
            'credit_line_amount'    => $credit_line_amount,
            'contact_person'    => strtoupper($request->input('contact_person')),
            'contact_number'    => $request->input('contact_number'),
            'kind_of_business'    => $request->input('kind_of_business'),
            'status'    => 'UNLOCKED',
        ]);

        $save_new_customer->save();
        $save_new_customer_last_id = $save_new_customer->id;

        // foreach ($request->input('principal') as $key => $data) {
        //     $customer_principal_prices_saved = new Customer_principal_price([
        //         'customer_id'    => $save_new_customer_last_id,
        //         'principal_id'    => $data,
        //         'price_level' => strtoupper($request->input('price_level')[$data]),
        //         'user_id' => auth()->user()->id,
        //     ]);

        //     $customer_principal_prices_saved->save();
        // }

        $save_new_customer_ledger = new Customer_ledger([
            'customer_id'    => $save_new_customer_last_id,
            'principal_id'    => 0,
            'sales_order_number'    => '',
            'transaction_reference'    => 'new customer',
            'accounts_receivable_previous'    => 0.00,
            'sales'    => 0.00,
            'adjustments'    => 0.00,
            'payment'    => 0.00,
            'accounts_receivable_end'    => 0.00,
            'credit_line_amount'    => $credit_line_amount,
            'credit_line_balance'    => $credit_line_amount,
        ]);

        if ($save_new_customer_ledger->save()) {
            return 'save';
        } else {
            return 'error';
        }
    }

    public function customer_location_update(Request $request)
    {
        Customer::where('id', $request->input('customer_id'))
            ->update(['location_id' => $request->input('location_id')]);

        return redirect('customer');
    }
}
