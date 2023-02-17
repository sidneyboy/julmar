<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Location;
use App\Van_selling_upload_ledger;
use App\Van_selling_beginning;
use App\Van_selling_ar_ledger;
use App\Van_selling_transfer_inventory;
use App\Van_selling_transfer_inventory_details;
use App\Van_selling_inventory_clearing;
use App\Sku_principal;
use DB;
use Illuminate\Http\Request;

class Van_selling_report_date_range_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::get();
            $customer = Customer::select('id', 'store_name', 'kind_of_business')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_report_date_range', [
                'user' => $user,
                'location' => $location,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_report_date_range',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_report_date_range_generate_data(Request $request)
    {
        //return $request->input();


        $data_range = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($data_range[0]));
        $date_to = date('Y-m-d', strtotime($data_range[1]));
        $customer_data = explode('-', $request->input('customer'));
        $customer_id = $customer_data[0];
        $store_name = $customer_data[1];

        $van_selling_beginning_check = Van_selling_beginning::select('id')->where('customer_id', $customer_id)->latest()
            ->first();

        if ($van_selling_beginning_check) {
            $van_selling_ledger = DB::table('Van_selling_upload_ledgers')
                ->select(
                    'id',
                    'principal',
                    'sku_code',
                    'unit_of_measurement',
                    'description',
                    'beg',
                    'butal_equivalent',
                    'reference',
                    'customer_id',
                    'sku_type',
                    DB::raw('SUM(sales) as total_sales'),
                    DB::raw('SUM(van_load) as total_van_load'),
                    DB::raw('SUM(pcm) as total_pcm'),
                    DB::raw('SUM(inventory_adjustments) as total_inventory_adjustments')
                )
                ->whereBetween('date', [$date_from, $date_to])
                ->where('customer_id', $customer_id)
                ->groupBy('sku_code')
                ->orderBy('principal')
                ->orderBy('sku_code')
                ->get();
        } else {
            $van_selling_ledger = DB::table('Van_selling_upload_ledgers')
                ->select(
                    'id',
                    'principal',
                    'sku_code',
                    'unit_of_measurement',
                    'description',
                    'beg',
                    'butal_equivalent',
                    'reference',
                    'customer_id',
                    'sku_type',
                    DB::raw('SUM(sales) as total_sales'),
                    DB::raw('SUM(van_load) as total_van_load'),
                    DB::raw('SUM(pcm) as total_pcm'),
                    DB::raw('SUM(inventory_adjustments) as total_inventory_adjustments')
                )
                ->where('customer_id', $customer_id)
                ->groupBy('sku_code')
                ->orderBy('principal')
                ->orderBy('sku_code')
                ->get();
        }

        if (count($van_selling_ledger) != 0) {
            foreach ($van_selling_ledger as $key => $data) {
                $van_selling_ledger_latest = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data->sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                $unit_price[$data->sku_code] = $van_selling_ledger_latest[0]->unit_price;
                $ending_balance[$data->sku_code] = $van_selling_ledger_latest[0]->end;
                $running_balance[$data->sku_code] = $van_selling_ledger_latest[0]->running_balance;
                $van_selling_ledger_latest_id[$data->sku_code] = $van_selling_ledger_latest[0]->id;
            }
        } else {
            $van_selling_ledger_latest = '';
            $unit_price = '';
            $ending_balance = '';
            $running_balance = '';
            $van_selling_ledger_latest_id = '';
        }

        $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'NONE')->get();

        return view('van_selling_report_date_range_generate_data_page', [
            'van_selling_ledger' => $van_selling_ledger,
            'van_selling_ledger_latest' => $van_selling_ledger_latest,
            'unit_price' => $unit_price,
            'principal' => $principal,
            'ending_balance' => $ending_balance,
            'running_balance' => $running_balance,
            'van_selling_ledger_latest_id' => $van_selling_ledger_latest_id,
        ])->with('customer_id', $customer_id)
            ->with('store_name', $store_name)
            ->with('date_from', $date_from)
            ->with('date_to', $date_to);
    }

    public function van_selling_report_date_range_itemized(Request $request, $data)
    {
        $itemized_data = explode(',', $data);
        $sku_code = $itemized_data[0];
        $customer_id = $itemized_data[1];
        $date_from = $itemized_data[2];
        $date_to = $itemized_data[3];

        $van_selling_ledger = Van_selling_upload_ledger::where('sku_code', $sku_code)
            ->where('customer_id', $customer_id)
            ->whereBetween('date', [$date_from, $date_to])
            ->get();

        return view('van_selling_report_date_range_itemized_page', [
            'van_selling_ledger' => $van_selling_ledger,
        ]);
    }

    public function van_selling_report_date_range_generate_sku_movement(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        $customer_id = $request->input('customer_id');
        $van_selling_beginning_save = new Van_selling_beginning([
            'customer_id' => $customer_id,
            'date' => $date,
            'user_id' => auth()->user()->id,
        ]);

        $van_selling_beginning_save->save();
        foreach ($request->input('sku_code_for_movement') as $key => $sku_code) {
            $van_selling_ledger_latest_row = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $van_selling_upload_ledger = new Van_selling_upload_ledger([
                'customer_id' => $customer_id,
                'principal' => $van_selling_ledger_latest_row[0]->principal,
                'sku_code' => $sku_code,
                'description' => $van_selling_ledger_latest_row[0]->description,
                'unit_of_measurement' => $van_selling_ledger_latest_row[0]->unit_of_measurement,
                'sku_type' => $van_selling_ledger_latest_row[0]->sku_type,
                'butal_equivalent' => $van_selling_ledger_latest_row[0]->butal_equivalent,
                'reference' => 'SKU INVENTORY MOVEMENT',
                'beg' => $van_selling_ledger_latest_row[0]->end,
                'van_load' => 0,
                'sales' => 0,
                'adjustments' => 0,
                'inventory_adjustments' => 0,
                'clearing' => 0,
                'end' => $van_selling_ledger_latest_row[0]->end,
                'unit_price' => $van_selling_ledger_latest_row[0]->unit_price,
                'total' => $van_selling_ledger_latest_row[0]->unit_price * $van_selling_ledger_latest_row[0]->end,
                'running_balance' => $van_selling_ledger_latest_row[0]->unit_price * $van_selling_ledger_latest_row[0]->end,
                'date' => $date,
                'remarks' => $employee_name->name,
            ]);

            $van_selling_upload_ledger->save();
        }

        return 'saved';
    }

    public function van_selling_report_date_range_generate_clearing(Request $request)
    {

        $van_selling_upload_ledger_id_array = explode(',', $request->input('van_selling_upload_ledger_id'));

        $van_selling_sku_ledger = Van_selling_upload_ledger::whereIn('id', $van_selling_upload_ledger_id_array)
            ->where('customer_id', $request->input('customer_id'))
            ->get();

        $van_selling_ar_ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();

        if ($van_selling_ar_ledger) {
            return view('van_selling_report_date_range_generate_clearing', [
                'van_selling_ar_ledger' => $van_selling_ar_ledger,
                'van_selling_sku_ledger' => $van_selling_sku_ledger,
            ])->with('customer_id', $request->input('customer_id'))
                ->with('date_from', $request->input('date_from'))
                ->with('date_to', $request->input('date_to'));
        } else {
            return 'no_sda';
        }
    }

    public function van_selling_report_date_range_generate_clearing_per_principal(Request $request)
    {
        //return $request->input();
        $van_selling_upload_ledger_id_array = explode(',', $request->input('van_selling_upload_ledger_id'));

        $van_selling_sku_ledger = Van_selling_upload_ledger::whereIn('id', $van_selling_upload_ledger_id_array)
            ->where('customer_id', $request->input('customer_id'))
            ->where('principal', $request->input('principal'))
            ->get();

        $van_selling_ar_ledger = Van_selling_ar_ledger::select('over_short', 'running_balance', 'outstanding_balance')->where('customer_id', $request->input('customer_id'))->latest()->first();

        if ($van_selling_ar_ledger) {
            return view('van_selling_report_date_range_generate_clearing_per_principal', [
                'van_selling_ar_ledger' => $van_selling_ar_ledger,
                'van_selling_sku_ledger' => $van_selling_sku_ledger,
            ])->with('customer_id', $request->input('customer_id'))
                ->with('date_from', $request->input('date_from'))
                ->with('date_to', $request->input('date_to'))
                ->with('principal', $request->input('principal'));
        } else {
            return 'no_sda';
        }
    }

    public function van_selling_report_date_range_generate_clearing_per_sku(Request $request)
    {
        $checked_sku = $request->input('sku_code_for_transfer_per_sku');
        if (empty($checked_sku)) {
            return 'checkbox_error';
        } else {
            $van_selling_upload_ledger_id_array = explode(',', $request->input('sku_code_for_transfer_per_sku'));

            $van_selling_sku_ledger = Van_selling_upload_ledger::whereIn('id', $van_selling_upload_ledger_id_array)
                ->where('customer_id', $request->input('customer_id'))
                ->get();

            $van_selling_ar_ledger = Van_selling_ar_ledger::select('over_short', 'running_balance', 'outstanding_balance')->where('customer_id', $request->input('customer_id'))->latest()->first();

            if ($van_selling_ar_ledger) {
                return view('van_selling_report_date_range_generate_clearing_per_sku', [
                    'van_selling_ar_ledger' => $van_selling_ar_ledger,
                    'van_selling_sku_ledger' => $van_selling_sku_ledger,
                ])->with('customer_id', $request->input('customer_id'))
                    ->with('date_from', $request->input('date_from'))
                    ->with('date_to', $request->input('date_to'))
                    ->with('principal', $request->input('principal'));
            } else {
                return 'no_sda';
            }
        }
    }

    public function van_selling_report_date_range_clearing_operation_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        if ($request->input('transfer_type') == 'principal') {
            $user = User::select('position')->where('secret_key', $request->input('secret_key'))->first();
            if ($user) {
                if ($user->position == 'System_admin' or $user->position == 'Audit_staff' or $user->position == 'Audit_head') {
                    $van_selling_transfer_save = new Van_selling_transfer_inventory([
                        'customer_id' => $request->input('customer_id'),
                        'transfered_amount' => $request->input('vs_inventory_running_balance'),
                        'user_id' => auth()->user()->id,
                        'status' => 'NOT_YET_TRANSFERED',
                        'date' => $date,
                    ]);

                    $van_selling_transfer_save->save();

                    $van_selling_inventory_clearing_save = new Van_selling_inventory_clearing([
                        'customer_id' => $request->input('customer_id'),
                        'vs_ar_ending_balance' => $request->input('outstanding_balance'),
                        'vs_inventory_running_balance' => $request->input('vs_inventory_running_balance'),
                        'adjustments' => 0,
                        'total_adjustments' => round($request->input('vs_inventory_running_balance'), 2) * -1,
                        'date' => $date,
                    ]);

                    $van_selling_inventory_clearing_save->save();
                    $van_selling_inventory_clearing_save_id = $van_selling_inventory_clearing_save->id;

                    $van_search = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();
                    $running_balace = $van_search->running_balance - round($request->input('vs_inventory_running_balance'), 2);
                    $outstanding_balance = $van_search->outstanding_balance - round($request->input('vs_inventory_running_balance'), 2);
                    $van_selling_ledger_save = new Van_selling_ar_ledger([
                        'customer_id' => $request->input('customer_id'),
                        'vs_inv_clear_id' => $van_selling_inventory_clearing_save_id,
                        'adjustments' => round($request->input('vs_inventory_running_balance'), 2) * -1,
                        'inventory_adjustments' => 0,
                        'cm_amount' => 0,
                        'price_update' => 0,
                        'actual_stocks_on_hand' => 0,
                        'charge_payment' => 0,
                        'amount' => 0,
                        'collection' => 0,
                        'over_short' => $van_search->over_short,
                        'running_balance' => $running_balace,
                        'outstanding_balance' => $outstanding_balance,
                        'should_be' => 0,
                        'user_id' => auth()->user()->id,
                        'date' => $date,
                        'remarks' => 'READY FOR TRANSFER OF INVENTORY',
                    ]);

                    $van_selling_ledger_save->save();

                    foreach ($request->input('sku_code') as $key => $data) {
                        $customer_id = $request->input('customer_id');
                        $clear_sku_ledger_data = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                        $van_selling_upload_ledger = new Van_selling_upload_ledger([
                            'customer_id' => $request->input('customer_id'),
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'sku_code' => $data,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'reference' => 'Transfer -' . $van_selling_inventory_clearing_save_id,
                            'beg' => $clear_sku_ledger_data[0]->end,
                            'van_load' => 0,
                            'sales' => 0,
                            'adjustments' => $clear_sku_ledger_data[0]->end * -1,
                            'end' => 0,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                            'total' => 0,
                            'running_balance' => 0,
                            'date' => $date,
                            'remarks' => 'cut_off_sku',
                        ]);

                        $van_selling_upload_ledger->save();

                        $van_selling_transfer_details_save = new Van_selling_transfer_inventory_details([
                            'vs_transfer_id' => $van_selling_transfer_save->id,
                            'sku_code' => $data,
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'quantity' => $clear_sku_ledger_data[0]->end,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                        ]);

                        $van_selling_transfer_details_save->save();
                    }

                    return 'saved';
                } else {
                    return 'access_denied';
                }
            } else {
                return 'access_denied';
            }
        } elseif ($request->input('transfer_type') == 'per_sku') {
            $user = User::select('position')->where('secret_key', $request->input('secret_key'))->first();
            if ($user) {
                if ($user->position == 'System_admin' or $user->position == 'Audit_staff' or $user->position == 'Audit_head') {
                    $van_selling_transfer_save = new Van_selling_transfer_inventory([
                        'customer_id' => $request->input('customer_id'),
                        'transfered_amount' => $request->input('vs_inventory_running_balance'),
                        'user_id' => auth()->user()->id,
                        'status' => 'NOT_YET_TRANSFERED',
                        'date' => $date,
                    ]);

                    $van_selling_transfer_save->save();

                    $van_selling_inventory_clearing_save = new Van_selling_inventory_clearing([
                        'customer_id' => $request->input('customer_id'),
                        'vs_ar_ending_balance' => $request->input('outstanding_balance'),
                        'vs_inventory_running_balance' => $request->input('vs_inventory_running_balance'),
                        'adjustments' => 0,
                        'total_adjustments' => round($request->input('vs_inventory_running_balance'), 2) * -1,
                        'date' => $date,
                    ]);

                    $van_selling_inventory_clearing_save->save();
                    $van_selling_inventory_clearing_save_id = $van_selling_inventory_clearing_save->id;

                    $van_search = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();
                    $running_balace = $van_search->running_balance - round($request->input('vs_inventory_running_balance'), 2);
                    $outstanding_balance = $van_search->outstanding_balance - round($request->input('vs_inventory_running_balance'), 2);
                    $van_selling_ledger_save = new Van_selling_ar_ledger([
                        'customer_id' => $request->input('customer_id'),
                        'vs_inv_clear_id' => $van_selling_inventory_clearing_save_id,
                        'adjustments' => round($request->input('vs_inventory_running_balance'), 2) * -1,
                        'inventory_adjustments' => 0,
                        'cm_amount' => 0,
                        'price_update' => 0,
                        'actual_stocks_on_hand' => 0,
                        'charge_payment' => 0,
                        'amount' => 0,
                        'collection' => 0,
                        'over_short' => $van_search->over_short,
                        'running_balance' => $running_balace,
                        'outstanding_balance' => $outstanding_balance,
                        'should_be' => 0,
                        'user_id' => auth()->user()->id,
                        'date' => $date,
                        'remarks' => 'READY FOR TRANSFER OF INVENTORY',
                    ]);

                    $van_selling_ledger_save->save();

                    foreach ($request->input('sku_code') as $key => $data) {
                        $customer_id = $request->input('customer_id');
                        $clear_sku_ledger_data = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                        $van_selling_upload_ledger = new Van_selling_upload_ledger([
                            'customer_id' => $request->input('customer_id'),
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'sku_code' => $data,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'reference' => 'Transfer -' . $van_selling_inventory_clearing_save_id,
                            'beg' => $clear_sku_ledger_data[0]->end,
                            'van_load' => 0,
                            'sales' => 0,
                            'adjustments' => $clear_sku_ledger_data[0]->end * -1,
                            'end' => 0,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                            'total' => 0,
                            'running_balance' => 0,
                            'date' => $date,
                            'remarks' => 'cut_off_sku',
                        ]);

                        $van_selling_upload_ledger->save();

                        $van_selling_transfer_details_save = new Van_selling_transfer_inventory_details([
                            'vs_transfer_id' => $van_selling_transfer_save->id,
                            'sku_code' => $data,
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'quantity' => $clear_sku_ledger_data[0]->end,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                        ]);

                        $van_selling_transfer_details_save->save();
                    }

                    return 'saved';
                } else {
                    return 'access_denied';
                }
            } else {
                return 'access_denied';
            }
        } else {
            $user = User::select('position')->where('secret_key', $request->input('secret_key'))->first();
            if ($user) {
                if ($user->position == 'System_admin' or $user->position == 'Audit_staff' or $user->position == 'Audit_head') {

                    $van_selling_transfer_save = new Van_selling_transfer_inventory([
                        'customer_id' => $request->input('customer_id'),
                        'transfered_amount' => $request->input('vs_inventory_running_balance'),
                        'user_id' => auth()->user()->id,
                        'status' => 'NOT_YET_TRANSFERED',
                        'date' => $date,
                    ]);

                    $van_selling_transfer_save->save();

                    $van_selling_inventory_clearing_save = new Van_selling_inventory_clearing([
                        'customer_id' => $request->input('customer_id'),
                        'vs_ar_ending_balance' => $request->input('vs_ar_ending_balance'),
                        'vs_inventory_running_balance' => $request->input('vs_inventory_running_balance'),
                        'adjustments' => $request->input('vs_add_adjustments'),
                        'total_adjustments' => round($request->input('vs_total_adjustments'), 2) * -1,
                        'date' => $date,
                    ]);

                    $van_selling_inventory_clearing_save->save();
                    $van_selling_inventory_clearing_save_id = $van_selling_inventory_clearing_save->id;

                    $van_search = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();
                    $running_balace = round($request->input('vs_total_adjustments'), 2) - $van_search->running_balance;
                    $van_selling_ledger_save = new Van_selling_ar_ledger([
                        'customer_id' => $request->input('customer_id'),
                        'vs_inv_clear_id' => $van_selling_inventory_clearing_save_id,
                        'adjustments' => round($request->input('vs_total_adjustments'), 2) * -1,
                        'inventory_adjustments' => 0,
                        'cm_amount' => 0,
                        'price_update' => 0,
                        'actual_stocks_on_hand' => 0,
                        'charge_payment' => 0,
                        'amount' => 0,
                        'collection' => 0,
                        'over_short' => $van_search->over_short,
                        'running_balance' => $running_balace,
                        'should_be' => 0,
                        'user_id' => auth()->user()->id,
                        'date' => $date,
                        'remarks' => 'READY FOR TRANSFER OF INVENTORY',
                    ]);

                    $van_selling_ledger_save->save();

                    foreach ($request->input('sku_code') as $key => $data) {
                        $customer_id = $request->input('customer_id');
                        $clear_sku_ledger_data = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                        $van_selling_upload_ledger = new Van_selling_upload_ledger([
                            'customer_id' => $request->input('customer_id'),
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'sku_code' => $data,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'reference' => 'Transfer -' . $van_selling_inventory_clearing_save_id,
                            'beg' => $clear_sku_ledger_data[0]->end,
                            'van_load' => 0,
                            'sales' => 0,
                            'adjustments' => $clear_sku_ledger_data[0]->end * -1,
                            'end' => 0,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                            'total' => 0,
                            'running_balance' => 0,
                            'date' => $date,
                            'remarks' => 'cut_off_sku',
                        ]);

                        $van_selling_upload_ledger->save();

                        $van_selling_transfer_details_save = new Van_selling_transfer_inventory_details([
                            'vs_transfer_id' => $van_selling_transfer_save->id,
                            'sku_code' => $data,
                            'principal' => $clear_sku_ledger_data[0]->principal,
                            'description' => $clear_sku_ledger_data[0]->description,
                            'sku_type' => $clear_sku_ledger_data[0]->sku_type,
                            'butal_equivalent' => $clear_sku_ledger_data[0]->butal_equivalent,
                            'unit_of_measurement' => $clear_sku_ledger_data[0]->unit_of_measurement,
                            'quantity' => $clear_sku_ledger_data[0]->end,
                            'unit_price' => $clear_sku_ledger_data[0]->unit_price,
                        ]);

                        $van_selling_transfer_details_save->save();
                    }

                    return 'saved';
                } else {
                    return 'access_denied';
                }
            } else {
                return 'access_denied';
            }
        }
    }
}
