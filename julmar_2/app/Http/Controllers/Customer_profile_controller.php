<?php

namespace App\Http\Controllers;
use App\User;
use App\Sku_principal;
use App\Customer;
use App\Customer_ledger;
use App\Customer_principal_code;
use App\Customer_principal_price;
use App\Location;
use DB;
use Illuminate\Http\Request;

class Customer_profile_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->get();
            $customer = Customer::select('id', 'store_name', 'location_id')->get();
            return view('customer_profile', [
                'user' => $user,
                'principal' => $principal,
                'customer' => $customer,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer_profile',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_profile_search(Request $request)
    {
        $location = Location::get();
        $store_name = Customer::find($request->input('customer_id'));
        if ($request->input('principal') != 'All') {
            $selected_option = 'Principal';

            $customer_principal_code = Customer_principal_code::select('store_code', 'principal_id')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal'))->get();

            $customer_principal_price = Customer_principal_price::select('price_level', 'principal_id')->where('customer_id', $request->input('customer_id'))->where('principal_id', $request->input('principal'))->get();

            if ($store_name) {
                $customer_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM customer_ledgers WHERE customer_id = '$store_name->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                $credit_line_balance[] = $customer_ledger_result[0]->credit_line_balance;
                return view('customer_profile_show_customers', [
                    'store_name' => $store_name,
                    'location' => $location
                ])->with('principal_id', $request->input('principal'))
                    ->with('credit_line_balance', $credit_line_balance)
                    ->with('customer_principal_code', $customer_principal_code)
                    ->with('customer_principal_price', $customer_principal_price)
                    ->with('selected_option', $selected_option)
                    ->with('customer_id', $request->input('customer_id'));
            } else {
                return 'store_name_not_found';
            }
        } else {

            $selected_option = 'All';
            $customer_principal_code = Customer_principal_code::select('store_code', 'principal_id')->where('customer_id', $request->input('customer_id'))->get();

            $customer_principal_price = Customer_principal_price::select('price_level', 'principal_id')->where('customer_id', $request->input('customer_id'))->get();

            foreach ($customer_principal_code as $key => $data) {
                $principal_code_id[] = $data->principal_id;
            }

            foreach ($customer_principal_price as $key => $data) {
                $principal_price_id[] = $data->principal_id;
            }


            $principal_code = Sku_principal::where('principal', '!=', 'none')->whereNotIn('id', $principal_code_id)->get();
            $principal_price = Sku_principal::where('principal', '!=', 'none')->whereNotIn('id', $principal_price_id)->get();


            if ($store_name) {
                $customer_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM customer_ledgers WHERE customer_id = '$store_name->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                $credit_line_balance[] = $customer_ledger_result[0]->credit_line_balance;
                return view('customer_profile_show_customers', [
                    'store_name' => $store_name,
                    'location' => $location
                ])->with('principal_id', $request->input('principal'))
                    ->with('credit_line_balance', $credit_line_balance)
                    ->with('customer_principal_code', $customer_principal_code)
                    ->with('customer_principal_price', $customer_principal_price)
                    ->with('customer_id', $request->input('customer_id'))
                    ->with('principal_code', $principal_code)
                    ->with('principal_price', $principal_price)
                    ->with('selected_option', $selected_option);
            } else {
                return 'store_name_not_found';
            }
        }
    }

    public function customer_profile_show_details(Request $request, $id)
    {

        $var_explode = explode('=', $id);
        $customer_id = $var_explode[0];
        $principal_id = $var_explode[1];
        $store_name = $var_explode[2];

        if ($principal_id == 'All') {
            $principal = $principal_id;
            $select_customer_ledger = Customer_ledger::where('customer_id', $customer_id)->get();
            $select_customer_principal_code = '';
            $select_customer_data = Customer::find($customer_id);
        } else {

            $select_customer_ledger = Customer_ledger::where('customer_id', $customer_id)->where('principal_id', $principal_id)->get();
            $select_customer_data = Customer::find($customer_id);
            $select_customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $customer_id)
                ->where('principal_id', $principal_id)->first();
        }



        $accounts_receivable_end = Customer_ledger::select('accounts_receivable_end')
            ->where('customer_id', $customer_id)
            ->latest('created_at')->first();



        return view('customer_profile_show_details', [
            'select_customer_ledger' => $select_customer_ledger,
        ])->with('store_name', $store_name)
            ->with('select_customer_data', $select_customer_data)
            ->with('accounts_receivable_end', $accounts_receivable_end)
            ->with('select_customer_principal_code', $select_customer_principal_code);
    }

    public function customer_profile_update_credit_line(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $user = User::where('position', 'Operations Manager')->where('secret_key', $request->input('om_access_key'))->first();

        $to_update_credit_line_amount = str_replace(',', '', $request->input('credit_line_amount'));

        if ($user) {
            Customer::where('id', $request->input('customer_id'))
                ->update(['credit_line_amount' => $credit_line_amount]);

            $customer_ledger = Customer_ledger::where('customer_id', $request->input('customer_id'))->orderBy('id', 'DESC')->limit(1)->first();

            $plus_minus_to_credit_line_balance = $to_update_credit_line_amount - $customer_ledger->credit_line_balance;


            $update_credit_line_balance = $plus_minus_to_credit_line_balance + $customer_ledger->credit_line_balance;

            $customer_ledger_save = new Customer_ledger([
                'customer_id' => $request->input('customer_id'),
                'principal_id' => 0,
                'delivery_receipt' => '',
                'store_code' => $customer_ledger->store_code,
                'sales_order_number' => '',
                'transaction_reference' => 'Update Credit Line Amount & Balance',
                'accounts_receivable_previous' => $customer_ledger->accounts_receivable_end,
                'sales' => 0,
                'payment' => 0,
                'bo' => 0,
                'rgs' => 0,
                'adjustments' => 0,
                'accounts_receivable_end' => $customer_ledger->accounts_receivable_end,
                'credit_line_amount' => $to_update_credit_line_amount,
                'update_credit_line_amount' => $to_update_credit_line_amount,
                'credit_line_balance' => $update_credit_line_balance,
                'date' => $date,

            ]);


            $customer_ledger_save->save();
        } else {
            return 'incorrect_credentials';
        }
    }

    public function customer_profile_status_changed(Request $request)
    {

        Customer::where('id', $request->input('customer'))
            ->update(['status' => $request->input('status')]);

        return 'saved';
    }

    public function customer_profile_update(Request $request)
    {
        return $request->input();
    }

    public function customer_profile_generate_principal_code_list()
    {
        $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'NONE')->get();
        $customer = Customer::select('id', 'store_name', 'detailed_location')->where('kind_of_business', '!=', 'VAN SELLING')->where('location_id', 1)->get();
        return view('customer_profile_generate_principal_code_list', [
            'customer' => $customer,
            'principal' => $principal,
        ]);
    }
}
