<?php

namespace App\Http\Controllers;

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

class Invoice_cost_adjustment_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_data = Received_purchase_order::orderBy('id', 'desc', 'purchase_id', 'dr_si')->get();
            return view('invoice_cost_adjustments', [
                'user' => $user,
                'received_data' => $received_data,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'invoice_cost_adjustments',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
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
        return view('invoice_cost_adjustments_summary', [
            'received_purchase_order' => $received_purchase_order,
        ])->with('checkbox_entry', $request->input('checkbox_entry'))
            ->with('unit_cost', $request->input('unit_cost'))
            ->with('freight', $request->input('freight'))
            ->with('unit_cost_adjustment', $request->input('unit_cost_adjustment'))
            ->with('particulars', $request->input('particulars'))
            ->with('code', $request->input('code'))
            ->with('description', $request->input('description'))
            ->with('quantity', $request->input('quantity'))
            ->with('received_id', $request->input('received_id'))
            ->with('new_freight', $request->input('new_freight'));
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
            'user_id' => auth()->user()->id,
        ]);

        $new_invoice_cost_adjustment->save();

        foreach ($request->input('sku_id') as $key => $data) {
            $invoice_cost_details_save = new invoice_cost_adjustment_details([
                'invoice_cost_id' => $new_invoice_cost_adjustment->id,
                'sku_id' => $data,
                'original_unit_cost' => $request->input('unit_cost')[$data],
                'adjusted_amount' => $request->input('unit_cost_adjustment')[$data],
                'adjustments' =>  $request->input('unit_cost')[$data] -  $request->input('unit_cost_adjustment')[$data],
                'quantity' => $request->input('quantity')[$data],
                'freight' => $request->input('freight_per_sku')[$data],
            ]);
            $invoice_cost_details_save->save();
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
