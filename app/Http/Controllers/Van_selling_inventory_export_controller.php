<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_printed;
use App\Van_selling_printed_details;
use App\Van_selling_inventory_adjustments;
use App\Sku_principal;
use App\Location;
use App\Customer;
use App\Customer_principal_code;
use App\Customer_principal_price;
use App\Sku_add;
use App\Sku_price_details;
use App\Van_selling_upload_ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Van_selling_inventory_export_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            date_default_timezone_set('Asia/Manila');
            $present_date = date('Y-m-d');
            $last_week = date("Y-m-d", strtotime("-7 days"));

            // $van_selling = Van_selling_printed::whereBetween('date', [$last_week, $present_date])->where('remarks', 'printed')->groupBy('customer_id')->get();
            $customer = Customer::select('store_name', 'id', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();

            return view('van_selling_inventory_export', [
                'user' => $user,
                'customer' => $customer,
                'present_date' => $present_date,
                'last_week' => $last_week,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_inventory_export',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_inventory_export_generate_data(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');

        if ($request->input('search_for') == 'van_load_export') {
            $van_selling_printed = Van_selling_printed::select('id', 'total_amount', 'principal_id', 'delivery_receipt')->where('customer_id', $request->input('customer_id'))->where('remarks', 'printed')->get();
            $customer = Customer::select('store_name')->find($request->input('customer_id'));
            $export_customer_name = preg_replace('/[^A-Za-z0-9\-]/', '', $customer->store_name);
            if ($van_selling_printed) {
                return view('van_selling_inventory_export_generate_data_page', [
                    'van_selling_printed' => $van_selling_printed,
                ])->with('date', $date)
                    ->with('time', $time)
                    ->with('export_customer_name', $export_customer_name)
                    ->with('customer', $customer)
                    ->with('customer_id', $request->input('customer_id'));
            } else {
                return 'NO_DATA_FOUND';
            }
        } else if ($request->input('search_for') == 'inventory_adjustment_export') {

            $van_selling_inventory_adjustments = Van_selling_inventory_adjustments::where('customer_id', $request->input('customer_id'))->where('remarks', '!=', 'exported')->first();

            if ($van_selling_inventory_adjustments) {
                return view('van_selling_inventory_export_inventory_adjustments', [
                    'van_selling_inventory_adjustments' => $van_selling_inventory_adjustments,
                ])->with('customer_id', $request->input('customer_id'))
                    ->with('date', $date)
                    ->with('time', $time);
            } else {
                return 'NO_DATA_FOUND';
            }
        } else if ($request->input('search_for') == 'admin_export') {
            $van_selling_printed = Van_selling_printed::select('id')->where('customer_id', $request->input('customer_id'))->where('remarks', 'printed')->get();
            $van_selling_ledger = DB::table('Van_selling_upload_ledgers')
                ->select('id', 'principal', 'sku_code', 'unit_of_measurement', 'description', 'beg', 'butal_equivalent', 'reference', 'customer_id', 'sku_type', DB::raw('SUM(sales) as total_sales'), DB::raw('SUM(van_load) as total_van_load'), DB::raw('SUM(adjustments) as total_adjustments'), DB::raw('SUM(pcm) as total_pcm'), DB::raw('SUM(inventory_adjustments) as total_inventory_adjustments'))
                ->where('customer_id', $request->input('customer_id'))
                ->groupBy('sku_code')
                ->get();
            $counter = count($van_selling_ledger);

            $customer_data = Customer::find($request->input('customer_id'));

            if ($counter != 0) {
                foreach ($van_selling_ledger as $key => $data) {
                    $customer_id = $data->customer_id;
                    $new_query_for_van_selling_ledger = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data->sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    $sku_code_array[] = $data->sku_code;
                    $butal_equivalent_array[] = $new_query_for_van_selling_ledger[0]->butal_equivalent;
                    $unit_of_measurement_array[] = $new_query_for_van_selling_ledger[0]->unit_of_measurement;
                    $unit_price_array[] = $new_query_for_van_selling_ledger[0]->unit_price;
                    $running_balance_array[] = $new_query_for_van_selling_ledger[0]->running_balance;
                    $ending_array[] = $new_query_for_van_selling_ledger[0]->end;
                    $sku_type_array[] = $new_query_for_van_selling_ledger[0]->sku_type;
                }

                //return $ending_array;



                return view('van_selling_inventory_export_admin_export', [
                    'van_selling_ledger' => $van_selling_ledger,
                    'ending_array' => $ending_array,
                    'van_selling_printed' => $van_selling_printed,
                    'sku_code_array' => $sku_code_array,
                    'butal_equivalent_array' => $butal_equivalent_array,
                    'unit_price_array' => $unit_price_array,
                    'running_balance_array' => $running_balance_array,
                    'unit_of_measurement_array' => $unit_of_measurement_array,
                    'sku_type_array' => $sku_type_array,
                ])->with('counter', $counter)
                    ->with('date', $date)
                    ->with('time', $time)
                    ->with('customer_data', $customer_data);
            } else {
                return 'NO_DATA_FOUND';
            }
        }
    }

    public function van_selling_inventory_export_save(Request $request)
    {
        foreach ($request->input('van_selling_printed_id') as $key => $data) {
            Van_selling_printed::where('id', $data)
                ->update([
                    'remarks' => 'exported',
                ]);
        }
        return redirect('van_selling_inventory_export');
    }

    public function van_selling_inventory_export_inventory_adjustments_save(Request $request)
    {
        Van_selling_inventory_adjustments::where('id', $request->input('vs_inv_adj_id'))
            ->update(['remarks' => 'exported']);

        return redirect('van_selling_inventory_export');
    }

    public function van_selling_inventory_export_admin_export_verify(Request $request)
    {
        //return $request->input();
        $user = User::select('position')->where('secret_key', $request->input('secret_key'))->first();
        if ($user->position == 'System_admin' or $user->position == 'Audit_head' or $user->position == 'Operations_manager') {
            if ($request->input('van_selling_printed') != 0) {
                foreach ($request->input('van_selling_printed') as $key => $data) {
                    Van_selling_printed::where('id', $data)
                        ->update(['remarks' => 'exported']);
                }
                return 'access_granted';
            } else {
                return 'access_granted';
            }
        } else {
            return 'access_denied';
        }
    }
}
