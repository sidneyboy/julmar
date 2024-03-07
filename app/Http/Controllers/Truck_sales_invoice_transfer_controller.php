<?php

namespace App\Http\Controllers;

use App\Logistics;
use App\Logistics_details;
use App\Logistics_invoices;
use App\Sales_invoice;
use App\Sales_invoice_status_logs;
use App\User;
use Carbon\Carbon;
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
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'warehouse_bo',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_sales_invoice_transfer_generate_invoice(Request $request)
    {
        
        $logistics_invoice = Logistics_invoices::select('id', 'sales_invoice_id')->where('logistics_id', $request->input('logistics_id'))->get();

        return view('truck_sales_invoice_transfer_generate_invoice', [
            'logistics_invoice' => $logistics_invoice,
        ]);
    }

    public function truck_sales_invoice_transfer_proceed(Request $request)
    {
        //return $request->input();
        // $logistics = Logistics::select('id', 'location_id', 'created_at', 'user_id', 'driver', 'truck_id', 'helper_1', 'helper_2')
        //     ->find($request->input('logistics_id'));

        foreach ($request->input('sales_invoice_id') as $key => $data) {
            $explode = explode('-', $data);
            $logistics_invoice_id[] = $explode[0];
            $sales_invoice_id[] = $explode[1];
        }

        $logistics_invoice_original = Logistics_invoices::where('logistics_id', $request->input('logistics_id'))->get();

        $logistics_invoice_new = Logistics_invoices::whereNotIn('sales_invoice_id', $sales_invoice_id)->get();

        foreach ($logistics_invoice_new as $key => $data) {
           $logistics_details_id[] = $data->logistics_details_id;
        }

     

        $logistics_invoice_summary = Logistics_details::whereIn('id',$logistics_details_id)->get();

        // $logistics = Logistics::find($request->input('logistics_id'));
        return view('truck_sales_invoice_transfer_proceed', [
            'logistics_invoice_summary' => $logistics_invoice_summary,
            'logistics_invoice_original' => $logistics_invoice_original,
            'logistics_invoice_new' => $logistics_invoice_new,
        ])->with('logistics_invoice_id', $logistics_invoice_id)
            ->with('sales_invoice_id', $sales_invoice_id);
    }

    public function truck_sales_invoice_transfer_save(Request $request)
    {
        //return $request->input();

        date_default_timezone_set('Asia/Manila');
        $date_time = date('Y-m-d H:i:s');
        $date_now = date('Y-m-d');
        foreach ($request->input('principal_id') as $key => $principal_id) {
            Logistics_details::where('logistics_id', $request->input('logistics_id'))
                ->where('principal_id', $principal_id)
                ->update([
                    'case' => $request->input('new_total_case_per_principal')[$principal_id],
                    'butal' => $request->input('new_total_butal_per_principal')[$principal_id],
                    'conversion' => $request->input('new_total_conversion_per_principal')[$principal_id],
                    'amount' => $request->input('new_total_amount_per_principal')[$principal_id],
                    'percentage' => $request->input('new_total_percentage_per_principal')[$principal_id],
                    'equivalent' => $request->input('new_total_equivalent_per_principal')[$principal_id],
                ]);
        }

        for ($i = 0; $i < count($request->input('logistics_invoice_id')); $i++) {
            Logistics_invoices::where('id', $request->input('logistics_invoice_id')[$i])
                ->where('sales_invoice_id', $request->input('sales_invoice_id')[$i])
                ->update([
                    'status' => 'transfered',
                ]);


            Sales_invoice::where('id', $request->input('sales_invoice_id')[$i])
                ->update([
                    'truck_load_status' => null,
                ]);

            $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $request->input('sales_invoice_id')[$i])
                ->orderBy('id', 'desc')
                ->first();
            $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

            Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                ->update([
                    'updated' => $date_now,
                    'no_of_days' => $diff,
                    'created_at' => $date_time,
                ]);

            $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                'sales_invoice_id' => $request->input('sales_invoice_id')[$i],
                'posted' => $date_now,
                'updated' => '',
                'status' => 'For Transfer',
                'user_id' => auth()->user()->id,
            ]);

            $new_sales_invoice_status_logs_save->save();
        }
    }
}
