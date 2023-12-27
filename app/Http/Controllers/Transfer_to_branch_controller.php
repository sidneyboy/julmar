<?php

namespace App\Http\Controllers;

use App\Chart_of_accounts_details;
use App\General_ledger;
use App\Received_purchase_order;
use App\Received_purchase_order_details;
use App\User;
use App\Transfer_to_bran;
use App\Transfer_to_bran_details;
use App\Sku_ledger;
use DB;
use App\Sku_principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transfer_to_branch_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received = Received_purchase_order::select('id', 'purchase_order_id', 'principal_id', 'dr_si', 'branch')->orderBy('id', 'desc')->get();
            return view('transfer_to_branch', [
                'user' => $user,
                'received' => $received,
                'main_tab' => 'transfer_sku_to_branch_main_tab',
                'sub_tab' => 'transfer_sku_to_branch_sub_tab',
                'active_tab' => 'transfer_to_branch',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function transfer_to_branch_show_input(Request $request)
    {
        //return $request->input();
        $variable_explode = explode('=', $request->input('received_id'));
        $id = $variable_explode[0];
        $principal_id = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $dr_si = $variable_explode[3];
        $remarks = $variable_explode[4];

        $branch = str_replace('to be transfer to', '', $remarks);
        $received_purchase_order = Received_purchase_order::select('branch', 'principal_id')->find($id);

        $get_merchandise_inventory = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
            ->where('account_name', 'MERCHANDISE INVENTORY - ' . $received_purchase_order->principal->principal)
            ->where('principal_id', $principal_id)
            ->first();

        if ($get_merchandise_inventory) {

            $sku_details = Received_purchase_order_details::select('sku_id', 'quantity', 'quantity_returned', 'final_unit_cost')->where('received_id', $id)->get();

            return view('transfer_to_branch_show_input', [
                'sku_details' => $sku_details,
                'received_purchase_order' => $received_purchase_order,
                'get_merchandise_inventory' => $get_merchandise_inventory
            ])->with('id', $id)
                ->with('purchase_id', $purchase_id)
                ->with('transfer_to_branch', $request->input('transfer_to_branch'))
                ->with('transaction_date', $request->input('transaction_date'))
                ->with('principal_id', $principal_id)
                ->with('dr_si', $dr_si)
                ->with('branch', $branch)
                ->with('sku_type', $request->input('sku_type'));
        } else {
            return 'No chart of account';
        }
    }

    public function transfer_to_branch_saved(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        // $new_general_tranfer_to_ledger = new General_ledger([
        //     'principal_id' => $request->input('principal_id'),
        //     'account_name' => $request->input('merchandise_inventory_account_name'),
        //     'account_number' => $request->input('merchandise_inventory_account_number'),
        //     'debit_record' => $request->input('total_amount'),
        //     'credit_record' => 0,
        //     'user_id' => auth()->user()->id,
        //     'transaction_date' => $request->input('invoice_date'),
        //     'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
        //     'running_balance' => $request->input('total_amount'),
        //     'transaction' => 'TRANSFER TO',
        //     'branch' => $request->input('transfer_from_branch'),
        // ]);

        // $new_general_tranfer_to_ledger->save();

        $transfer_to_branch_save = new Transfer_to_bran([
            'received_id' => $request->input('received_id'),
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transfer_from' => $request->input('transfer_from_branch'),
            'transfer_to' => $request->input('transfer_to_branch'),
            'total_amount' => $request->input('total_amount'),
        ]);

        $transfer_to_branch_save->save();


        foreach ($request->input('sku_id') as $key => $data) {
            $transfer_to_branch_details_save = new Transfer_to_bran_details([
                'transfer_id' => $transfer_to_branch_save->id,
                'sku_id' => $data,
                'quantity' => $request->input('quantity')[$data],
                'final_unit_cost' => $request->input('final_unit_cost')[$data],
            ]);

            $transfer_to_branch_details_save->save();

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $out_from_sku_running_balance = $ledger_results[0]->running_balance - $request->input('quantity')[$data];
            $out_from_sku_ledger_new_sku_ledger = new Sku_ledger([
                'sku_id' => $data,
                'quantity' => $request->input('quantity')[$data],
                'running_balance' => $out_from_sku_running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'transfer to branch',
                'all_id' => $transfer_to_branch_save->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
            ]);

            $out_from_sku_ledger_new_sku_ledger->save();
        }

        $get_general_merchandise = General_ledger::select('running_balance')
            ->where('account_name', $request->input('merchandise_inventory_account_name'))
            ->where('principal_id', $request->input('principal_id'))
            ->where('account_number', $request->input('merchandise_inventory_account_number'))
            ->orderBy('id', 'DESC')
            ->first();

        if ($get_general_merchandise) {
            $running_balance = $get_general_merchandise->running_balance - $request->input('total_amount');

            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('merchandise_inventory_account_name'),
                'account_number' => $request->input('merchandise_inventory_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('total_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('transaction_date'),
                'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                'running_balance' => $running_balance,
                'transaction' => 'TRANSFER TO '. $request->input('transfer_to_branch'),
                'branch' => $request->input('transfer_from_branch'),
            ]);

            $new_general_ledger->save();
        } else {
            $new_general_ledger = new General_ledger([
                'principal_id' => $request->input('principal_id'),
                'account_name' => $request->input('merchandise_inventory_account_name'),
                'account_number' => $request->input('merchandise_inventory_account_number'),
                'debit_record' => 0,
                'credit_record' => $request->input('total_amount'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $request->input('invoice_date'),
                'general_account_number' => $request->input('merchandise_inventory_general_account_number'),
                'running_balance' => $request->input('total_amount'),
                'transaction' => 'TRANSFER TO '. $request->input('transfer_to_branch'),
                'branch' => $request->input('transfer_from_branch'),
            ]);

            $new_general_ledger->save();
        }

        return 'saved';
    }
}
