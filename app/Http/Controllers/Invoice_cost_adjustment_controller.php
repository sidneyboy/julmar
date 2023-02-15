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

        if (is_null($request->input('particulars'))) {
            return 'no particulars';
        } else {
            foreach ($request->input('checkbox_entry') as $key => $data) {
                if ($request->input('unit_cost_adjustment')[$data] == 0 or '') {
                    return 'no unit_cost';
                    break;
                }
            }
            $unit_cost_adjustment = str_replace(',', '', $request->input('unit_cost_adjustment'));
            $received_id = Received_purchase_order::find($request->input('received_id'));

            $discount_rate = Principal_discount::find($received_id->principal_discount_id);
            $principal_discount_details = Principal_discount_details::where('principal_discount_id', $received_id->principal_discount_id)->get();

            $principal_discount_details_counter = count($principal_discount_details);

            return view('invoice_cost_adjustments_summary', [
                'principal_discount_details' => $principal_discount_details,
            ])->with('received_id', $request->input('received_id'))
                ->with('unit_cost_adjustment', $unit_cost_adjustment)
                ->with('description', $request->input('description'))
                ->with('quantity', $request->input('quantity'))
                ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                ->with('sku', $request->input('checkbox_entry'))
                ->with('code', $request->input('code'))
                ->with('particulars', $request->input('particulars'))
                ->with('principal_name', $request->input('principal_name'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('last_unit_cost', $request->input('last_unit_cost'))
                ->with('discount_rate', $discount_rate)
                ->with('principal_discount_details_counter', $principal_discount_details_counter)
                ->with('invoice_cost', $request->input('invoice_cost'));
        }

        // $unit_cost_adjustment = str_replace(',', '', $request->input('unit_cost_adjustment'));

        // if ($request->input('principal_name') == 'PPMC') {
        //     $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_ppmc::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }else if ($request->input('principal_name') == 'GCI') {


        //     foreach ($request->input('discounts') as $key => $value) {
        //           $discounts[] = Principal_discount_gci::where('id', $value)->first();
        //       }





        //      $received_id = Received_purchase_order::find($request->input('received_id'));

        //       $select_discount = Principal_discount_gci::find($received_id->discount_id);
        //       $discount_rate =  $select_discount->logistics_fee + $select_discount->selling_fee + $select_discount->cwo_discount + $select_discount->vmi_discount + $select_discount->per_category_sell_discount + $select_discount->total_sell_discount + $select_discount->dops_discount + $select_discount->dbs_discount + $select_discount->reach + $select_discount->shelf_management_discount + $select_discount->display_allowance + $select_discount->bleach_management_project + $select_discount->business_development_fund_discount + $select_discount->others;
        //       $bo_allowance_rate =  $select_discount->bo_discount;

        //       return view('invoice_cost_adjustments_summary',[
        //             'discounts' => $discounts
        //       ])->with('received_id', $request->input('received_id'))
        //          ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //          ->with('description', $request->input('description'))
        //          ->with('quantity', $request->input('quantity'))
        //          ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //          ->with('sku', $request->input('checkbox_entry'))
        //          ->with('code', $request->input('code'))
        //          ->with('particulars', $request->input('particulars'))
        //          ->with('principal_name', $request->input('principal_name'))
        //          ->with('principal_id', $request->input('principal_id'))
        //          ->with('discounts', $discounts)
        //          ->with('last_unit_cost', $request->input('last_unit_cost'))
        //          ->with('discount_rate', $discount_rate)
        //          ->with('bo_allowance_rate', $bo_allowance_rate);
        // }else if($request->input('principal_name') == 'EPI'){


        //     $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_epi::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }else if($request->input('principal_name') == 'CIFPI'){
        //    $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_cifpi::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }else if($request->input('principal_name') == 'ALASKA'){
        //    $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_alaska::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }else if($request->input('principal_name') == 'PFC'){
        //    $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_pfc::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }else if($request->input('principal_name') == 'DOLE'){
        //    $received_id = Received_purchase_order::find($request->input('received_id'));

        //     $discount_rate = Principal_discount_dole::find($received_id->discount_id);

        //     return view('invoice_cost_adjustments_summary')
        //            ->with('received_id', $request->input('received_id'))
        //            ->with('unit_cost_adjustment', $unit_cost_adjustment)
        //            ->with('description', $request->input('description'))
        //            ->with('quantity', $request->input('quantity'))
        //            ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //            ->with('sku', $request->input('checkbox_entry'))
        //            ->with('code', $request->input('code'))
        //            ->with('particulars', $request->input('particulars'))
        //            ->with('principal_name', $request->input('principal_name'))
        //            ->with('principal_id', $request->input('principal_id'))
        //            ->with('last_unit_cost', $request->input('last_unit_cost'))
        //            ->with('discount_rate', $discount_rate);

        // }
    }

    public function invoice_cost_adjustments_save(Request $request)
    {

        //return $request->input('total_net_adjustment');



        if ($request->input('principal_name') == 'PPMC' or $request->input('principal_name') == 'CIFPI') {
            return 'waiting to ask maam van';
        } else {
            $unit_cost_adjustment_input = str_replace(',', '', $request->input('unit_cost_adjustment'));

            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            $invoice_cost_save = new Invoice_cost_adjustments([
                'received_id' => $request->input('received_id'),
                'principal_id' => $request->input('invoice_cost_principal_id'),
                'particulars' => $request->input('particulars'),
                'total_invoice_adjusted' => $request->input('total_invoice_adjusted'),
                'total_bo_allowance' => $request->input('total_bo_allowance'),
                'vatable_purchase' => $request->input('total_vatable_purchase'),
                'less_discount' => $request->input('total_less_discount'),
                'net_discount' => $request->input('total_net_discount'),
                'vat_amount' => $request->input('total_vat_amount'),
                'net_adjustment' => $request->input('total_net_adjustment'),
                'date' => $date
            ]);

            $invoice_cost_save->save();
            $invoice_cost_id = $invoice_cost_save->id;


            // $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('invoice_cost_principal_id'))->latest()->orderBy('id', 'DESC')->take(1)->first();


            $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('invoice_cost_principal_id'))->orderBy('id', 'DESC')->limit(1)->first();


            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('invoice_cost_principal_id'),
                'date' => $date,
                'rr_dr' => $invoice_cost_id,
                'principal_invoice' => $request->input('dr_si'),
                'transaction' => 'invoice cost adjustment',
                'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                'received' => 0,
                'returned' => 0,
                'adjustment' => $request->input('total_net_adjustment'),
                'payment' => 0,
                'accounts_payable_end' => $principal_ledger_accounts_payable_beginning + $request->input('total_net_adjustment'),
            ]);

            $principal_ledger_saved->save();
















            $unit_cost_adjustment = $unit_cost_adjustment_input;
            $last_unit_cost = $request->input('last_unit_cost');
            $quantity = $request->input('quantity');
            $category_id = $request->input('category_id');
            $principal_id = $request->input('principal_id');
            $sku_type = $request->input('sku_type');

            foreach ($request->input('checkbox_entry') as $key => $data) {

                $invoice_cost_details_save = new invoice_cost_adjustment_details([
                    'invoice_cost_id' => $invoice_cost_id,
                    'sku_id' => $data,
                    'adjustments' => $unit_cost_adjustment[$data] - $last_unit_cost[$data],
                    'quantity' => $quantity[$data],
                ]);

                // $update_sku_details = Sku_add_details::where('received_id', $request->input('received_id'))
                //                       ->where('sku_id', $data)
                //                       ->update(['unit_cost' => $unit_cost_adjustment[$data]]);
                // $update_sku_details = Sku_add::where('id', $data)
                //                       ->update(['unit_cost' => $unit_cost_adjustment[$data]]);

                $invoice_cost_details_save->save();


                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


                if ($request->input('invoice_cost')[$data] < $request->input('unit_cost_adjustment')[$data]) {
                    $running_total_cost =  $ledger_results[0]->running_total_cost - $request->input('total_adjustment')[$data];
                } else {

                    $running_total_cost =  $ledger_results[0]->running_total_cost + $request->input('total_adjustment')[$data];
                }



                $final_unit_cost = $running_total_cost / $ledger_results[0]->running_balance;

                $ledger_add = new Sku_ledger([
                    'sku_id' => $data,
                    'category_id' => $category_id[$data],
                    'sku_type' => $sku_type[$data],
                    'principal_id' => $principal_id[$data],
                    'in_out_adjustments' => 'Adj_3',
                    'rr_dr' => $request->input('purchase_id'),
                    'sales_order_number' => '',
                    'principal_invoice' => $request->input('dr_si'),
                    'quantity' => 0,
                    'running_balance' => $ledger_results[0]->running_balance,
                    'unit_cost' => 0,
                    'total_cost' => 0,
                    'adjustments' => $request->input('total_adjustment')[$data],
                    'running_total_cost' => $running_total_cost,
                    'final_unit_cost' => $final_unit_cost,
                    'transaction_date' => $date,
                    'user_id' => auth()->user()->id
                ]);

                $ledger_add->save();
            }





            $invoice_cost_jer = new Invoice_cost_adjustments_jer([
                'invoice_cost_id' => $invoice_cost_id,
                'dr' => $request->input('total_invoice_adjusted'),
                'cr' => $request->input('total_invoice_adjusted'),
                'date' => $date,
            ]);

            $invoice_cost_jer->save();




            return 'Saved';
        }
    }
}
