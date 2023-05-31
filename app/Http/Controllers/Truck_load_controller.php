<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Agent;
use App\Sales_invoice;
use App\Sales_invoice_details;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_load_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            return view('truck_load', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_load',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_load_proceed(Request $request)
    {
        $agent = Agent::where('location_id', $request->input('location_id'))
            ->get();

        return view('truck_load_proceed', [
            'agent' => $agent,
        ])->with('location_id', $request->input('location_id'));
    }

    public function truck_load_generated_invoices(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'delivery_receipt', 'agent_id')
            ->whereIn('agent_id', $request->input('agent_id'))
            ->get();

        return view('truck_load_generated_invoices', [
            'sales_invoice' => $sales_invoice,
        ])->with('location_id', $request->input('location_id'));
    }

    public function truck_load_generated_invoices_data(Request $request)
    {
        $sales_invoice_details = Sales_invoice_details::select('*', DB::raw('sum(quantity) as total'))
            ->whereIn('sales_invoice_id', $request->input('sales_invoice_id'))
            ->groupBy('sku_id')
            ->get();

        return view('truck_load_generated_invoices_data', [
            'sales_invoice_details' => $sales_invoice_details
        ])->with('location_id', $request->input('location_id'))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'));
    }
}
