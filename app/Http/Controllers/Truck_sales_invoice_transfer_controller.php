<?php

namespace App\Http\Controllers;

use App\Logistics;
use App\Logistics_details;
use App\Logistics_invoices;
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
            $logistics = Logistics::select('id', 'driver')->where('arrival_date', null)->get();

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

    public function truck_sales_invoice_transfer_generate_invoice(Request $request)
    {
        $logistics_invoice = Logistics_invoices::select('sales_invoice_id')->where('logistics_id', $request->input('logistics_id'))->get();

        return view('truck_sales_invoice_transfer_generate_invoice', [
            'logistics_invoice' => $logistics_invoice,
        ]);
    }

    public function truck_sales_invoice_transfer_proceed(Request $request)
    {
        //return $request->input();
        // $logistics = Logistics::select('id', 'location_id', 'created_at', 'user_id', 'driver', 'truck_id', 'helper_1', 'helper_2')
        //     ->find($request->input('logistics_id'));

        $logistics_invoice_original = Logistics_invoices::where('logistics_id', $request->input('logistics_id'))->get();

        $logistics_invoice_new = Logistics_invoices::whereNotIn('sales_invoice_id', $request->input('sales_invoice_id'))->get();
        //$logistics_invoice_new = Logistics_invoices::where('logistics_id', $request->input('logistics_id'))->get();

        $logistics = Logistics::find($request->input('logistics_id'));
        return view('truck_sales_invoice_transfer_proceed', [
            'logistics' => $logistics,
            'logistics_invoice_original' => $logistics_invoice_original,
            'logistics_invoice_new' => $logistics_invoice_new,
        ])->with('sales_invoice_id', $request->input('sales_invoice_id'));
    }

    public function truck_sales_invoice_transfer_save(Request $request)
    {
        return $request->input();
    }
}
