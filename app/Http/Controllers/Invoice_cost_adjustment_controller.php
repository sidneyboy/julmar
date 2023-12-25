<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\Chart_of_accounts_details;
use App\General_ledger;
use App\Received_purchase_order;
use App\Sku_principal;
use App\Invoice_cost_adjustments;
use App\Invoice_cost_adjustment_details;
use App\Invoice_cost_adjustments_jer;
use DB;
use App\Sku_ledger;
use App\Principal_ledger;
use App\User;
use App\Principal_discount;
use App\Principal_discount_details;
use App\Received_purchase_order_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Invoice_cost_adjustment_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_data = Received_purchase_order::select('id', 'principal_id', 'purchase_order_id')->orderBy('id', 'desc')->get();
            return view('invoice_cost_adjustments', [
                'user' => $user,
                'received_data' => $received_data,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'invoice_cost_adjustments',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_cost_adjustments_input(Request $request)
    {
        $variable_explode = explode('=', $request->input('received_id'));
        $received_id = $variable_explode[0];
        $principal_id = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $dr_si = $variable_explode[3];
        $sku_add_details = Received_purchase_order_details::where('received_id', $received_id)->get();
        $principal_name = Sku_principal::where('id', $principal_id)->first();
        return view('invoice_cost_adjustment_input', [
            'sku_add_details' => $sku_add_details
        ])->with('received_id', $received_id)
            ->with('principal_name', $principal_name->principal)
            ->with('principal_id', $principal_id)
            ->with('purchase_id', $purchase_id)
            ->with('dr_si', $dr_si);
    }

    public function invoice_cost_adjustments_show_summary(Request $request)
    {
        //return $request->input();
        $received_purchase_order = Received_purchase_order::find($request->input('received_id'));

        $get_principal = Sku_principal::select('principal')->find($received_purchase_order->principal_id);

        $get_merchandise_inventory = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'MERCHANDISE INVENTORY - ' . $get_principal->principal)
            ->where('principal_id', $received_purchase_order->principal_id)
            ->first();

        $get_accounts_payable = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'ACCOUNTS PAYABLE - ' . $get_principal->principal)
            ->where('principal_id', $received_purchase_order->principal_id)
            ->first();

        if ($get_merchandise_inventory && $get_accounts_payable) {
            return view('invoice_cost_adjustments_summary', [
                'received_purchase_order' => $received_purchase_order,
                'get_merchandise_inventory' => $get_merchandise_inventory,
                'get_accounts_payable' => $get_accounts_payable,
            ])->with('checkbox_entry', $request->input('checkbox_entry'))
                ->with('unit_cost', $request->input('unit_cost'))
                ->with('transaction_date', $request->input('transaction_date'))
                ->with('freight', $request->input('freight'))
                ->with('unit_cost_adjustment', $request->input('unit_cost_adjustment'))
                ->with('particulars', $request->input('particulars'))
                ->with('code', $request->input('code'))
                ->with('description', $request->input('description'))
                ->with('quantity', $request->input('quantity'))
                ->with('received_id', $request->input('received_id'))
                ->with('new_freight', $request->input('new_freight'));
        } else {
            return 'No chart of accounts';
        }
    }

    public function invoice_cost_adjustments_save(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        //return $request->input();



        $new_invoice_cost_adjustment = new Invoice_cost_adjustments([
            'principal_id' => $request->input('principal_id'),
            'received_id' => $request->input('received_id'),
            'particulars' => $request->input('particulars'),
            'gross_purchase' => $request->input('gross_purchases'),
            'total_less_discount' => $request->input('total_less_discount'),
            'bo_discount' => $request->input('bo_discount'),
            'vatable_purchase' => $request->input('vatable_purchase'),
            'vat' => $request->input('vat'),
            'freight' => $request->input('freight'),
            'total_final_cost' => $request->input('total_final_cost'),
            'total_less_other_discount' => $request->input('total_less_other_discount'),
            'net_payable' => $request->input('net_payable'),
            'cwo_discount' => $request->input('cwo_discount'),
            'user_id' => auth()->user()->id,
        ]);

        $new_invoice_cost_adjustment->save();

        $reference = Received_purchase_order::select('id', 'purchase_order_id')->find($request->input('received_id'));
        $ap_ledger_last_transaction = Ap_ledger::select('running_balance')
            ->where('principal_id', $request->input('principal_id'))
            ->orderBy('id', 'desc')->take(1)->first();

        if ($request->input('total_final_cost') > 0) {
            $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance + $request->input('total_final_cost');
            $new_ap_ledger = new Ap_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'description' => 'Invoice Cost Adjustment from PO#: ' . $reference->purchase_order->purchase_id . ' and RR#: ' . $reference->id,
                'debit_record' => 0,
                'credit_record' => $request->input('total_final_cost'),
                'running_balance' => $ap_ledger_running_balance,
                'transaction' => 'invoice cost adjustment',
                'reference' => 1,
                'remarks' => $request->input('particulars'),
            ]);

            $new_ap_ledger->save();

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
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'INVOICE COST ADJUSTMENT',
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
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $request->input('total_final_cost'),
                    'transaction' => 'INVOICE COST ADJUSTMENT',
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
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'INVOICE COST ADJUSTMENT',
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
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $request->input('total_final_cost'),
                    'transaction' => 'INVOICE COST ADJUSTMENT',
                ]);

                $new_general_ledger->save();
            }
        } else {
            $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - ($request->input('total_final_cost') * -1);
            $new_ap_ledger = new Ap_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'description' => 'Invoice Cost Adjustment from PO#: ' . $reference->purchase_order->purchase_id . ' and RR#: ' . $reference->id,
                'debit_record' => $request->input('total_final_cost') * -1,
                'credit_record' => 0,
                'running_balance' => $ap_ledger_running_balance,
                'transaction' => 'invoice cost adjustment',
                'reference' => 1,
                'remarks' => $request->input('particulars'),
            ]);

            $new_ap_ledger->save();

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
                    'debit_record' => $request->input('total_final_cost') * -1,
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'INVOICE COST ADJUSTMENT',
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('accounts_payable_account_name'),
                    'account_number' => $request->input('accounts_payable_account_number'),
                    'debit_record' => $request->input('total_final_cost') * -1,
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $request->input('total_final_cost'),
                    'transaction' => 'INVOICE COST ADJUSTMENT',
                ]);

                $new_general_ledger->save();
            }


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
                    'debit_record' => 0,
                    'credit_record' => $request->input('total_final_cost') * -1,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'INVOICE COST ADJUSTMENT',
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('merchandise_inventory_account_name'),
                    'account_number' => $request->input('merchandise_inventory_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('total_final_cost') * -1,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $request->input('total_final_cost'),
                    'transaction' => 'INVOICE COST ADJUSTMENT',
                ]);

                $new_general_ledger->save();
            }
        }

        foreach ($request->input('sku_id') as $key => $data) {
            $invoice_cost_details_save = new invoice_cost_adjustment_details([
                'invoice_cost_id' => $new_invoice_cost_adjustment->id,
                'sku_id' => $data,
                'original_unit_cost' => $request->input('unit_cost')[$data],
                'adjusted_amount' => $request->input('unit_cost_adjustment')[$data],
                'adjustments' =>  $request->input('difference_of_new_and_old_unit_cost')[$data],
                'quantity' => $request->input('quantity')[$data],
                'freight' => $request->input('freight_per_sku')[$data],
            ]);
            $invoice_cost_details_save->save();

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $running_amount = $ledger_results[0]->running_amount + $request->input('final_total_cost_per_sku')[$data];
            $new_sku_ledger = new Sku_ledger([
                'sku_id' => $data,
                'quantity' => 0,
                'adjustments' => 0,
                'running_balance' => $ledger_results[0]->running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'invoice cost adjustment',
                'all_id' => $new_invoice_cost_adjustment->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $ledger_results[0]->sku_type,
                'amount' => $request->input('final_total_cost_per_sku')[$data],
                'final_unit_cost' => 0,
                'running_amount' => $running_amount,
            ]);

            $new_sku_ledger->save();
        }

        if (isset($check_less_other_discount_selected_name)) {
            $invoice_cost_adjustment_jer_save = new Invoice_cost_adjustments_jer([
                'principal_id' => $request->input('principal_id'),
                'invoice_cost_id' => $new_invoice_cost_adjustment->id,
                'dr' => $request->input('net_payable'),
                'cr' => $request->input('net_payable'),
                'date' => $date
            ]);

            $invoice_cost_adjustment_jer_save->save();


            $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            if ($principal_ledger_latest) {
                $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
                $principal_ledger_saved = new Principal_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'user_id' => auth()->user()->id,
                    'date' => $date,
                    'all_id' => $new_invoice_cost_adjustment->id,
                    'transaction' => 'invoice cost adjustment',
                    'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                    'received' => 0,
                    'returned' => 0,
                    'adjustment' => $request->input('net_payable'),
                    'payment' => 0,
                    'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('net_payable'),
                ]);

                $principal_ledger_saved->save();
            } else {
                $principal_ledger_saved = new Principal_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'user_id' => auth()->user()->id,
                    'date' => $date,
                    'all_id' => $new_invoice_cost_adjustment->id,
                    'transaction' => 'invoice cost adjustment',
                    'accounts_payable_beginning' => 0,
                    'received' => 0,
                    'returned' => 0,
                    'adjustment' => $request->input('net_payable'),
                    'payment' => 0,
                    'accounts_payable_end' => $request->input('net_payable'),
                ]);

                $principal_ledger_saved->save();
            }
        } else {
            $invoice_cost_adjustment_jer_save = new Invoice_cost_adjustments_jer([
                'principal_id' => $request->input('principal_id'),
                'invoice_cost_id' => $new_invoice_cost_adjustment->id,
                'dr' => $request->input('total_final_cost'),
                'cr' => $request->input('total_final_cost'),
                'date' => $date
            ]);

            $invoice_cost_adjustment_jer_save->save();

            $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            if ($principal_ledger_latest) {
                $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
                $principal_ledger_saved = new Principal_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'user_id' => auth()->user()->id,
                    'date' => $date,
                    'all_id' => $new_invoice_cost_adjustment->id,
                    'transaction' => 'invoice cost adjustment',
                    'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                    'received' => 0,
                    'returned' => 0,
                    'adjustment' => $request->input('total_final_cost'),
                    'payment' => 0,
                    'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('total_final_cost'),
                ]);

                $principal_ledger_saved->save();
            } else {
                $principal_ledger_saved = new Principal_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'user_id' => auth()->user()->id,
                    'date' => $date,
                    'all_id' => $new_invoice_cost_adjustment->id,
                    'transaction' => 'invoice cost adjustment',
                    'accounts_payable_beginning' => 0,
                    'received' => 0,
                    'returned' => 0,
                    'adjustment' => $request->input('total_final_cost'),
                    'payment' => 0,
                    'accounts_payable_end' => $request->input('total_final_cost'),
                ]);

                $principal_ledger_saved->save();
            }
        }
    }
}
