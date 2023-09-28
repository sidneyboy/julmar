<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Audit_approved_controller extends Controller
{
    public function index()
    {
        // $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        // $customer = Customer::where('status', 'Pending Approval')->get();
        // $location = Location::get();
        // return view('audit_approved_customer', [
        //     'mainTab' => '',
        //     'subTab'  => '',
        //     'activeTab' => '',
        //     'dashboard' => '',
        //     'principal_tab' => '',
        //     'return_to_principal_active_tab'  => '',
        //     'principal_sub_tab'  => '',
        //     'adjustment_tab' => '',
        //     'adjustment_sub_tab'  => '',
        //     'principal_active_tab'  => '',
        //     'personnel_tab' => '',
        //     'personnel_sub_tab'  => '',
        //     'personnel_active_tab'  => '',
        //     'transfer_tab' => '',
        //     'transfer_sub_tab'  => '',
        //     'transfer_active_tab'  => '',
        //     'transfer_to_branch_tab' => '',
        //     'transfer_to_branch_sub_tab'  => '',
        //     'transfer_to_branch_active_tab'  => '',
        //     'sales_order_tab' => 'sales_order_tab',
        //     'sales_order_tab_sub_tab'  => 'sales_order_tab_sub_tab',
        //     'sales_order_tab_active_tab'  => 'audit_approved_customer',
        //     'accounting' => '',
        //     'accounting_sub_tab'  => '',
        //     'accounting_active_tab'  => '',
        //     'van_selling_tab' => '',
        //     'van_selling_sub_tab'  => '',
        //     'van_selling_active_tab'  => '',
        //     'employee_name' => $employee_name,
        //     'location' => $location,
        //     'customer' => $customer,
        //     'logistics_tab' => '',
        //     'logistics_sub_tab'  => '',
        //     'logistics_active_tab' => '',
        // ]);

        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::where('status', 'Pending Approval')->get();
            $location = Location::get();
            return view('audit_approved_customer', [
                'user' => $user,
                'customer' => $customer,
                'location' => $location,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'audit_approved_customer',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function audit_approved_customer_process(Request $request)
    {
        $user = User::select('id', 'password', 'position')->find(auth()->user()->id);
        if ($user->position == 'admin' or $user->position == 'audit') {
            $hashedPassword = $user->password;
            if (Hash::check($request->input('password'), $hashedPassword)) {
                Customer::where('id', $request->input('customer_id'))
                    ->update(['status' => 'Approved']);

                return redirect('audit_approved_customer')->with('sucess', 'Approved Successfully');
            } else {
                return redirect('audit_approved_customer')->with('error', 'Wrong Password');
            }
        }else{
            return redirect('audit_approved_customer')->with('error', 'Access Disallowed');
        }
    }
}
