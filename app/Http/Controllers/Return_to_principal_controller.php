<?php

namespace App\Http\Controllers;

use App\Received_purchase_order;
use App\Sku_add_details;
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

class Return_to_principal_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function return_show_inputs(Request $request)
    {

        //return $request->input();

        $variable_explode = explode('=', $request->input('received_id'));
        $received_id = $variable_explode[0];
        $principal_id = $variable_explode[1];
        $purchase_id = $variable_explode[2];
        $dr_si = $variable_explode[3];
        $personnel_description = Personnel_description::where('personnel_description', 'driver')->first();


        if (empty($personnel_description)) {
            return 'no_personnel';
        } else {
            $personnels = Personnel_add::where('personnel_description_id', $personnel_description->id)->get();
            $sku_add_details = Sku_add_details::where('received_id', $received_id)->get();
            return view('return_to_principal_show_inputs', [
                'sku_add_details' => $sku_add_details,
                'personnels' => $personnels,
            ])->with('principal_id', $principal_id)
                ->with('received_id', $received_id)
                ->with('purchase_id', $purchase_id)
                ->with('dr_si', $dr_si);
        }
    }

    public function return_to_principal_summary(Request $request)
    {
        //return $request->input();

        if (is_null($request->input('personnel'))) {
            return 'no personnel';
        } elseif (is_null($request->input('remarks'))) {
            return 'no remarks';
        } else {
            foreach ($request->input('checkbox_entry') as $key => $data) {
                if ($request->input('quantity_return_per_sku')[$data] == 0 or '') {
                    return 'no_quantity';
                    break;
                }
            }

            $variable_explode = explode('-', $request->input('purchase_id'));
            $principal_name = $variable_explode[0];

            $received_order_data = Received_purchase_order::find($request->input('received_id'));
            $principal_discount = Principal_discount::find($received_order_data->principal_discount_id);

            return view('return_to_principal_summary')
                ->with('quantity_return_per_sku', $request->input('quantity_return_per_sku'))
                ->with('unit_cost', $request->input('unit_cost'))
                ->with('code', $request->input('code'))
                ->with('description', $request->input('description'))
                ->with('unit_of_measurement', $request->input('unit_of_measurement'))
                ->with('checkbox_entry', $request->input('checkbox_entry'))
                ->with('received_order_data', $received_order_data)
                ->With('principal_name', $principal_name)
                ->with('principal_discount', $principal_discount)
                ->with('return_discount_id', $received_order_data->principal_discount_id);
        }


        // if (is_null($request->input('personnel')) {
        //     return 'select personel first';
        // }elseif (is_null($request->input('remarks'))) {
        //     return 'select remarks first';
        // }else{
        // foreach ($request->input('quantity_return_per_sku') as $key => $quantity_check) {
        //   if ($quantity_check == 0 OR '') {
        //     return 'no_quantity';
        //     break;
        //   }
        // }

        // $variable_explode = explode('-', $request->input('purchase_id'));
        // $principal_name = $variable_explode[0];

        // $received_order_data = Received_purchase_order::find($request->input('received_id'));
        // $principal_discount = Principal_discount::find($received_order_data->principal_discount_id);

        //    return view('return_to_principal_summary')
        //     ->with('quantity_return_per_sku', $request->input('quantity_return_per_sku'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('principal_discount', $principal_discount)
        //     ->with('return_discount_id', $received_order_data->principal_discount_id);
        // }




        // if ($principal_name == 'GCI') {

        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_gci::find($received_order_data->discount_id);

        //   $gci_discount_added =  $discount->logistics_fee + $discount->selling_fee + $discount->cwo_discount + $discount->vmi_discount + $discount->per_category_sell_discount + $discount->total_sell_discount + $discount->dops_discount + $discount->dbs_discount + $discount->reach + $discount->shelf_management_discount + $discount->display_allowance + $discount->bleach_management_project + $discount->business_development_fund_discount + $discount->others + $discount->bo_discount;

        //   return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $gci_discount_added)
        //     ->with('return_discount_id', $received_order_data->discount_id);

        // }elseif($principal_name == 'PFC'){

        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_pfc::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);

        // }elseif($principal_name == 'EPI'){
        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_epi::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);
        // }elseif($principal_name == 'CIFPI'){

        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_cifpi::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);



        // }elseif($principal_name == 'PPMC'){

        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_ppmc::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);



        // }elseif($principal_name == 'DOLE'){



        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_dole::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);


        // }elseif($principal_name == 'ALASKA'){
        //   $received_order_data = Received_purchase_order::find($request->input('received_id'));
        //   $discount = Principal_discount_alaska::find($received_order_data->discount_id);

        //     return view('return_to_principal_summary')
        //     ->with('quantity_return', $request->input('quantity_return'))
        //     ->with('unit_cost', $request->input('unit_cost'))
        //     ->with('code', $request->input('code'))
        //     ->with('description', $request->input('description'))
        //     ->with('unit_of_measurement', $request->input('unit_of_measurement'))
        //     ->with('checkbox_entry', $request->input('checkbox_entry'))
        //     ->with('received_order_data', $received_order_data)
        //     ->With('principal_name', $principal_name)
        //     ->with('discount', $discount)
        //     ->with('return_discount_id', $received_order_data->discount_id);
        // }
    }

    public function return_to_principal_save(Request $request)
    {


        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');



        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $sku = $request->input('checkbox_entry');
        $sku_counter = count($sku);
        $unit_cost = $request->input('unit_cost');
        $final_unit_cost = $request->input('final_unit_cost');
        $quantity_return_per_sku = $request->input('quantity_return_per_sku');
        $principal_id = $request->input('principal_id');
        $category_id = $request->input('category_id');
        $sku_type = $request->input('sku_type');

        $return_to_principal_save = new Return_to_principal([
            'principal_id' => $request->input('return_principal_id'),
            'received_id' => $request->input('received_id'),
            'personnel_id' => $request->input('personnel'),
            'discount_id' => $request->input('return_discount_id'),
            'user_id' => auth()->user()->id,
            'remarks' => $request->input('remarks'),
            'total_amount_return' => $request->input('total_amount_return'),
            'return_vatable_purchase' => $request->input('return_vatable_purchase'),
            'return_less_discount' => $request->input('return_less_discount'),
            'return_net_discount' => $request->input('return_net_discount'),
            'return_vat_amount' => $request->input('return_vat_amount'),
            'return_net_of_deduction' => $request->input('return_net_of_deduction'),
            'date' => $date,
        ]);

        $return_to_principal_save->save();
        $return_to_principal_id = $return_to_principal_save->id;


        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('return_principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

        $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
        $principal_ledger_saved = new Principal_ledger([
            'principal_id' => $request->input('return_principal_id'),
            'date' => $date,
            'rr_dr' => $return_to_principal_id,
            'principal_invoice' => $request->input('dr_si'),
            'transaction' => 'returned',
            'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            'received' => 0,
            'returned' => $request->input('total_amount_return'),
            'adjustment' => 0,
            'payment' => 0,
            'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('total_amount_return'),
        ]);

        $principal_ledger_saved->save();



        foreach ($request->input('checkbox_entry') as $key => $data) {
            $return_to_principal_details_save = new Return_to_principal_details([
                'sku_id' => $data,
                'return_to_principal_id' => $return_to_principal_id,
                'quantity_return' => $quantity_return_per_sku[$data],
                'unit_cost' => $unit_cost[$data],
            ]);

            $return_to_principal_details_save->save();


            $sku_details_update = Sku_add_details::where('received_id', $request->input('received_id'))
                ->where('sku_id', $data)
                ->update(['quantity_return_per_sku' => $quantity_return_per_sku[$data]]);



            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$data' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


            $ledger_quantity = ($quantity_return_per_sku[$data]) * -1;
            $ledger_running_balance = $ledger_results[0]->running_balance - $quantity_return_per_sku[$data];
            $ledger_unit_cost = $final_unit_cost[$data];
            $ledger_total_cost = $ledger_quantity * $ledger_unit_cost;
            $ledger_running_total_cost = $ledger_results[0]->running_total_cost + $ledger_total_cost;







            if ($ledger_running_balance == 0) {
                $ledger_final_unit_cost = $ledger_results[0]->final_unit_cost;
            } else {
                $ledger_final_unit_cost = $ledger_running_total_cost / $ledger_running_balance;
            }

            $ledger_add = new Sku_ledger([
                'sku_id' => $data,
                'category_id' => $category_id[$data],
                'sku_type' => $sku_type[$data],
                'principal_id' => $principal_id[$data],
                'in_out_adjustments' => 'Ret',
                'rr_dr' => $request->input('purchase_id'),
                'sales_order_number' => '',
                'principal_invoice' => $request->input('dr_si'),
                'quantity' => $ledger_quantity,
                'running_balance' => $ledger_running_balance,
                'unit_cost' => $ledger_unit_cost,
                'total_cost' => $ledger_total_cost,
                'adjustments' => 0,
                'running_total_cost' => $ledger_running_total_cost,
                'final_unit_cost' => $ledger_final_unit_cost,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add->save();
        }



        $return_to_principal_jers = new Return_to_principal_jer([
            'return_to_principal_id' => $return_to_principal_id,
            'dr' => $request->input('total_amount_return'),
            'cr' => $request->input('total_amount_return'),
            'date' => $date
        ]);

        $return_to_principal_jers->save();

        return 'Saved';
    }
}
