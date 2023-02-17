<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_printed;
use App\Van_selling_printed_details;
use App\Sku_principal;
use App\Location;
use App\Customer;
use App\Customer_principal_code;
use Illuminate\Http\Request;

class Van_selling_invoice_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $van_selling = Van_selling_printed::where('remarks', '!=', 'printed')->where('remarks', '!=', 'exported')->where('remarks', '!=', 'CANCELLED')->orderBy('id', 'Desc')->get();
            return view('van_selling_invoice', [
                'user' => $user,
                'van_selling' => $van_selling,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_invoice',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_invoice_generate(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $van_selling = Van_selling_printed::find($request->input('van_selling_id'));
        $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $van_selling->customer_id)->where('principal_id', $van_selling->principal_id)->first();


        return view('van_selling_invoice_generate_page', [
            'van_selling' => $van_selling,
        ])->with('customer_principal_code', $customer_principal_code)
            ->with('date', $date);
    }

    public function van_selling_invoice_print(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $van_selling = Van_selling_printed::find($request->input('van_selling_id'));
        $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $van_selling->customer_id)->where('principal_id', $van_selling->principal_id)->first();
        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();

        Van_selling_printed::where('id', $request->input('van_selling_id'))
            ->update(['remarks' => 'printed']);

        return view('van_selling_invoice_print_page', [
            'van_selling' => $van_selling,
        ])->with('customer_principal_code', $customer_principal_code)
            ->with('date', $date)
            ->with('employee_name', $employee_name);
    }
}
