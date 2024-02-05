<?php

namespace App\Http\Controllers;

use App\Logistics;
use App\Logistics_details;
use App\Logistics_invoices;
use App\Sales_invoice_status_logs;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_control_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $logistics = Logistics::select('id', 'truck_id', 'driver')
                ->where('control', null)
                ->get();
            return view('truck_controler', [
                'user' => $user,
                'logistics' => $logistics,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_controler',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_controler_proceed(Request $request)
    {
        $logistics = Logistics::select('id', 'location_id', 'created_at', 'user_id', 'driver', 'truck_id', 'helper_1', 'helper_2')
            ->where('id', $request->input('truck_driver'))
            ->first();

        return view('truck_controler_proceed', [
            'logistics' => $logistics,
        ]);
    }

    public function truck_load_controler_print(Request $request)
    {

        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');
        foreach ($request->input('sales_invoice_id') as $key => $data_sales_invoice_id) {
            $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $data_sales_invoice_id)
                ->orderBy('id', 'desc')
                ->first();
            $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

            Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                ->update([
                    'updated' => $date_now,
                    'no_of_days' => $diff
                ]);

            $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                'sales_invoice_id' => $data_sales_invoice_id,
                'posted' => $date_now,
                'updated' => '',
                'status' => 'Printed Loadsheet Control',
                'user_id' => auth()->user()->id,
            ]);

            $new_sales_invoice_status_logs_save->save();
        }


        Logistics::where('id', $request->input('logistics_id'))
            ->update([
                'control' => 'printed',
            ]);

        $logistics_invoices = Logistics_invoices::whereIn('sales_invoice_id', $request->input('sales_invoice_id'))
            ->get();

        return view('truck_load_controler_print', [
            'logistics_invoices' => $logistics_invoices,
        ]);
    }
}
