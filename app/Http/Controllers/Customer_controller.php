<?php

namespace App\Http\Controllers;

use App\Chart_of_accounts;
use App\Chart_of_accounts_details;
use App\User;
use App\Location;
use App\Location_details;
use App\Personnel_add;
use App\Customer;
use App\Customer_ledger;
use App\Sku_principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
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
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_generate_location_details(Request $request)
    {
        $location_details = Location_details::select('id', 'barangay')->where('location_id', $request->input('location_id'))
            ->get();

        return view('customer_generate_location_details', [
            'location_details' => $location_details,
        ]);
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
        //return $request->input();
        // $location_details = Location_details::select('id', 'location_id')->find($request->input('location_id'));

        date_default_timezone_set('Asia/Manila');
        $date = date('Ymd');
        $time = date('His');

        $credit_line_amount = str_replace(',', '', $request->input('credit_line_amount'));
        $save_new_customer = new Customer([
            'store_name'    => strtoupper($request->input('store_name')),
            'location_id'    => $request->input('location_details_id'),
            'detailed_location'    => strtoupper($request->input('detailed_location')),
            'credit_term'    => $request->input('credit_term'),
            'credit_line_amount'    => $credit_line_amount,
            'contact_person'    => strtoupper($request->input('contact_person')),
            'contact_number'    => $request->input('contact_number'),
            'kind_of_business'    => $request->input('kind_of_business'),
            'status'    => 'UNLOCKED',
            'mode_of_transaction' => $request->input('mode_of_transaction'),
            'allowed_number_of_sales_order' => $request->input('max_allowed_so'),
            'location_details_id' => $request->input('location_details_id'),
        ]);

        $save_new_customer->save();
        $save_new_customer_last_id = $save_new_customer->id;

        $check_chart_of_account = Chart_of_accounts::select('id', 'account_number', 'account_name')->where('account_name', 'ACCOUNTS RECEIVABLE')->first();

        if (count($check_chart_of_account->chart_of_accounts_details) == 0) {
            $new_chart_of_account_details = new Chart_of_accounts_details([
                'chart_of_accounts_id' => $check_chart_of_account->id,
                'account_name' => $check_chart_of_account->account_name . " - " . strtoupper($request->input('store_name')),
                'account_number' => $check_chart_of_account->account_number + 1,
                'customer_id' => $save_new_customer->id,
            ]);

            $new_chart_of_account_details->save();
        } else {
            $new_account_number = $check_chart_of_account->chart_of_accounts_details[0]->account_number + 1;
            $new_chart_of_account_details = new Chart_of_accounts_details([
                'chart_of_accounts_id' => $check_chart_of_account->id,
                'account_name' => $check_chart_of_account->account_name . " - " . strtoupper($request->input('store_name')),
                'account_number' => $new_account_number,
                'customer_id' => $save_new_customer->id,
            ]);

            $new_chart_of_account_details->save();
        }

        $save_new_customer_ledger = new Customer_ledger([
            'customer_id'    => $save_new_customer_last_id,
            // 'principal_id'    => 0,
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
            return 'saved';
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
