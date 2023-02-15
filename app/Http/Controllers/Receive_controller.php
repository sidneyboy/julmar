<?php

namespace App\Http\Controllers;

use App\Principal_ledger;
use App\Purchase_order;
use App\Purchase_order_details;
use App\Received_purchase_order;
use App\Principal_discount;
use App\Principal_discount_details;
use App\Received_jer;
use App\Received_purchase_order_details;
use App\Sku_add_details;
use App\Receiving_draft;
use App\Receiving_draft_main;
use App\Sku_ledger;
use App\Sku_price_details;
use DB;
use App\User;
use Illuminate\Http\Request;

class Receive_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_purchase_order_id = Received_purchase_order::select('id')->orderBy('id', 'desc')->first();
            if ($received_purchase_order_id == NULL) {
                $id = 1;
            } else {
                $id = $received_purchase_order_id->id + 1;
            }

            $draft = Receiving_draft_main::where('status', null)->get();
            return view('receive_order', [
                'user' => $user,
                'draft' => $draft,
                // 'purchase_id' => $purchase_id,
                'id' => $id,
                // 'received_purchase_order_id' => $received_purchase_order_id,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'receive_order',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }


    public function receive_order_generate_data(Request $request)
    {
        //return $request->input();
        $freight = str_replace(',', '', $request->input('freight'));

        $variable_explode = explode('=', $request->input('purchase_id'));
        $session_id = $variable_explode[0];
        $purchase_order_id = $variable_explode[1];
        $principal_name = $variable_explode[2];
        $purchase_id = $variable_explode[3];
        $principal_id = $variable_explode[4];
        $purchase_order_details = Purchase_order_details::where('purchase_order_id', $purchase_order_id)
            ->whereColumn('receive', '!=', 'quantity')
            ->orderBy('sku_id')
            ->get();

        $select_principal_discount = Principal_discount::select('id', 'total_bo_allowance_discount', 'total_discount')->where('principal_id', $principal_id)->get();

        $draft = Receiving_draft::where('session_id', $session_id)->orderBy('sku_id')->get();

        return view('receive_order_show_data_summary', [
            'purchase_order_details' => $purchase_order_details,
            'select_principal_discount' => $select_principal_discount,
            'draft' => $draft
        ])->with('dr_si', $request->input('dr_si'))
            ->with('truck_number', $request->input('truck_number'))
            ->with('courier', $request->input('courier'))
            ->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name)
            ->with('session_id', $session_id)
            ->with('purchase_id', $purchase_id)
            ->with('purchase_order_id', $purchase_order_id)
            ->with('freight', $freight)
            ->with('invoice_date', $request->input('invoice_date'))
            ->with('branch', $request->input('branch'));
    }

    public function receive_order_data_final_summary(Request $request)
    {

        if (is_null($request->input('discount'))) {
            return 'null';
        } else {

            $unit_cost = str_replace(',', '', $request->input('unit_cost'));
            $freight = str_replace(',', '', $request->input('freight'));
            $selected_discount_allocation = Principal_discount::find($request->input('discount'));

            $selected_discount_rate = Principal_discount_details::where('principal_discount_id', $request->input('discount'))->get();
            $selected_discount_counter = count($selected_discount_rate);


            return view('receive_order_show_data_final_summary')
                ->with('sku_id', $request->input('sku_id'))
                ->with('discount_type', $request->input('discount_type'))
                ->with('category_id', $request->input('category_id'))
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
                ->with('gci_discount_id', $request->input('discount'))
                ->with('selected_discount_allocation', $selected_discount_allocation)
                ->with('expiration_date', $request->input('expiration_date'))
                ->with('selected_discount_rate', $selected_discount_rate)
                ->with('selected_discount_counter', $selected_discount_counter)
                ->with('unit_cost', $unit_cost)
                ->with('freight', $freight)
                ->with('invoice_date', $request->input('invoice_date'))
                ->with('remarks', $request->input('remarks'))
                ->with('branch', $request->input('branch'))
                ->with('scanned_by', $request->input('scanned_by'))
                ->with('draft_session_id', $request->input('draft_session_id'));
        }
    }


    public function received_order_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $new_received_purchase_orders = new Received_purchase_order([
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
        ]);

        $new_received_purchase_orders->save();

        foreach ($request->input('sku_id') as $key => $data) {
            $new_received_purchase_order_details = new Received_purchase_order_details([
                'received_id' => $new_received_purchase_orders->id,
                'sku_id' => $data,
                'quantity' => $request->input('received_quantity')[$data],
                'unit_cost' => $request->input('unit_cost')[$data],
                'freight' => $request->input('freight')[$data],
            ]);

            $new_received_purchase_order_details->save();

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {
                $running_balance = $ledger_results[0]->running_balance + $request->input('received_quantity')[$data];
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('received_quantity')[$data],
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'receiving',
                    'all_id' => $new_received_purchase_orders->id,
                ]);

                $new_sku_ledger->save();
            } else {
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data,
                    'quantity' => $request->input('received_quantity')[$data],
                    'running_balance' => $request->input('received_quantity')[$data],
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'receiving',
                    'all_id' => $new_received_purchase_orders->id,
                ]);

                $new_sku_ledger->save();
            }

            $update_purchase_order_details = Purchase_order_details::select('id','quantity','receive')->where('purchase_order_id', $request->input('purchase_order_id'))->where('sku_id', $data)->first();

            $update_received = $update_purchase_order_details->receive + $request->input('received_quantity')[$data];
            if ($update_received == $update_purchase_order_details->quantity) {
                $update_purchase_order_details->receive = $update_received;
                $update_purchase_order_details->remarks = 'received';
                $update_purchase_order_details->scanned_remarks = null;
                $update_purchase_order_details->save();
            }else{
                $update_purchase_order_details->receive = $update_received;
                $update_purchase_order_details->remarks = 'staggered';
                $update_purchase_order_details->scanned_remarks = null;
                $update_purchase_order_details->save();
            }

            $check_purchase_order_details = Purchase_order_details::whereColumn('receive', '<>', 'quantity')
                ->where('purchase_order_id', $request->input('purchase_order_id'))->count();

            if ($check_purchase_order_details > 0) {
                $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
                $update_purchase_order->remarks = 'staggered';
                $update_purchase_order->save();
            } else {
                $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
                $update_purchase_order->remarks = 'received';
                $update_purchase_order->save();
            }
        }

        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

        if ($principal_ledger_latest) {
            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'date' => $date,
                'rr_dr' => $new_received_purchase_orders->id,
                'principal_invoice' => $request->input('dr_si'),
                'transaction' => 'received',
                'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                'received' => $request->input('grand_total_final_cost'),
                'returned' => 0,
                'adjustment' => 0,
                'payment' => 0,
                'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('grand_total_final_cost'),
            ]);

            $principal_ledger_saved->save();
        } else {
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'date' => $date,
                'rr_dr' => $new_received_purchase_orders->id,
                'principal_invoice' => $request->input('dr_si'),
                'transaction' => 'received',
                'accounts_payable_beginning' => 0,
                'received' => $request->input('grand_total_final_cost'),
                'returned' => 0,
                'adjustment' => 0,
                'payment' => 0,
                'accounts_payable_end' => $request->input('grand_total_final_cost'),
            ]);

            $principal_ledger_saved->save();
        }

        $received_jer_save = new Received_jer([
            'principal_id' => $request->input('principal_id'),
            'received_id' => $new_received_purchase_orders->id,
            'dr' => $request->input('grand_total_final_cost'),
            'cr' => $request->input('grand_total_final_cost'),
            'date' => $date
        ]);

        $received_jer_save->save();

        Receiving_draft_main::where('session_id', $request->input('draft_session_id'))
            ->update(['status' => 'completed']);

        return 'saved';
    }
}
