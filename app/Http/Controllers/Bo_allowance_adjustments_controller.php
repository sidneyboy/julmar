<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\Received_purchase_order;
use App\Received_purchase_order_details;
use App\Sku_principal;
use App\Bo_allowance_adjustments;
use App\Bo_allowance_adjustments_details;
use App\Bo_allowance_adjustments_jer;
use App\Chart_of_accounts_details;
use App\General_ledger;
use App\Sku_ledger;
use App\Principal_ledger;
use App\Received_purchase_order_bo_allowance;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bo_allowance_adjustments_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_data = Received_purchase_order::orderBy('id', 'desc', 'purchase_order_id', 'dr_si')->get();
            return view('bo_allowance_adjustments', [
                'user' => $user,
                'received_data' => $received_data,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'bo_allowance_adjustments',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bo_allowance_adjustments_inputs(Request $request)
    {

        $variable_explode = explode('=', $request->input('received_id'));
        $received_id = $variable_explode[0];
        $principal_id = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $dr_si = $variable_explode[3];
        $sku_add_details = Received_purchase_order_details::where('received_id', $received_id)->get();
        $principal_name = Sku_principal::where('id', $principal_id)->first();
        return view('bo_allowance_adjustments_inputs', [
            'sku_add_details' => $sku_add_details
        ])->with('received_id', $received_id)
            ->with('principal_name', $principal_name->principal)
            ->with('principal_id', $principal_id)
            ->with('purchase_id', $purchase_id)
            ->with('dr_si', $dr_si);
    }

    public function bo_allowance_adjustments_show_summary(Request $request)
    {
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
            $unit_cost_adjustment = str_replace(',', '', $request->input('unit_cost_adjustment'));
            $received_purchase_order = Received_purchase_order::find($request->input('received_id'));
            $sku_add_details = Received_purchase_order_details::where('received_id', $request->input('received_id'))
                ->whereIn('sku_id', $request->input('checkbox_entry'))
                ->get();

            $latest_bo_layer = Received_purchase_order_bo_allowance::select('bo_allowance')
                ->where('received_id', $request->input('received_id'))
                ->orderBy('id', 'desc')
                ->first();

            $bo_allowance_layer = $latest_bo_layer->bo_allowance;

            return view('bo_allowance_adjustments_summary', [
                'received_purchase_order' => $received_purchase_order,
                'bo_allowance_layer' => $bo_allowance_layer,
                'get_merchandise_inventory' => $get_merchandise_inventory,
                'get_accounts_payable' => $get_accounts_payable,
            ])->with('received_id', $request->input('received_id'))
                ->with('unit_cost_adjustment', $unit_cost_adjustment)
                ->with('checkbox_entry', $request->input('checkbox_entry'))
                ->with('transaction_date', $request->input('transaction_date'))
                ->with('description', $request->input('description'))
                ->with('quantity', $request->input('quantity'))
                ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                ->with('sku', $sku_add_details)
                ->with('code', $request->input('code'))
                ->with('particulars', $request->input('particulars'))
                ->with('principal_name', $request->input('principal_name'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('unit_cost', $request->input('unit_cost'));
        } else {
            return 'No chart of account';
        }
    }

    public function bo_allowance_adjustments_save(Request $request)
    {

        return $request->input();
        $curdate = DB::select('SELECT CURDATE()');
        $curtime = DB::select('SELECT CURTIME()');

        $bo_allowance_adjustments_save = new Bo_allowance_adjustments([
            'principal_id' => $request->input('principal_id'),
            'received_id' => $request->input('received_id'),
            'user_id' => auth()->user()->id,
            'particulars' => $request->input('particulars'),
            'bo_allowance_deduction' => $request->input('bo_allowance_deduction'),
            // 'vat_deduction' => $request->input('vat_deduction'),
            'net_deduction' => $request->input('net_deduction'),
            'date' => $curdate[0]->{'CURDATE()'},
            'time' => $curtime[0]->{'CURTIME()'},
        ]);

        $bo_allowance_adjustments_save->save();

        if ($request->input('net_deduction') > 0) {
            $get_accounts_payable = General_ledger::select('running_balance')
                ->where('account_name', $request->input('accounts_payable_account_name'))
                ->where('principal_id', $request->input('principal_id'))
                ->where('account_number', $request->input('accounts_payable_account_number'))
                ->orderBy('id', 'DESC')
                ->first();

            if ($get_accounts_payable) {
                $running_balance = $get_accounts_payable->running_balance + $request->input('net_deduction');

                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('accounts_payable_account_name'),
                    'account_number' => $request->input('accounts_payable_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('net_deduction'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('accounts_payable_account_name'),
                    'account_number' => $request->input('accounts_payable_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('net_deduction'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $request->input('net_deduction'),
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
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
                $running_balance = $get_general_merchandise->running_balance + $request->input('net_deduction');
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('merchandise_inventory_account_name'),
                    'account_number' => $request->input('merchandise_inventory_account_number'),
                    'debit_record' => $request->input('net_deduction'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('merchandise_inventory_account_name'),
                    'account_number' => $request->input('merchandise_inventory_account_number'),
                    'debit_record' => $request->input('net_deduction'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $request->input('net_deduction'),
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            }

            //WALAY APIL
            // $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance + $request->input('net_deduction');
            // $new_ap_ledger = new Ap_ledger([
            //     'principal_id' => $request->input('principal_id'),
            //     'user_id' => auth()->user()->id,
            //     'transaction_date' => $date,
            //     'description' => 'Bo Allowance Adjustment from PO#: ' . $reference->purchase_order->purchase_id . ' and RR#: ' . $reference->id,
            //     'debit_record' => 0,
            //     'credit_record' => $request->input('net_deduction'),
            //     'running_balance' => $ap_ledger_running_balance,
            //     'transaction' => 'bo allowance adjustment',
            //     'reference' => 1,
            //     'remarks' => $request->input('particulars'),
            // ]);

            // $new_ap_ledger->save();
            //WALAY APIL
        } else {
            $get_accounts_payable = General_ledger::select('running_balance')
                ->where('account_name', $request->input('accounts_payable_account_name'))
                ->where('principal_id', $request->input('principal_id'))
                ->where('account_number', $request->input('accounts_payable_account_number'))
                ->orderBy('id', 'DESC')
                ->first();

            if ($get_accounts_payable) {
                $running_balance = $get_accounts_payable->running_balance + $request->input('net_deduction');

                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('accounts_payable_account_name'),
                    'account_number' => $request->input('accounts_payable_account_number'),
                    'debit_record' => $request->input('net_deduction'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('accounts_payable_account_name'),
                    'account_number' => $request->input('accounts_payable_account_number'),
                    'debit_record' =>  $request->input('net_deduction'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('accounts_payable_general_account_number'),
                    'running_balance' => $request->input('net_deduction'),
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
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
                $running_balance = $get_general_merchandise->running_balance + $request->input('net_deduction');
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('merchandise_inventory_account_name'),
                    'account_number' => $request->input('merchandise_inventory_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('net_deduction'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            } else {
                $new_general_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('merchandise_inventory_account_name'),
                    'account_number' => $request->input('merchandise_inventory_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('net_deduction'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $request->input('transaction_date'),
                    'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                    'running_balance' => $request->input('net_deduction'),
                    'transaction' => 'BO ALLOWANCE ADJUSTMENT',
                    'date' => $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                    'all_id' => $bo_allowance_adjustments_save->id,
                ]);

                $new_general_ledger->save();
            }




            //WALAY APIL
            // $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - ($request->input('net_deduction') * -1);
            // $new_ap_ledger = new Ap_ledger([
            //     'principal_id' => $request->input('principal_id'),
            //     'user_id' => auth()->user()->id,
            //     'transaction_date' => $date,
            //     'description' => 'Bo Allowance Adjustment from PO#: ' . $reference->purchase_order->purchase_id . ' and RR#: ' . $reference->id,
            //     'debit_record' => $request->input('net_deduction') * -1,
            //     'credit_record' => 0,
            //     'running_balance' => $ap_ledger_running_balance,
            //     'transaction' => 'bo allowance adjustment',
            //     'reference' => $bo_allowance_adjustments_save->id,
            //     'remarks' => $request->input('particulars'),
            // ]);

            // $new_ap_ledger->save();
            //WALAY APIL
        }
        //return $request->input();
        foreach ($request->input('sku_id') as $key => $sku) {
            $bo_allowance_adjustments_details = new Bo_allowance_adjustments_details([
                'bo_allowance_id' => $bo_allowance_adjustments_save->id,
                'sku_id' => $sku,
                'quantity' => $request->input('quantity')[$sku],
                // 'unit_cost' => $request->input('unit_cost')[$sku],
                'adjusted_amount' => 0,
                'bo_cost_adjustment' => $request->input('bo_cost_adjustment')[$sku],
                'bo_discount' => $request->input('bo_discount')[$sku],
                'freight' => $request->input('freight')[$sku],
                'vat' => $request->input('vat')[$sku],
                'total_cost' => $request->input('total_cost')[$sku],
            ]);

            $bo_allowance_adjustments_details->save();

            // WALAY APIL
            // Received_purchase_order_details::where('received_id', $request->input('received_id'))
            //     ->where('sku_id', $sku)
            //     ->update(['final_unit_cost' => $request->input('adjusted_amount')[$sku]]);
            //  WALAY APIL

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $running_amount = $ledger_results[0]->running_amount + $request->input('total_cost')[$sku];
            if ($ledger_results[0]->transaction_type == 'bo allowance adjustment' or $ledger_results[0]->transaction_type == 'invoice cost adjustment') {
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $sku,
                    'quantity' => 0,
                    'adjustments' => 0,
                    'running_balance' => $ledger_results[0]->running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'bo allowance adjustment',
                    'all_id' => $bo_allowance_adjustments_save->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $ledger_results[0]->sku_type,
                    'final_unit_cost' =>  0,
                    'amount' => $request->input('total_cost')[$sku],
                    'running_amount' => $running_amount,
                    'with_invoice_quantity' => $ledger_results[0]->with_invoice_quantity,
                    'with_invoice_net_balance' => $ledger_results[0]->with_invoice_net_balance,
                    'date' =>  $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                ]);

                $new_sku_ledger->save();
            } else {
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $sku,
                    'quantity' => 0,
                    'adjustments' => 0,
                    'running_balance' => $ledger_results[0]->running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'bo allowance adjustment',
                    'all_id' => $bo_allowance_adjustments_save->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $ledger_results[0]->sku_type,
                    'final_unit_cost' =>  0,
                    'amount' => $request->input('total_cost')[$sku],
                    'running_amount' => $running_amount,
                    'with_invoice_quantity' => $ledger_results[0]->with_invoice_quantity,
                    'with_invoice_net_balance' => $ledger_results[0]->with_invoice_net_balance,
                    'date' =>  $curdate[0]->{'CURDATE()'},
                    'time' => $curtime[0]->{'CURTIME()'},
                ]);

                $new_sku_ledger->save();
            }
        }

        $new_bo_layer = new Received_purchase_order_bo_allowance([
            'received_id' => $request->input('received_id'),
            'bo_allowance' => $request->input('new_bo_allowance_layer'),
        ]);

        $new_bo_layer->save();












        //WALAY APIL
        // $reference = Received_purchase_order::select('id', 'purchase_order_id')->find($request->input('received_id'));
        // $ap_ledger_last_transaction = Ap_ledger::select('running_balance')
        //     ->where('principal_id', $request->input('principal_id'))
        //     ->orderBy('id', 'desc')->take(1)->first();

        // if ($ap_ledger_last_transaction) {
        //     $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - $request->input('net_deduction');
        // } else {
        //     $ap_ledger_running_balance = $request->input('net_deduction');
        // }
        //WALAY APIL



        //WALAY APIL
        // $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

        // $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
        // $principal_ledger_saved = new Principal_ledger([
        //     'principal_id' => $request->input('principal_id'),
        //     'user_id' => auth()->user()->id,
        //     'date' => $date,
        //     'all_id' => $bo_allowance_adjustments_save->id,
        //     'transaction' => 'bo adjustment',
        //     'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
        //     'received' => 0,
        //     'returned' => 0,
        //     'adjustment' => $request->input('bo_allowance_deduction') * -1,
        //     'payment' => 0,
        //     'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('bo_allowance_deduction'),
        // ]);
        // $principal_ledger_saved->save();



        // $bo_allowance_jer = new Bo_allowance_adjustments_jer([
        //     'bo_allowance_id' => $bo_allowance_adjustments_save->id,
        //     'dr' => $request->input('net_deduction'),
        //     'cr' => $request->input('net_deduction'),
        //     'date' => $date
        // ]);

        // $bo_allowance_jer->save();
        //WALAY APIL


        return 'saved';
    }
}
