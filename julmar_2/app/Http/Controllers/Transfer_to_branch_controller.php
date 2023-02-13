<?php

namespace App\Http\Controllers;
use App\Received_purchase_order;
use App\Sku_add_details;
use App\User;
use App\Transfer_to_bran;
use App\Transfer_to_bran_details;
use App\Sku_ledger;
use DB;
use App\Sku_principal;
use Illuminate\Http\Request;

class Transfer_to_branch_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $remarks = 'to be transfer to CARAGA';
            $remarks2 = 'to be transfer to POD';
            $received = Received_purchase_order::select('id', 'purchase_order_id', 'principal_id', 'dr_si', 'remarks')->where('remarks', $remarks2)->orWhere('remarks', $remarks)->get();
            return view('transfer_to_branch', [
                'user' => $user,
                'received' => $received,
                'main_tab' => 'transfer_sku_to_branch_main_tab',
                'sub_tab' => 'transfer_sku_to_branch_sub_tab',
                'active_tab' => 'transfer_to_branch',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function transfer_to_branch_show_input(Request $request)
    {
        $variable_explode = explode('=', $request->input('received_id'));
        $id = $variable_explode[0];
        $principal_id = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $dr_si = $variable_explode[3];
        $remarks = $variable_explode[4];

        $branch = str_replace('to be transfer to', '', $remarks);

        $sku_details = Sku_add_details::where('received_id', $id)->get();
        $principal_name = Sku_principal::where('id', $principal_id)->first();


        return view('transfer_to_branch_show_input', [
            'sku_details' => $sku_details
        ])->with('id', $id)
            ->with('purchase_id', $purchase_id)
            ->with('principal_id', $principal_id)
            ->with('dr_si', $dr_si)
            ->with('principal_name', $principal_name)
            ->with('branch', $branch);
    }

    public function transfer_to_branch_saved(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $transfer_to_branch_save = new Transfer_to_bran([
            'received_id' => $request->input('received_id'),
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'branch' => $request->input('branch'),
            'date' => $date,
        ]);

        $transfer_to_branch_save->save();
        $transfer_id = $transfer_to_branch_save->id;

        $received_purchase_order_update = Received_purchase_order::find($request->input('received_id'));

        $received_purchase_order_update->remarks = 'Transafered To' . $request->input('branch');

        $received_purchase_order_update->save();

        $received_update = Received_purchase_order::find($request->input('id'));

        $received_update->remarks = 'Transfered';

        $received_update->save();

        $quantity = $request->input('quantity');
        foreach ($request->input('checkboxEntry') as $key => $sku) {
            $transfer_to_branch_details_save = new Transfer_to_bran_details([
                'transfer_id' => $transfer_id,
                'sku_id' => $sku,
                'quantity' => $quantity[$sku],
                'final_unit_cost' => $request->input('last_final_unit_cost_case')[$sku],
            ]);

            $transfer_to_branch_details_save->save();

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


            $final_cost = $request->input('last_final_unit_cost_case')[$sku];
            $quantity_transfer = $quantity[$sku] * -1;
            $running_balance =  $ledger_results[0]->running_balance - $quantity[$sku];
            $last_final_unit_cost = $final_cost;
            $total_cost = $last_final_unit_cost * $quantity_transfer;
            $running_total_cost = $ledger_results[0]->running_total_cost + $total_cost;

            if ($running_balance > 0) {
                $final_unit_cost = $running_total_cost / $running_balance;
            } else {
                $final_unit_cost =  $ledger_results[0]->final_unit_cost;
            }


            $ledger_add = new Sku_ledger([
                'sku_id' => $sku,
                'in_out_adjustments' => 'Transfer to Branch',
                'rr_dr' => $transfer_id,
                'sales_order_number' => '',
                'principal_invoice' => $request->input('dr_si'),
                'quantity' => $quantity_transfer,
                'running_balance' => $running_balance,
                'unit_cost' => $last_final_unit_cost,
                'total_cost' => $total_cost,
                'adjustments' => 0,
                'running_total_cost' => $running_total_cost,
                'final_unit_cost' => $final_unit_cost,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add->save();
        }

        return 'Saved';
    }
}
