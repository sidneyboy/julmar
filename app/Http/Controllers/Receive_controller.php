<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\Chart_of_accounts_details;
use App\General_ledger;
use App\Principal_ledger;
use App\Purchase_order;
use App\Purchase_order_details;
use App\Received_purchase_order;
use App\Principal_discount_details;
use App\Received_jer;
use App\Received_purchase_order_details;
use App\Receiving_draft;
use App\Receiving_draft_main;
use App\Sku_ledger;
use App\Received_discount_details;
use App\Received_other_discount_details;
use App\Purchase_order_discount_details;
use App\Sku_price_details;
use App\Sku_principal;
use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class Receive_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_purchase_order_id = Received_purchase_order::select('id')->orderBy('id', 'desc', 'van_number')->first();
            if ($received_purchase_order_id == NULL) {
                $id = 1;
            } else {
                $id = $received_purchase_order_id->id + 1;
            }

            $draft = Receiving_draft_main::where('status', null)->orderBy('id', 'desc')->get();
            return view('receive_order', [
                'user' => $user,
                'draft' => $draft,
                'id' => $id,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'receive_order',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }


    public function receive_order_generate_data(Request $request)
    {
        $variable_explode = explode('=', $request->input('purchase_id'));
        $session_id = $variable_explode[0];
        $purchase_order_id = $variable_explode[1];
        $principal_name = $variable_explode[2];
        $purchase_id = $variable_explode[3];
        $principal_id = $variable_explode[4];


        $purchase_order = Purchase_order::select('id', 'discount_type', 'bo_allowance_discount_rate', 'cwo_discount_rate')->find($purchase_order_id);


        $purchase_order_details = Purchase_order_details::select('id', 'sku_id', 'confirmed_quantity', 'receive')->where('purchase_order_id', $purchase_order_id)
            ->orderBy('sku_id')
            ->get();



        $draft = Receiving_draft::select('sku_id', 'unit_cost', 'freight', 'user_id', 'quantity', 'session_id')->where('session_id', $session_id)->orderBy('sku_id')->get();


        return view('receive_order_show_data_summary', [
            'purchase_order' => $purchase_order,
            'purchase_order_details' => $purchase_order_details,
            'draft' => $draft
        ])->with('dr_si', $request->input('dr_si'))
            ->with('truck_number', $request->input('truck_number'))
            ->with('courier', $request->input('courier'))
            ->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name)
            ->with('session_id', $session_id)
            ->with('purchase_id', $purchase_id)
            ->with('purchase_order_id', $purchase_order_id)
            ->with('invoice_date', $request->input('invoice_date'))
            ->with('branch', $request->input('branch'));
    }

    public function receive_order_data_final_summary(Request $request)
    {

        //return $request->input();
        $unit_cost = str_replace(',', '', $request->input('unit_cost'));
        $discount_selected = Purchase_order_discount_details::select('discount_name', 'discount_rate')->whereIn('id', $request->input('discount_selected'))->get();
        $get_principal = Sku_principal::select('principal')->find($request->input('principal_id'));

        $get_merchandise_inventory = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'MERCHANDISE INVENTORY - ' . $get_principal->principal)
            ->where('principal_id', $request->input('principal_id'))
            ->first();

        $get_accounts_payable = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'ACCOUNTS PAYABLE - ' . $get_principal->principal)
            ->where('principal_id', $request->input('principal_id'))
            ->first();

        if ($get_merchandise_inventory && $get_accounts_payable) {
            $check_less_other_discounts = $request->input('less_other_discount_selected');
            if (isset($check_less_other_discounts)) {
                $less_other_discount_selected = Principal_discount_details::select('discount_name', 'discount_rate')->whereIn('id', $request->input('less_other_discount_selected'))->get();

                return view('receive_order_show_data_final_summary')
                    ->with('sku_id', $request->input('sku_id'))
                    ->with('discount_type', $request->input('discount_type'))
                    ->with('bo_allowance_discount_selected', $request->input('bo_allowance_discount_selected'))
                    ->with('cwo_discount_selected', $request->input('cwo_discount_selected'))
                    ->with('less_other_discount_selected', $less_other_discount_selected)
                    ->with('discount_selected', $discount_selected)
                    ->with('sku_type', $request->input('sku_type'))
                    ->with('received_quantity', $request->input('received_quantity'))
                    ->with('remarks', $request->input('remarks'))
                    ->with('sku_code', $request->input('sku_code'))
                    ->with('description', $request->input('description'))
                    ->with('quantity', $request->input('quantity'))
                    ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                    ->with('principal_name', $request->input('principal_name'))
                    ->with('principal_id', $request->input('principal_id'))
                    ->with('purchase_order_id', $request->input('purchase_order_id'))
                    ->with('truck_number', $request->input('truck_number'))
                    ->with('dr_si', $request->input('dr_si'))
                    ->with('courier', $request->input('courier'))
                    ->with('purchase_id', $request->input('purchase_id'))
                    ->with('expiration_date', $request->input('expiration_date'))
                    ->with('unit_cost', $unit_cost)
                    ->with('freight', $request->input('freight'))
                    ->with('invoice_date', $request->input('invoice_date'))
                    ->with('remarks', $request->input('remarks'))
                    ->with('branch', $request->input('branch'))
                    ->with('scanned_by', $request->input('scanned_by'))
                    ->with('draft_session_id', $request->input('draft_session_id'))
                    ->with('get_accounts_payable', $get_accounts_payable)
                    ->with('get_merchandise_inventory', $get_merchandise_inventory);
            } else {
                return view('receive_order_show_data_final_summary')
                    ->with('sku_id', $request->input('sku_id'))
                    ->with('discount_type', $request->input('discount_type'))
                    ->with('bo_allowance_discount_selected', $request->input('bo_allowance_discount_selected'))
                    ->with('cwo_discount_selected', $request->input('cwo_discount_selected'))
                    ->with('discount_selected', $discount_selected)
                    ->with('sku_type', $request->input('sku_type'))
                    ->with('received_quantity', $request->input('received_quantity'))
                    ->with('remarks', $request->input('remarks'))
                    ->with('sku_code', $request->input('sku_code'))
                    ->with('description', $request->input('description'))
                    ->with('quantity', $request->input('quantity'))
                    ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                    ->with('principal_name', $request->input('principal_name'))
                    ->with('principal_id', $request->input('principal_id'))
                    ->with('purchase_order_id', $request->input('purchase_order_id'))
                    ->with('truck_number', $request->input('truck_number'))
                    ->with('dr_si', $request->input('dr_si'))
                    ->with('courier', $request->input('courier'))
                    ->with('purchase_id', $request->input('purchase_id'))
                    ->with('expiration_date', $request->input('expiration_date'))
                    ->with('unit_cost', $unit_cost)
                    ->with('freight', $request->input('freight'))
                    ->with('invoice_date', $request->input('invoice_date'))
                    ->with('remarks', $request->input('remarks'))
                    ->with('branch', $request->input('branch'))
                    ->with('scanned_by', $request->input('scanned_by'))
                    ->with('draft_session_id', $request->input('draft_session_id'))
                    ->with('get_accounts_payable', $get_accounts_payable)
                    ->with('get_merchandise_inventory', $get_merchandise_inventory);
            }
        } else {
            return 'No chart of account';
        }
    }


    public function received_order_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $get_general_merchandise = General_ledger::select('running_balance')
            ->where('account_name', $request->input('merchandise_inventory_account_name'))
            ->where('principal_id', $request->input('principal_id'))
            ->where('account_number', $request->input('merchandise_inventory_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_general_merchandise) {
            $running_balance = $get_general_merchandise->running_balance + $request->input('total_final_cost');

            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('merchandise_inventory_account_name'),
                'account_number' => $request->input('merchandise_inventory_account_number'),
                'debit_record' => $request->input('total_final_cost'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'RECEIVED SKU',
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('merchandise_inventory_account_name'),
                'account_number' => $request->input('merchandise_inventory_account_number'),
                'debit_record' => $request->input('total_final_cost'),
                'credit_record' => 0,
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                'running_balance' => $request->input('total_final_cost'),
                'transaction' => 'RECEIVED SKU',
            ]);

            $new_general_ledger->save();
        }

        $get_accounts_payable = General_ledger::select('running_balance')
            ->where('account_name', $request->input('accounts_payable_account_name'))
            ->where('principal_id', $request->input('principal_id'))
            ->where('account_number', $request->input('accounts_payable_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_accounts_payable) {
            $running_balance = $get_accounts_payable->running_balance + $request->input('total_final_cost');

            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('accounts_payable_account_name'),
                'account_number' => $request->input('accounts_payable_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('total_final_cost'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('accounts_payable_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'RECEIVED SKU',
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('accounts_payable_account_name'),
                'account_number' => $request->input('accounts_payable_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('total_final_cost'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('accounts_payable_general_account_number'),
                'running_balance' => $request->input('total_final_cost'),
                'transaction' => 'RECEIVED SKU',
            ]);

            $new_general_ledger->save();
        }


        $po = Purchase_order::select('purchase_id', 'payment_status')->find($request->input('purchase_order_id'));


        if ($po->payment_status == 'paid') {
            $new_received_purchase_orders = new Received_purchase_order([
                'bo_allowance_discount_rate' => $request->input('bo_allowance_discount_rate'),
                'discount_id' => $request->input('discount_id'),
                'principal_id' => $request->input('principal_id'),
                'purchase_order_id' => $request->input('purchase_order_id'),
                'dr_si' => $request->input('dr_si'),
                'truck_number' => $request->input('truck_number'),
                'courier' => $request->input('courier'),
                'invoice_date' => $request->input('invoice_date'),
                'discount_type' => $request->input('discount_type'),
                'scanned_by' => $request->input('scanned_by'),
                'finalized_by' => auth()->user()->id,
                'branch' => $request->input('branch'),
                'gross_purchase' => $request->input('gross_purchases'),
                'total_less_discount' => $request->input('total_less_discount'),
                'bo_discount' => $request->input('bo_discount'),
                'vatable_purchase' => $request->input('vatable_purchase'),
                'vat' => $request->input('vat'),
                'freight' => $request->input('freight'),
                'total_final_cost' => $request->input('total_final_cost'),
                'total_less_other_discount' => $request->input('total_less_other_discount'),
                'net_payable' => $request->input('net_payable'),
                'invoice_image' => 'No Sales Invoice Yet',
                'cwo_discount_rate' => $request->input('cwo_discount_rate'),
                'cwo_discount' => $request->input('cwo_discount'),
                'payment_status' => 'paid',
            ]);

            $new_received_purchase_orders->save();
        } else {
            $new_received_purchase_orders = new Received_purchase_order([
                'bo_allowance_discount_rate' => $request->input('bo_allowance_discount_rate'),
                'discount_id' => $request->input('discount_id'),
                'principal_id' => $request->input('principal_id'),
                'purchase_order_id' => $request->input('purchase_order_id'),
                'dr_si' => $request->input('dr_si'),
                'truck_number' => $request->input('truck_number'),
                'courier' => $request->input('courier'),
                'invoice_date' => $request->input('invoice_date'),
                'discount_type' => $request->input('discount_type'),
                'scanned_by' => $request->input('scanned_by'),
                'finalized_by' => auth()->user()->id,
                'branch' => $request->input('branch'),
                'gross_purchase' => $request->input('gross_purchases'),
                'total_less_discount' => $request->input('total_less_discount'),
                'bo_discount' => $request->input('bo_discount'),
                'vatable_purchase' => $request->input('vatable_purchase'),
                'vat' => $request->input('vat'),
                'freight' => $request->input('freight'),
                'total_final_cost' => $request->input('total_final_cost'),
                'total_less_other_discount' => $request->input('total_less_other_discount'),
                'net_payable' => $request->input('net_payable'),
                'invoice_image' => 'No Sales Invoice Yet',
                'cwo_discount_rate' => $request->input('cwo_discount_rate'),
                'cwo_discount' => $request->input('cwo_discount'),
            ]);

            $new_received_purchase_orders->save();
        }


        $ap_ledger_last_transaction = Ap_ledger::select('running_balance')->where('principal_id', $request->input('principal_id'))->orderBy('id', 'desc')->take(1)->first();

        if ($ap_ledger_last_transaction) {
            $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance + $request->input('total_final_cost');
        } else {
            $ap_ledger_running_balance = $request->input('total_final_cost');
        }
        $new_ap_ledger = new Ap_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transaction_date' => $request->input('invoice_date'),
            'description' => 'Received PO#: ' . $po->purchase_id,
            'debit_record' => 0,
            'credit_record' => $request->input('total_final_cost'),
            'running_balance' => $ap_ledger_running_balance,
            'transaction' => 'received',
            'reference' => $new_received_purchase_orders->id,
            'remarks' => '',
        ]);

        $new_ap_ledger->save();

        $check_less_other_discount_selected_name = $request->input('less_other_discount_selected_name');

        if (isset($check_less_other_discount_selected_name)) {
            for ($i = 0; $i < count($check_less_other_discount_selected_name); $i++) {
                $new_received_purchase_order_other_discount = new Received_other_discount_details([
                    'received_id' => $new_received_purchase_orders->id,
                    'discount_name' => $check_less_other_discount_selected_name[$i],
                    'discount_rate' => $request->input('less_other_discount_selected_rate')[$i],
                ]);

                $new_received_purchase_order_other_discount->save();
            }

            $received_jer_save = new Received_jer([
                'principal_id' => $request->input('principal_id'),
                'received_id' => $new_received_purchase_orders->id,
                'dr' => $request->input('net_payable'),
                'cr' => $request->input('net_payable'),
                'date' => $date
            ]);

            $received_jer_save->save();

            // $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            // if ($principal_ledger_latest) {
            //     $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new_received_purchase_orders->id,
            //         'transaction' => 'received',
            //         'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            //         'received' => $request->input('net_payable'),
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' => 0,
            //         'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('net_payable'),
            //     ]);

            //     $principal_ledger_saved->save();
            // } else {
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new_received_purchase_orders->id,
            //         'transaction' => 'received',
            //         'accounts_payable_beginning' => 0,
            //         'received' => $request->input('net_payable'),
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' => 0,
            //         'accounts_payable_end' => $request->input('net_payable'),
            //     ]);

            //     $principal_ledger_saved->save();
            // }
        } else {
            $received_jer_save = new Received_jer([
                'principal_id' => $request->input('principal_id'),
                'received_id' => $new_received_purchase_orders->id,
                'dr' => $request->input('total_final_cost'),
                'cr' => $request->input('total_final_cost'),
                'date' => $date
            ]);

            $received_jer_save->save();

            // $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            // if ($principal_ledger_latest) {
            //     $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new_received_purchase_orders->id,
            //         'transaction' => 'received',
            //         'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            //         'received' => $request->input('total_final_cost'),
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' => 0,
            //         'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('total_final_cost'),
            //     ]);

            //     $principal_ledger_saved->save();
            // } else {
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new_received_purchase_orders->id,
            //         'transaction' => 'received',
            //         'accounts_payable_beginning' => 0,
            //         'received' => $request->input('total_final_cost'),
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' => 0,
            //         'accounts_payable_end' => $request->input('total_final_cost'),
            //     ]);

            //     $principal_ledger_saved->save();
            // }
        }

        for ($i = 0; $i < count($request->input('discount_selected_name')); $i++) {
            $new_received_purchase_order_discount = new Received_discount_details([
                'received_id' => $new_received_purchase_orders->id,
                'discount_name' => $request->input('discount_selected_name')[$i],
                'discount_rate' => $request->input('discount_selected_rate')[$i],
            ]);

            $new_received_purchase_order_discount->save();
        }

        foreach ($request->input('sku_id') as $key => $data) {
            if ($request->input('received_quantity')[$data] != 0) {
                $new_received_purchase_order_details = new Received_purchase_order_details([
                    'received_id' => $new_received_purchase_orders->id,
                    'sku_id' => $data,
                    'quantity' => $request->input('received_quantity')[$data],
                    'unit_cost' => $request->input('unit_cost')[$data],
                    'freight' => str_replace('', '', $request->input('freight_per_sku')[$data]),
                    'final_unit_cost' => $request->input('final_unit_cost')[$data],
                ]);

                $new_received_purchase_order_details->save();

                $price_details_checker = Sku_price_details::select('id')
                    ->where('sku_id', $data)
                    ->count();

                if ($price_details_checker != 0) {
                    Sku_price_details::where('sku_id', $data)
                        ->update([
                            'unit_cost' => $request->input('unit_cost')[$data],
                            'final_unit_cost' => $request->input('final_unit_cost')[$data],
                        ]);
                } else {
                    $new_price_details = new Sku_price_details([
                        'sku_id' => $data,
                        'unit_cost' => $request->input('unit_cost')[$data],
                        'price_1' => 0,
                        'price_2' => 0,
                        'price_3' => 0,
                        'price_4' => 0,
                        'price_5' => 0,
                        'final_unit_cost' => $request->input('final_unit_cost')[$data],
                    ]);

                    $new_price_details->save();
                }


                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
                $count_ledger_row = count($ledger_results);

                if ($count_ledger_row > 0) {
                    $running_balance = $ledger_results[0]->running_balance + $request->input('received_quantity')[$data];
                    $running_amount = $ledger_results[0]->running_amount + $request->input('final_total_cost_per_sku')[$data];
                    $with_invoice_quantity = $ledger_results[0]->with_invoice_quantity;
                    $with_invoice_net_balance = $ledger_results[0]->with_invoice_net_balance;
                    $new_sku_ledger = new Sku_ledger([
                        'sku_id' => $data,
                        'quantity' => $request->input('received_quantity')[$data],
                        'running_balance' => $running_balance,
                        'user_id' => auth()->user()->id,
                        'transaction_type' => 'received',
                        'all_id' => $new_received_purchase_orders->id,
                        'principal_id' => $request->input('principal_id'),
                        'sku_type' => $request->input('sku_type'),
                        'final_unit_cost' => $request->input('final_unit_cost')[$data],
                        'amount' => $request->input('final_total_cost_per_sku')[$data],
                        'running_amount' => $running_amount,
                        'with_invoice_quantity' => $with_invoice_quantity,
                        'with_invoice_net_balance' => $with_invoice_net_balance,
                    ]);

                    $new_sku_ledger->save();
                } else {
                    $with_invoice_quantity = 0;
                    $with_invoice_net_balance = 0;
                    $new_sku_ledger = new Sku_ledger([
                        'sku_id' => $data,
                        'quantity' => $request->input('received_quantity')[$data],
                        'running_balance' => $request->input('received_quantity')[$data],
                        'user_id' => auth()->user()->id,
                        'transaction_type' => 'received',
                        'all_id' => $new_received_purchase_orders->id,
                        'principal_id' => $request->input('principal_id'),
                        'sku_type' => $request->input('sku_type'),
                        'final_unit_cost' => $request->input('final_unit_cost')[$data],
                        'amount' => $request->input('final_total_cost_per_sku')[$data],
                        'running_amount' => $request->input('final_total_cost_per_sku')[$data],
                        'with_invoice_quantity' => $request->input('received_quantity')[$data],
                        'with_invoice_net_balance' => $request->input('received_quantity')[$data],
                    ]);

                    $new_sku_ledger->save();
                }

                $update_purchase_order_details = Purchase_order_details::select('id', 'confirmed_quantity', 'receive')->where('purchase_order_id', $request->input('purchase_order_id'))->where('sku_id', $data)->first();

                $update_received = $update_purchase_order_details->receive + $request->input('received_quantity')[$data];
                if ($update_received == $update_purchase_order_details->confirmed_quantity) {
                    $update_purchase_order_details->receive = $update_received;
                    $update_purchase_order_details->remarks = 'received';
                    $update_purchase_order_details->scanned_remarks = null;
                    $update_purchase_order_details->save();
                } else {
                    $update_purchase_order_details->receive = $update_received;
                    $update_purchase_order_details->remarks = 'staggered';
                    $update_purchase_order_details->scanned_remarks = null;
                    $update_purchase_order_details->save();
                }
            }
        }

        $check_purchase_order_details = Purchase_order_details::select('confirmed_quantity', 'receive')->where('purchase_order_id', $request->input('purchase_order_id'))
            ->get();

        foreach ($check_purchase_order_details as $key => $check_for_update) {
            if ($check_for_update->confirmed_quantity > $check_for_update->receive) {
                $checker_for_update_data[] = $check_for_update->confirmed_quantity;
            } else {
                $checker_for_update_data[] = 0;
            }
        }

        if (array_sum($checker_for_update_data) > 0) {
            $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
            $update_purchase_order->remarks = 'staggered';
            $update_purchase_order->status = 'staggered';
            $update_purchase_order->save();
        } else {
            $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
            $update_purchase_order->remarks = 'received';
            $update_purchase_order->status = 'completed';
            $update_purchase_order->save();
        }

        Receiving_draft_main::where('session_id', $request->input('draft_session_id'))
            ->update(['status' => 'completed']);

        return 'saved';
    }
}
