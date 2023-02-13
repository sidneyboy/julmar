<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_category;
use App\Sku_principal;
use App\Sku_add;
use DB;
use App\Sku_ledger;

use Illuminate\Http\Request;

class Sku_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $sku_category = Sku_category::select('id', 'category')->get();
            $sku_principal = Sku_principal::select('id', 'principal')->get();
            return view('sku_ledger', [
                'user' => $user,
                'sku_category' => $sku_category,
                'sku_principal' => $sku_principal,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_ledger',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function search_inventory_ledger(Request $request)
    {
        
        $var = explode('-', $request->input('date_as_of'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        if ($request->input('search_method') == 'principal') {
            $search_principal = Sku_principal::select('id')->where('principal', $request->input('search_for'))->first();


            if ($search_principal) {
                $select_ledger_sku = Sku_ledger::select('sku_id')->where('principal_id', $search_principal->id)->groupBy('sku_id')->whereBetween('transaction_date', [$date_from, $date_to])->get();
                foreach ($select_ledger_sku as $key => $value) {
                    $sku_id = $value->sku_id;
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                    $count_ledger_row[] = count($ledger_results);

                    $in_out_adjustments[] = $ledger_results[0]->in_out_adjustments;
                    $rr_dr[] = $ledger_results[0]->rr_dr;
                    $sales_order_number[] = $ledger_results[0]->sales_order_number;
                    $principal_invoice[] = $ledger_results[0]->principal_invoice;
                    $quantity[] = $ledger_results[0]->quantity;
                    $running_balance[] = $ledger_results[0]->running_balance;
                    $unit_cost[] = $ledger_results[0]->unit_cost;
                    $total_cost[] = $ledger_results[0]->total_cost;
                    $adjustments[] = $ledger_results[0]->adjustments;
                    $running_total_cost[] = $ledger_results[0]->running_total_cost;
                    $final_unit_cost[] = $ledger_results[0]->final_unit_cost;
                    $transaction_date[] = $ledger_results[0]->transaction_date;
                }

                if (isset($count_ledger_row) or isset($in_out_adjustments) or isset($rr_dr) or isset($sales_order_number) or isset($principal_invoice) or isset($quantity) or isset($running_balance) or isset($unit_cost) or isset($total_cost) or isset($adjustments) or isset($running_total_cost) or isset($final_unit_cost) or isset($final_unit_cost) or isset($user_id) or isset($transaction_date)) {
                    $counter = array_sum($count_ledger_row);
                } else {
                    $counter = 0;
                    $in_out_adjustments[] = 0;
                    $rr_dr[] = 0;
                    $sales_order_number[] = 0;
                    $principal_invoice[] = 0;
                    $quantity[] = 0;
                    $running_balance[] = 0;
                    $unit_cost[] = 0;
                    $total_cost[] = 0;
                    $adjustments[] = 0;
                    $running_total_cost[] = 0;
                    $final_unit_cost[] = 0;
                    $transaction_date[] = 0;
                }

                return view('sku_ledger_show_data')->with('counter', $counter)
                    ->with('in_out_adjustments', $in_out_adjustments)
                    ->with('rr_dr', $rr_dr)
                    ->with('sales_order_number', $sales_order_number)
                    ->with('principal_invoice', $principal_invoice)
                    ->with('quantity', $quantity)
                    ->with('running_balance', $running_balance)
                    ->with('unit_cost', $unit_cost)
                    ->with('total_cost', $total_cost)
                    ->with('adjustments', $adjustments)
                    ->with('running_total_cost', $running_total_cost)
                    ->with('final_unit_cost', $final_unit_cost)
                    ->with('transaction_date', $transaction_date)
                    ->with('select_ledger_sku', $select_ledger_sku)
                    ->with('date_from', $date_from)
                    ->with('date_to', $date_to)
                    ->with('search_method', $request->input('search_method'));
            } else {
                return 'no_data';
            }
        } elseif ($request->input('search_method') == 'sku_code') {
            // return $request->input();
            $search_sku = Sku_add::where('sku_code', $request->input('search_for'))->get();
            $counter = count($search_sku);

            if ($counter != 0) {
                foreach ($search_sku as $key => $data) {
                    $sku_id = $data->id;
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                    $count_ledger_row[] = count($ledger_results);




                    if (empty($ledger_results)) {
                        // $counter = 0;
                        $in_out_adjustments[] = 'no data';
                        $rr_dr[] = 'no data';
                        $sales_order_number[] = 'no data';
                        $principal_invoice[] = 'no data';
                        $quantity[] = 'no data';
                        $running_balance[] = 'no data';
                        $unit_cost[] = 0;
                        $total_cost[] = 0;
                        $adjustments[] = 0;
                        $running_total_cost[] = 0;
                        $final_unit_cost[] = 0;
                        $transaction_date[] = 0;
                    } else {
                        $in_out_adjustments[] = $ledger_results[0]->in_out_adjustments;
                        $rr_dr[] = $ledger_results[0]->rr_dr;
                        $sales_order_number[] = $ledger_results[0]->sales_order_number;
                        $principal_invoice[] = $ledger_results[0]->principal_invoice;
                        $quantity[] = $ledger_results[0]->quantity;
                        $running_balance[] = $ledger_results[0]->running_balance;
                        $unit_cost[] = $ledger_results[0]->unit_cost;
                        $total_cost[] = $ledger_results[0]->total_cost;
                        $adjustments[] = $ledger_results[0]->adjustments;
                        $running_total_cost[] = $ledger_results[0]->running_total_cost;
                        $final_unit_cost[] = $ledger_results[0]->final_unit_cost;
                        $transaction_date[] = $ledger_results[0]->transaction_date;
                        // $counter = array_sum($count_ledger_row);
                    }
                }

                return view('sku_ledger_show_data')->with('counter', $counter)
                    ->with('in_out_adjustments', $in_out_adjustments)
                    ->with('rr_dr', $rr_dr)
                    ->with('sales_order_number', $sales_order_number)
                    ->with('principal_invoice', $principal_invoice)
                    ->with('quantity', $quantity)
                    ->with('running_balance', $running_balance)
                    ->with('unit_cost', $unit_cost)
                    ->with('total_cost', $total_cost)
                    ->with('adjustments', $adjustments)
                    ->with('running_total_cost', $running_total_cost)
                    ->with('final_unit_cost', $final_unit_cost)
                    ->with('transaction_date', $transaction_date)
                    ->with('search_sku', $search_sku)
                    ->with('date_from', $date_from)
                    ->with('date_to', $date_to)
                    ->with('search_method', $request->input('search_method'));
            } else {
                return 'no_data';
            }
        } elseif ($request->input('search_method') == 'type') {

            $select_ledger_sku = Sku_ledger::select('sku_id')->where('sku_type', $request->input('search_for'))->groupBy('sku_id')->whereBetween('transaction_date', [$date_from, $date_to])->get();
            $counter = count($select_ledger_sku);

            if ($counter != 0) {

                foreach ($select_ledger_sku as $key => $value) {
                    $sku_id = $value->sku_id;
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                    $count_ledger_row[] = count($ledger_results);

                    $in_out_adjustments[] = $ledger_results[0]->in_out_adjustments;
                    $rr_dr[] = $ledger_results[0]->rr_dr;
                    $sales_order_number[] = $ledger_results[0]->sales_order_number;
                    $principal_invoice[] = $ledger_results[0]->principal_invoice;
                    $quantity[] = $ledger_results[0]->quantity;
                    $running_balance[] = $ledger_results[0]->running_balance;
                    $unit_cost[] = $ledger_results[0]->unit_cost;
                    $total_cost[] = $ledger_results[0]->total_cost;
                    $adjustments[] = $ledger_results[0]->adjustments;
                    $running_total_cost[] = $ledger_results[0]->running_total_cost;
                    $final_unit_cost[] = $ledger_results[0]->final_unit_cost;
                    $transaction_date[] = $ledger_results[0]->transaction_date;
                }

                if (isset($count_ledger_row) or isset($in_out_adjustments) or isset($rr_dr) or isset($sales_order_number) or isset($principal_invoice) or isset($quantity) or isset($running_balance) or isset($unit_cost) or isset($total_cost) or isset($adjustments) or isset($running_total_cost) or isset($final_unit_cost) or isset($final_unit_cost) or isset($user_id) or isset($transaction_date)) {
                    $counter = array_sum($count_ledger_row);
                } else {
                    $counter = 0;
                    $in_out_adjustments[] = 0;
                    $rr_dr[] = 0;
                    $sales_order_number[] = 0;
                    $principal_invoice[] = 0;
                    $quantity[] = 0;
                    $running_balance[] = 0;
                    $unit_cost[] = 0;
                    $total_cost[] = 0;
                    $adjustments[] = 0;
                    $running_total_cost[] = 0;
                    $final_unit_cost[] = 0;
                    $transaction_date[] = 0;
                }

                return view('sku_ledger_show_data')->with('counter', $counter)
                    ->with('in_out_adjustments', $in_out_adjustments)
                    ->with('rr_dr', $rr_dr)
                    ->with('sales_order_number', $sales_order_number)
                    ->with('principal_invoice', $principal_invoice)
                    ->with('quantity', $quantity)
                    ->with('running_balance', $running_balance)
                    ->with('unit_cost', $unit_cost)
                    ->with('total_cost', $total_cost)
                    ->with('adjustments', $adjustments)
                    ->with('running_total_cost', $running_total_cost)
                    ->with('final_unit_cost', $final_unit_cost)
                    ->with('transaction_date', $transaction_date)
                    ->with('select_ledger_sku', $select_ledger_sku)
                    ->with('date_from', $date_from)
                    ->with('date_to', $date_to)
                    ->with('search_method', $request->input('search_method'));
            } else {
                return 'no_data';
            }
        } elseif ($request->input('search_method') == 'category') {
            $select_category = Sku_category::select('id')->where('category', $request->input('search_for'))->first();

            if ($select_category) {
                $select_ledger_sku = Sku_ledger::select('sku_id')->where('category_id', $select_category->id)->groupBy('sku_id')->whereBetween('transaction_date', [$date_from, $date_to])->get();
                $counter = count($select_ledger_sku);

                foreach ($select_ledger_sku as $key => $value) {
                    $sku_id = $value->sku_id;
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                    $count_ledger_row[] = count($ledger_results);

                    $in_out_adjustments[] = $ledger_results[0]->in_out_adjustments;
                    $rr_dr[] = $ledger_results[0]->rr_dr;
                    $sales_order_number[] = $ledger_results[0]->sales_order_number;
                    $principal_invoice[] = $ledger_results[0]->principal_invoice;
                    $quantity[] = $ledger_results[0]->quantity;
                    $running_balance[] = $ledger_results[0]->running_balance;
                    $unit_cost[] = $ledger_results[0]->unit_cost;
                    $total_cost[] = $ledger_results[0]->total_cost;
                    $adjustments[] = $ledger_results[0]->adjustments;
                    $running_total_cost[] = $ledger_results[0]->running_total_cost;
                    $final_unit_cost[] = $ledger_results[0]->final_unit_cost;
                    $transaction_date[] = $ledger_results[0]->transaction_date;
                }

                if (isset($count_ledger_row) or isset($in_out_adjustments) or isset($rr_dr) or isset($sales_order_number) or isset($principal_invoice) or isset($quantity) or isset($running_balance) or isset($unit_cost) or isset($total_cost) or isset($adjustments) or isset($running_total_cost) or isset($final_unit_cost) or isset($final_unit_cost) or isset($user_id) or isset($transaction_date)) {
                    $counter = array_sum($count_ledger_row);
                } else {
                    $counter = 0;
                    $in_out_adjustments[] = 0;
                    $rr_dr[] = 0;
                    $sales_order_number[] = 0;
                    $principal_invoice[] = 0;
                    $quantity[] = 0;
                    $running_balance[] = 0;
                    $unit_cost[] = 0;
                    $total_cost[] = 0;
                    $adjustments[] = 0;
                    $running_total_cost[] = 0;
                    $final_unit_cost[] = 0;
                    $transaction_date[] = 0;
                }

                return view('sku_ledger_show_data')->with('counter', $counter)
                    ->with('in_out_adjustments', $in_out_adjustments)
                    ->with('rr_dr', $rr_dr)
                    ->with('sales_order_number', $sales_order_number)
                    ->with('principal_invoice', $principal_invoice)
                    ->with('quantity', $quantity)
                    ->with('running_balance', $running_balance)
                    ->with('unit_cost', $unit_cost)
                    ->with('total_cost', $total_cost)
                    ->with('adjustments', $adjustments)
                    ->with('running_total_cost', $running_total_cost)
                    ->with('final_unit_cost', $final_unit_cost)
                    ->with('transaction_date', $transaction_date)
                    ->with('select_ledger_sku', $select_ledger_sku)
                    ->with('date_from', $date_from)
                    ->with('date_to', $date_to)
                    ->with('search_method', $request->input('search_method'));
            } else {
                return 'no_data';
            }
        }
    }

    public function sku_ledger_show_sku_details($id)
    {


        $variable_explode = explode('=', $id);
        $sku_id = $variable_explode[0];
        $date_from = $variable_explode[1];
        $date_to = $variable_explode[2];

        $sku_ledger_details = Sku_ledger::select('sku_id', 'in_out_adjustments', 'rr_dr', 'sales_order_number', 'principal_invoice', 'quantity', 'running_balance', 'unit_cost', 'total_cost', 'adjustments', 'running_total_cost', 'final_unit_cost', 'transaction_date', 'user_id')->where('sku_id', $sku_id)->whereBetween('transaction_date', [$date_from, $date_to])->get();

        $counter = count($sku_ledger_details);

        return view('sku_ledger_show_sku_details', [
            'sku_ledger_details' => $sku_ledger_details
        ])->with('date_from', $date_from)
            ->with('date_to', $date_to)
            ->with('counter', $counter);
    }
}
