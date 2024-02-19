<?php

namespace App\Http\Controllers;

use App\Logistics;
use App\Sales_invoice;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_sales_invoice_transfer_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            $logistics = Logistics::select('id','driver')->where('arrival_date', null)->get();

            return view('truck_sales_invoice_transfer', [
                'logistics' => $logistics,
                'user' => $user,
                'main_tab' => 'manage_custodian_main_tab',
                'sub_tab' => 'manage_custodian_sub_tab',
                'active_tab' => 'warehouse_bo',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_sales_invoice_transfer_proceed(Request $request)
    {
        $sales_invoice = Sales_invoice::select('delivery_receipt', 'id')->find($request->input('sales_invoice'));

        return view('truck_sales_invoice_transfer_proceed', [
            'sales_invoice' => $sales_invoice,
        ]);
    }

    public function truck_sales_invoice_transfer_save(Request $request)
    {
        return $request->input();
    }
}
