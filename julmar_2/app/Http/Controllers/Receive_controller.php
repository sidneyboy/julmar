<?php

namespace App\Http\Controllers;
use App\Principal_ledger;
use App\Purchase_order;
use App\Purchase_order_details;
use App\Received_purchase_order;
use App\Principal_discount;
use App\Principal_discount_details;
use App\Received_jer;
use App\Sku_add_details;
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
            $purchase_id = Purchase_order::select('purchase_id', 'id', 'principal_id')
                ->where('remarks', '!=', 'Received')
                ->where('remarks', '!=', 'Incomplete')->get();
            $received_purchase_order_id = Received_purchase_order::select('id')->orderBy('id', 'desc')->first();
            if ($received_purchase_order_id == NULL) {
                $id = 1;
            } else {
                $id = $received_purchase_order_id->id + 1;
            }
            return view('receive_order', [
                'user' => $user,
                'purchase_id' => $purchase_id,
                'id' => $id,
                'received_purchase_order_id' => $received_purchase_order_id,
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
        $purchase_order_id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $principal_id = $variable_explode[3];
        $purchase_order_details = Purchase_order_details::where('purchase_order_id', $purchase_order_id)
            ->whereColumn('receive', '!=', 'quantity')
            ->get();

        $select_principal_discount = Principal_discount::select('id', 'total_bo_allowance_discount', 'total_discount')->where('principal_id', $principal_id)->get();



        return view('receive_order_show_data_summary', [
            'purchase_order_details' => $purchase_order_details,
            'select_principal_discount' => $select_principal_discount
        ])->with('dr_si', $request->input('dr_si'))
            ->with('truck_number', $request->input('truck_number'))
            ->with('courier', $request->input('courier'))
            ->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name)
            ->with('purchase_id', $purchase_id)
            ->with('purchase_order_id', $purchase_order_id)
            ->with('freight', $freight)
            ->with('invoice_date', $request->input('invoice_date'))
            ->with('branch', $request->input('branch'));
    }

    public function received_order_show_selected_discount(Request $request)
    {

        // $variable_explode = explode('=', $request->input('selected_discount'));
        // $discount_id = $variable_explode[0];
        // $principal_name = $variable_explode[1];
        // $selected_discount_rate = Principal_discount_gci::find($request->input('selected_discount'));


        // return view('receive_order_show_data_summary')
        //   ->with('selected_discount_rate', $selected_discount_rate)
        //   ->with('principal_name', $principal_name);
    }

    public function receive_order_data_final_summary(Request $request)
    {
        // return $request->input();

        // foreach ($request->input('sku_id') as $key => $data) {
        //     if ($request->input('received_quantity') != 0) {
        //         if ($request->input('expiration_date')[$data] == '') {
        //           return 'some of your sku doesnt have expiration date.';

        //         }
        //     }
        // }



        if (is_null($request->input('discount'))) {
            return 'null';
        } else {

            $unit_cost = str_replace(',', '', $request->input('unit_cost'));
            $freight = str_replace(',', '', $request->input('freight'));
            $selected_discount_allocation = Principal_discount::find($request->input('discount'));
            $selected_discount_rate = Principal_discount_details::where('principal_discount_id', $request->input('discount'))->get();
            $selected_discount_counter = count($selected_discount_rate);

            $price_1 = str_replace(',', '', $request->input('price_1'));
            $price_2 = str_replace(',', '', $request->input('price_2'));
            $price_3 = str_replace(',', '', $request->input('price_3'));
            $price_4 = str_replace(',', '', $request->input('price_4'));

            return view('receive_order_show_data_final_summary')
                ->with('sku_id', $request->input('sku_id'))
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
                ->with('price_1', $price_1)
                ->with('price_2', $price_2)
                ->with('price_3', $price_3)
                ->with('price_4', $price_4)
                ->with('branch', $request->input('branch'));
        }
    }


    public function received_order_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');



        if (is_null($request->input('branch'))) {
            $branch = 'N/a';
        } else {
            $branch = 'to be transfer to ' . $request->input('branch');
        }

        if ($request->input('principal_name') == 'CIFPI') {
            $discount_rate_per_sku = implode('-', $request->input('discount_rate_per_sku'));
            $received_save = new Received_purchase_order([
                'principal_discount_id' => $request->input('principal_discount_id'),
                'principal_id' => $request->input('principal_id'),
                'purchase_order_id' => $request->input('purchase_order_id'),
                'dr_si' => $request->input('dr_si'),
                'truck_number' => $request->input('truck_number'),
                'courier' => $request->input('courier'),
                'invoice_date' => $request->input('invoice_date'),
                'remarks' => $branch,
                'date' => $date,
                'invoice_image' => '',
                'total_freight' => $request->input('total_freight'),
                'total_vatable_purchase' => $request->input('total_vatable_purchase'),
                'total_discount' => $request->input('total_discount'),
                'total_bo_allowance_discount' => $request->input('total_bo_allowance_discount'),
                'total_vat_amount' => $request->input('total_vat_amount'),
                'grand_total_final_cost' => $request->input('grand_total_final_cost'),
            ]);
        } elseif ($request->input('principal_name') == 'PPMC') {
            $discount_rate_per_sku = implode('-', $request->input('discount_rate_per_sku'));
            $received_save = new Received_purchase_order([
                'principal_discount_id' => $request->input('principal_discount_id'),
                'principal_id' => $request->input('principal_id'),
                'purchase_order_id' => $request->input('purchase_order_id'),
                'dr_si' => $request->input('dr_si'),
                'truck_number' => $request->input('truck_number'),
                'courier' => $request->input('courier'),
                'invoice_date' => $request->input('invoice_date'),
                'remarks' => $branch,
                'date' => $date,
                'invoice_image' => '',
                'total_freight' => 0,
                'total_vatable_purchase' => $request->input('total_vatable_purchase'),
                'total_discount' => $request->input('total_discount'),
                'total_bo_allowance_discount' => $request->input('total_bo_allowance_discount'),
                'total_vat_amount' => $request->input('total_vat_amount'),
                'grand_total_final_cost' => $request->input('grand_total_final_cost'),
            ]);
        } else {
            $discount_id = $request->input('discount_id');
            $received_save = new Received_purchase_order([
                'principal_discount_id' => $request->input('principal_discount_id'),
                'principal_id' => $request->input('principal_id'),
                'purchase_order_id' => $request->input('purchase_order_id'),
                'dr_si' => $request->input('dr_si'),
                'truck_number' => $request->input('truck_number'),
                'courier' => $request->input('courier'),
                'invoice_date' => $request->input('invoice_date'),
                'remarks' => $branch,
                'date' => $date,
                'invoice_image' => '',
                'total_freight' => 0,
                'total_vatable_purchase' => $request->input('total_vatable_purchase'),
                'total_discount' => $request->input('total_discount'),
                'total_bo_allowance_discount' => $request->input('total_bo_allowance_discount'),
                'total_vat_amount' => $request->input('total_vat_amount'),
                'grand_total_final_cost' => $request->input('grand_total_final_cost'),
            ]);
        }

        $received_save->save();
        $received_id = $received_save->id;


        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();
        //$counter = count($principal_ledger_latest);

        if ($principal_ledger_latest) {
            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'date' => $date,
                'rr_dr' => $received_id,
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
                'rr_dr' => $received_id,
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
            'received_id' => $received_id,
            'dr' => $request->input('grand_total_final_cost'),
            'cr' => $request->input('grand_total_final_cost'),
            'date' => $date
        ]);

        $received_jer_save->save();

        foreach ($request->input('sku_id') as $data_id) {

            if ($request->input('principal_name') == 'CIFPI') {
                $sku_details_save = new Sku_add_details([
                    'received_id' => $received_id,
                    'sku_id' => $data_id,
                    'quantity_per_sku' => $request->input('quantity_per_sku')[$data_id],
                    'quantity_return_per_sku' => 0,

                    'unit_cost_per_sku' => $request->input('unit_cost_per_sku')[$data_id],
                    'final_unit_cost_per_sku' => $request->input('final_unit_cost_per_sku')[$data_id],
                    'final_total_cost_per_sku' => $request->input('final_total_cost_per_sku')[$data_id],
                    'bo_allowance_discount_per_sku' => $request->input('bo_allowance_discount_per_sku')[$data_id],
                    'bo_allowance_discount_rate_per_sku' => $request->input('bo_allowance_discount_rate_per_sku')[$data_id],
                    'discount_rate_per_sku' => $discount_rate_per_sku,
                    'freight_per_sku' => $request->input('freight_per_sku')[$data_id],
                    'remarks' => $request->input('remarks')[$data_id],
                    'expiration_date' => $request->input('expiration_date')[$data_id],
                ]);
                $sku_details_save->save();
            } elseif ($request->input('principal_name') == 'PPMC') {
                $sku_details_save = new Sku_add_details([
                    'received_id' => $received_id,
                    'sku_id' => $data_id,
                    'quantity_per_sku' => $request->input('quantity_per_sku')[$data_id],
                    'quantity_return_per_sku' => 0,

                    'unit_cost_per_sku' => $request->input('unit_cost_per_sku')[$data_id],
                    'final_unit_cost_per_sku' => $request->input('final_unit_cost_per_sku')[$data_id],
                    'final_total_cost_per_sku' => $request->input('final_total_cost_per_sku')[$data_id],
                    'bo_allowance_discount_per_sku' => $request->input('bo_allowance_discount_per_sku')[$data_id],
                    'bo_allowance_discount_rate_per_sku' => $request->input('bo_allowance_discount_rate_per_sku')[$data_id],
                    'discount_rate_per_sku' => $discount_rate_per_sku,
                    'freight_per_sku' => 0,
                    'remarks' => $request->input('remarks')[$data_id],
                    'expiration_date' => $request->input('expiration_date')[$data_id],
                ]);
                $sku_details_save->save();
            } else {
                $sku_details_save = new Sku_add_details([
                    'received_id' => $received_id,
                    'sku_id' => $data_id,
                    'quantity_per_sku' => $request->input('quantity_per_sku')[$data_id],
                    'quantity_return_per_sku' => 0,

                    'unit_cost_per_sku' => $request->input('unit_cost_per_sku')[$data_id],
                    'final_unit_cost_per_sku' => $request->input('final_unit_cost_per_sku')[$data_id],
                    'final_total_cost_per_sku' => $request->input('final_total_cost_per_sku')[$data_id],
                    'bo_allowance_discount_per_sku' => $request->input('bo_allowance_discount_per_sku')[$data_id],
                    'bo_allowance_discount_rate_per_sku' => $request->input('bo_allowance_discount_rate_per_sku')[$data_id],
                    'discount_rate_per_sku' => $request->input('discount_rate_per_sku')[$data_id],
                    'freight_per_sku' => 0,
                    'remarks' => $request->input('remarks')[$data_id],
                    'expiration_date' => $request->input('expiration_date')[$data_id],
                ]);
                $sku_details_save->save();
            }

            $update_purchase_order_details = Purchase_order_details::where('purchase_order_id', $request->input('purchase_order_id'))->where('sku_id', $data_id)->first();

            $update_purchase_order_details->receive = $update_purchase_order_details->receive + $request->input('quantity_per_sku')[$data_id];
            $update_purchase_order_details->save();

            $sku_price_details = Sku_price_details::where('sku_id', $data_id)->orderBy('created_at', 'DESC')->first();

            $sku_price_details = Sku_price_details::where('sku_id', $data_id)->orderBy('created_at', 'DESC')->first();

            if (round($sku_price_details->unit_cost, 2) != $request->input('unit_cost_per_sku')[$data_id]) {
                $price_add = new Sku_price_details([
                    'sku_id'    => $data_id,
                    'unit_cost' => $request->input('unit_cost_per_sku')[$data_id],
                    'price_1' => $request->input('price_1')[$data_id],
                    'price_2' => $request->input('price_2')[$data_id],
                    'price_3' => $request->input('price_3')[$data_id],
                    'price_4' => $request->input('price_4')[$data_id]
                ]);
                $price_add->save();
            } else {
            }



            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {

                $total_cost = $request->input('quantity_per_sku')[$data_id] * $request->input('final_unit_cost_per_sku')[$data_id];

                if ($ledger_results[0]->in_out_adjustments == 'transfer' or $ledger_results[0]->in_out_adjustments == 'return') {
                    $quantity = $request->input('quantity_per_sku')[$data_id] * -1;
                } else {
                    $quantity = $request->input('quantity_per_sku')[$data_id];
                }

                $running_balance = $ledger_results[0]->running_balance + $quantity;
                $running_total_cost = $ledger_results[0]->running_total_cost + $ledger_results[0]->adjustments +  $total_cost;
                $latest_final_unit_cost = $running_total_cost / $running_balance;

                $ledger_add = new Sku_ledger([
                    'sku_id' => $data_id,
                    'category_id' => $request->input('category_id')[$data_id],
                    'sku_type' => $request->input('sku_type')[$data_id],
                    'principal_id' => $request->input('principal_id'),
                    'in_out_adjustments' => 'In',
                    'rr_dr' => $received_id,
                    'sales_order_number' => '',
                    'principal_invoice' => $request->input('dr_si'),
                    'quantity' => $quantity,
                    'running_balance' => $running_balance,
                    'unit_cost' => $request->input('final_unit_cost_per_sku')[$data_id],
                    'total_cost' => $total_cost,
                    'adjustments' => 0,
                    'running_total_cost' => $running_total_cost,
                    'final_unit_cost' => $latest_final_unit_cost,
                    'transaction_date' => $date,
                    'user_id' => auth()->user()->id,
                ]);

                $ledger_add->save();
            } else {
                $total_cost = $request->input('quantity_per_sku')[$data_id] * $request->input('final_unit_cost_per_sku')[$data_id];
                $latest_final_unit_cost = $total_cost / $request->input('quantity_per_sku')[$data_id];

                $ledger_add = new Sku_ledger([
                    'sku_id' => $data_id,
                    'category_id' => $request->input('category_id')[$data_id],
                    'sku_type' => $request->input('sku_type')[$data_id],
                    'principal_id' => $request->input('principal_id'),
                    'in_out_adjustments' => 'In',
                    'rr_dr' => $received_id,
                    'sales_order_number' => '',
                    'principal_invoice' => $request->input('dr_si'),
                    'quantity' => $request->input('quantity_per_sku')[$data_id],
                    'running_balance' => $request->input('quantity_per_sku')[$data_id],
                    'unit_cost' => $request->input('final_unit_cost_per_sku')[$data_id],
                    'total_cost' => $total_cost,
                    'adjustments' => 0,
                    'running_total_cost' => $total_cost,
                    'final_unit_cost' => $latest_final_unit_cost,
                    'transaction_date' => $date,
                    'user_id' => auth()->user()->id,
                ]);

                $ledger_add->save();
            }

            $check_purchase_order_details = Purchase_order_details::whereColumn('receive', '<>', 'quantity')
                ->where('purchase_order_id', $request->input('purchase_order_id'))->count();

            if ($check_purchase_order_details > 0) {
                $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
                $update_purchase_order->remarks = 'Staggered';
                $update_purchase_order->save();
            } else {
                $update_purchase_order = Purchase_order::find($request->input('purchase_order_id'));
                $update_purchase_order->remarks = 'Received';
                $update_purchase_order->save();
            }
        }

        return 'Saved';
    }
}
