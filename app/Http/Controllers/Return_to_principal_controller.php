<?php

namespace App\Http\Controllers;

use App\Received_purchase_order;
use App\Received_purchase_order_details;
use App\Ap_ledger;
use App\Personnel_description;
use App\Personnel_add;
use App\Sku_ledger;
use DB;
use App\Return_to_principal;
use App\Return_to_principal_details;
use App\Return_to_principal_jer;
use App\User;
use App\Principal_discount;
use App\Principal_ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Return_to_principal_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_id = Received_purchase_order::select('id', 'principal_id', 'purchase_order_id', 'dr_si')->orderBy('id', 'desc')->get();
            return view('return_to_principal', [
                'user' => $user,
                'received_id' => $received_id,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'return_to_principal',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function return_show_inputs(Request $request)
    {
        $variable_explode = explode('=', $request->input('received_id'));
        $received_id = $variable_explode[0];
        $principal_id = $variable_explode[1];

        $received = Received_purchase_order_details::where('received_id', $received_id)->get();
        return view('return_to_principal_show_inputs', [
            'received' => $received,
        ])->with('principal_id', $principal_id)
            ->with('received_id', $received_id);
    }

    public function return_to_principal_summary(Request $request)
    {
        // return $request->input();

        if (is_null($request->input('personnel'))) {
            return 'no personnel';
        } elseif (is_null($request->input('remarks'))) {
            return 'no remarks';
        } else {
            foreach ($request->input('checkbox_entry') as $key => $data) {
                if ($request->input('quantity')[$data] == 0 or '') {
                    return 'no_quantity';
                    break;
                }
            }

            $received_purchase_order = Received_purchase_order::find($request->input('received_id'));
            // return $request->input();

            return view('return_to_principal_summary', [
                'received_purchase_order' => $received_purchase_order,
            ])->with('quantity', $request->input('quantity'))
                ->with('unit_cost', $request->input('unit_cost'))
                ->with('remarks', $request->input('remarks'))
                ->with('freight', $request->input('freight'))
                ->with('code', $request->input('code'))
                ->with('description', $request->input('description'))
                ->with('checkbox_entry', $request->input('checkbox_entry'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('received_id', $request->input('received_id'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('discount_id', $request->input('discount_id'))
                ->with('personnel', $request->input('personnel'))
                ->with('discount_type', $request->input('discount_type'));
        }
    }

    public function return_to_principal_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

       

        $return_to_principal_save = new Return_to_principal([
            'principal_id' => $request->input('principal_id'),
            'received_id' => $request->input('received_id'),
            'personnel' => $request->input('personnel'),
            'user_id' => auth()->user()->id,
            'gross_purchase' => $request->input('gross_purchases'),
            'total_less_discount' => $request->input('total_less_discount'),
            'bo_discount' => $request->input('bo_discount'),
            'cwo_discount' => $request->input('cwo_discount'),
            'vatable_purchase' => $request->input('vatable_purchase'),
            'vat' => $request->input('vat'),
            'freight' => $request->input('freight'),
            'total_final_cost' => $request->input('total_final_cost'),
            'total_less_other_discount' => $request->input('total_less_other_discount'),
            'net_payable' => $request->input('net_payable'),
        ]);

        $return_to_principal_save->save();

        $reference = Received_purchase_order::select('id','purchase_order_id')->find($request->input('received_id'));
        $ap_ledger_last_transaction = Ap_ledger::select('running_balance')->orderBy('id', 'desc')->take(1)->first();

        if ($ap_ledger_last_transaction) {
            $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - $request->input('total_final_cost');
        } else {
            $ap_ledger_running_balance = $request->input('total_final_cost');
        }
        $new_ap_ledger = new Ap_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transaction_date' => $date,
            'description' => 'Return to principal from PO#: ' . $reference->purchase_order->purchase_id .' and RR#: '. $reference->id,
            'debit_record' => 0,
            'credit_record' => $request->input('total_final_cost'),
            'running_balance' => $ap_ledger_running_balance,
            'transaction' => 'return to principal',
            'reference' => $return_to_principal_save->id,
            'remarks' => $request->input('remarks') .', returned by '. $request->input('personnel'),
        ]);

        $new_ap_ledger->save();

        $check_less_other_discount_selected_name = $request->input('less_other_discount_selected_name');

        if (isset($check_less_other_discount_selected_name)) {
            $return_to_principal_jer_saved = new Return_to_principal_jer([
                'return_to_principal_id' => $return_to_principal_save->id,
                'dr' => $request->input('net_payable'),
                'cr' => $request->input('net_payable'),
            ]);

            $return_to_principal_jer_saved->save();

            $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'all_id' => $return_to_principal_save->id,
                'transaction' => 'returned',
                'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                'received' => 0,
                'returned' => $request->input('net_payable'),
                'adjustment' => 0,
                'payment' => 0,
                'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('net_payable'),
            ]);

            $principal_ledger_saved->save();
        } else {
            $return_to_principal_jer_saved = new Return_to_principal_jer([
                'return_to_principal_id' => $return_to_principal_save->id,
                'dr' => $request->input('total_final_cost'),
                'cr' => $request->input('total_final_cost'),
            ]);

            $return_to_principal_jer_saved->save();

            $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'all_id' => $return_to_principal_save->id,
                'transaction' => 'returned',
                'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                'received' => 0,
                'returned' => $request->input('total_final_cost'),
                'adjustment' => 0,
                'payment' => 0,
                'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('total_final_cost'),
            ]);

            $principal_ledger_saved->save();
        }


        foreach ($request->input('sku_id') as $key => $data) {
            $new_return_details = new Return_to_principal_details([
                'return_to_principal_id' => $return_to_principal_save->id,
                'sku_id' => $data,
                'quantity_return' => $request->input('quantity_return')[$data],
                'unit_cost' => $request->input('unit_cost')[$data],
                'freight' => $request->input('freight_per_sku')[$data],
            ]);

            $new_return_details->save();

            // Received_purchase_order_details::where('received_id', $request->input('received_id'))
            //     ->where('sku_idi', $data)
            //     ->update(['quantity_returned' => $request->input('quantity_return')]);

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {
                $running_balance = $ledger_results[0]->running_balance - $request->input('quantity_return')[$data];
                $running_amount = $ledger_results[0]->running_amount - $request->input('final_total_cost_per_sku')[$data];
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('quantity_return')[$data],
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'returned',
                    'all_id' => $return_to_principal_save->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'amount' => $request->input('final_unit_cost_per_sku')[$data],
                    'running_amount' => $running_amount,
                ]);

                $new_sku_ledger->save();
            } else {
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('quantity_return')[$data],
                    'running_balance' => $request->input('quantity_return')[$data],
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'returned',
                    'all_id' => $return_to_principal_save->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'amount' => $request->input('final_unit_cost_per_sku')[$data],
                    'running_amount' => $request->input('final_total_cost_per_sku')[$data],
                ]);

                $new_sku_ledger->save();
            }
        }
    }
}
