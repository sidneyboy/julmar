<?php

namespace App\Http\Controllers;

use App\Received_purchase_order;
use App\Received_purchase_order_details;
use App\Sku_principal;
use App\Bo_allowance_adjustments;
use App\Bo_allowance_adjustments_details;
use App\Bo_allowance_adjustments_jer;
use App\Sku_ledger;
use App\Principal_ledger;
use App\User;
use DB;
use Illuminate\Http\Request;

class Bo_allowance_adjustments_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
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
        //return $request->input();
        if (is_null($request->input('particulars'))) {
            return 'no particulars';
        } else {
            foreach ($request->input('checkbox_entry') as $key => $data) {
                if ($request->input('unit_cost_adjustment')[$data] == 0 or '') {
                    return 'no unit cost adjustment';
                    break;
                }
            }

            //return $request->input();

            $unit_cost_adjustment = str_replace(',', '', $request->input('unit_cost_adjustment'));
            return view('bo_allowance_adjustments_summary')->with('received_id', $request->input('received_id'))
                ->with('unit_cost_adjustment', $unit_cost_adjustment)
                ->with('description', $request->input('description'))
                ->with('quantity', $request->input('quantity'))
                ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                ->with('sku', $request->input('checkbox_entry'))
                ->with('code', $request->input('code'))
                ->with('particulars', $request->input('particulars'))
                ->with('principal_name', $request->input('principal_name'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('unit_cost', $request->input('unit_cost'));
        }
    }

    public function bo_allowance_adjustments_save(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $bo_allowance_adjustments_save = new Bo_allowance_adjustments([
            'principal_id' => $request->input('principal_id'),
            'received_id' => $request->input('received_id'),
            'user_id' => auth()->user()->id,
            'particulars' => $request->input('particulars'),
            'bo_allowance_deduction' => $request->input('bo_allowance_deduction'),
            // 'vat_deduction' => $request->input('vat_deduction'),
            'net_deduction' => $request->input('net_deduction'),
        ]);

        $bo_allowance_adjustments_save->save();


        foreach ($request->input('sku_id') as $key => $sku) {
            $bo_allowance_adjustments_details = new Bo_allowance_adjustments_details([
                'bo_allowance_id' => 1,
                'sku_id' => $sku,
                'quantity' => $request->input('quantity')[$sku],
                'unit_cost' => $request->input('unit_cost')[$sku],
                'adjusted_amount' => $request->input('adjusted_amount')[$sku],
            ]);

            $bo_allowance_adjustments_details->save();

            $update_sku_add_details_unit_cost = Received_purchase_order_details::where('received_id', $request->input('received_id'))
                ->where('sku_id', $sku)
                ->update(['final_unit_cost' => $request->input('adjusted_amount')[$sku]]);
        }


        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

        $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
        $principal_ledger_saved = new Principal_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'date' => $date,
            'all_id' => $bo_allowance_adjustments_save->id,
            'transaction' => 'bo adjustment',
            'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            'received' => 0,
            'returned' => 0,
            'adjustment' => $request->input('bo_allowance_deduction') * -1,
            'payment' => 0,
            'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('bo_allowance_deduction'),
        ]);
        $principal_ledger_saved->save();


        $bo_allowance_jer = new Bo_allowance_adjustments_jer([
            'bo_allowance_id' => $bo_allowance_adjustments_save->id,
            'dr' => $request->input('net_deduction'),
            'cr' => $request->input('net_deduction'),
            'date' => $date
        ]);

        $bo_allowance_jer->save();


        return 'saved';
    }
}
