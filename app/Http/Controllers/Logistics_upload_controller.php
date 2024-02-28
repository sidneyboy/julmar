<?php

namespace App\Http\Controllers;

use App\Logistics_invoices;
use App\Logistics_upload;
use App\Sales_invoice;
use App\Sales_invoice_status_logs;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Logistics_upload_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);

            return view('Logistics_upload', [
                'user' => $user,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'Logistics_upload',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function logistics_upload_proceed(Request $request)
    {
        $csv = array();
        $count_all_data = $_FILES["file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }

        $checker = Logistics_upload::where('logistics_id', $csv[0][4])->count();

        if ($checker == 0) {
            return view('logistics_upload_proceed', [
                'csv' => $csv,
            ]);
        } else {
            return 'existing';
        }
    }

    public function logistics_upload_save(Request $request)
    {
        //return $request->input();
        for ($sales_invoice_id = 0; $sales_invoice_id < count($request->input('sales_invoice_id')); $sales_invoice_id++) {
            $curdate = DB::select('SELECT CURDATE()');
            if ($request->input('status')[$sales_invoice_id] == 'DELIVERED') {
                $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $request->input('sales_invoice_id')[$sales_invoice_id])
                    ->orderBy('id', 'desc')
                    ->first();
                $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

                Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                    ->update([
                        'updated' => $curdate[0]->{'CURDATE()'},
                        'no_of_days' => $diff
                    ]);

                $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                    'sales_invoice_id' => $request->input('sales_invoice_id')[$sales_invoice_id],
                    'posted' => $curdate[0]->{'CURDATE()'},
                    'updated' => '',
                    'status' => 'Delivered',
                    'user_id' => auth()->user()->id,
                ]);

                $new_sales_invoice_status_logs_save->save();

                Logistics_invoices::where('sales_invoice_id', $request->input('sales_invoice_id')[$sales_invoice_id])
                    ->where('logistics_id', $request->input('logistics_id'))
                    ->update(['delivered_date' => $request->input('delivered_date')[$sales_invoice_id]]);

                Sales_invoice::where('id', $request->input('sales_invoice_id')[$sales_invoice_id])
                    ->update([
                        'delivered_date' => $request->input('delivered_date')[$sales_invoice_id],
                        'delivery_status' => 'Delivered',
                        'cm_for_confirmation_amount' => $request->input('deducted_amount')[$sales_invoice_id],
                    ]);

                $new_logistics_upload = new Logistics_upload([
                    'logistics_id' => $request->input('logistics_id'),
                    'sales_invoice_id' => $request->input('sales_invoice_id')[$sales_invoice_id],
                    'date' => $curdate[0]->{'CURDATE()'},
                    'delivered_date' => $request->input('delivered_date')[$sales_invoice_id],
                ]);

                $new_logistics_upload->save();
            } else {
                $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $request->input('sales_invoice_id')[$sales_invoice_id])
                    ->orderBy('id', 'desc')
                    ->first();
                $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

                Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                    ->update([
                        'updated' => $curdate[0]->{'CURDATE()'},
                        'no_of_days' => $diff
                    ]);

                $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                    'sales_invoice_id' => $request->input('sales_invoice_id')[$sales_invoice_id],
                    'posted' => $curdate[0]->{'CURDATE()'},
                    'updated' => '',
                    'status' => 'Transfered to ' . strtolower($request->input('status')[$sales_invoice_id]),
                    'user_id' => auth()->user()->id,
                ]);

                $new_sales_invoice_status_logs_save->save();
            }
        }
    }
}
