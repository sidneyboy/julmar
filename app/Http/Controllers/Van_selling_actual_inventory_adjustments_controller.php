<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Van_selling_ar_ledger;
use App\Van_selling_upload_ledger;
use App\Van_selling_inventory_adjustments;
use App\Van_selling_inventory_adjustments_details;
use App\Sku_add;
use App\Vs_inventory_ledger;
use App\Vs_inventory_adjustments;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Van_selling_actual_inventory_adjustments_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            $van_selling_agent = Customer::select('store_name', 'id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_inventory_adjustments', [
                'user' => $user,
                'van_selling_agent' => $van_selling_agent,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_inventory_adjustments',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }


    public function van_selling_inventory_adjustments_generate(Request $request)
    {
        $customer_id = $request->input('customer_id');

        $sku_ledger = DB::select("SELECT * FROM vs_inventory_ledgers WHERE id IN (SELECT MAX(id) FROM vs_inventory_ledgers WHERE customer_id = '$customer_id' GROUP BY sku_id)");

        foreach ($sku_ledger as $key => $data) {
            $sku[$data->sku_id] = Sku_add::select('sku_code', 'description', 'sku_type', 'principal_id')->find($data->sku_id);
        }

        return view('van_selling_inventory_adjustments_generate', [
            'sku_ledger' => $sku_ledger,
            'sku' => $sku,
            'customer_id' => $customer_id,
        ]);
    }

    public function van_selling_inventory_adjustments_generate_final_summary(Request $request)
    {
        //return $request->input();
        $id = array_keys(array_filter($request->input('confirmed_quantity')));

        $vs_inventory_ledger = Vs_inventory_ledger::whereIn('id', $id)->get();

        return view('van_selling_inventory_adjustments_generate_final_summary', [
            'id' => $id,
            'vs_inventory_ledger' => $vs_inventory_ledger,
            'confirmed_quantity' => $request->input('confirmed_quantity'),
            'remarks' => $request->input('remarks'),
            'customer_id' => $request->input('customer_id'),
        ]);
    }

    public function van_selling_inventory_adjustments_save(Request $request)
    {
        //return $request->input();
        $customer_id = $request->input('customer_id');
        $new = new Vs_inventory_adjustments([
            'user_id' => auth()->user()->id,
            'customer_id' => $customer_id,
            'total_amount' => $request->input('total_amount'),
        ]);

        $new->save();
        foreach ($request->input('sku_id') as $key => $data) {
            $ledger_results =  DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_id = '$data' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $new_inventory_ledger = new Vs_inventory_ledger([
                'user_id' => auth()->user()->id,
                'customer_id' => $request->input('customer_id'),
                'principal_id' => $ledger_results[0]->principal_id,
                'transaction' => 'adjustment',
                'sku_id' => $data,
                'beginning_inventory' => $ledger_results[0]->ending_inventory,
                'quantity' => $request->input('adjustments')[$data],
                'ending_inventory' => $ledger_results[0]->ending_inventory + $request->input('adjustments')[$data],
                'unit_price' => $ledger_results[0]->unit_price,
                'all_id' => $new->id,
                'sku_code' => $ledger_results[0]->sku_code,
            ]);
            $new_inventory_ledger->save();
        }
    }

    // public function van_selling_inventory_adjustments_generate(Request $request)
    // {
    //     //return $request->input();
    //     $customer_id = $request->input('customer_id');
    //     $sku_code = $request->input('sku_code');
    //     $van_selling_inventory_ledger = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


    //     $final_quantity = $van_selling_inventory_ledger[0]->end + $request->input('quantity');
    //     Cart::session(auth()->user()->id)->add(array(
    //         'id' => $sku_code,
    //         'name' => $van_selling_inventory_ledger[0]->description,
    //         'price' => $van_selling_inventory_ledger[0]->unit_price,
    //         'quantity' => 1,
    //         'attributes' => array(
    //             'principal' => $van_selling_inventory_ledger[0]->principal,
    //             'unit_of_measurement' => $van_selling_inventory_ledger[0]->unit_of_measurement,
    //             'ending_balance' => $van_selling_inventory_ledger[0]->end,
    //             'final_quantity' => $final_quantity,
    //             'quantity_adjustments' => $request->input('quantity'),
    //             'butal_equivalent' => $van_selling_inventory_ledger[0]->butal_equivalent,
    //             'reference' => 'ACTUAL INVENTORY EVERY CUT OFF',
    //             'beg' => $van_selling_inventory_ledger[0]->end,
    //             'sku_type' => $van_selling_inventory_ledger[0]->sku_type,
    //             'running_balance' => $van_selling_inventory_ledger[0]->running_balance,
    //             'remarks' => $request->input('remarks')
    //         ),
    //     ));

    //     return view('van_selling_inventory_adjustments_generate', [
    //         'sku' => Cart::session(auth()->user()->id)->getContent()
    //     ])->with('customer_id', $request->input('customer_id'));
    // }

    // public function van_selling_inventory_adjustments_generate_final_summary(Request $request)
    // {
    //     //return $request->input();
    //     $van_selling_ar_ledger = Van_selling_ar_ledger::select('running_balance')->where('customer_id', $request->input('customer_id'))->latest()->first();

    //     return view('van_selling_inventory_adjustments_generate_final_summary', [
    //         'sku' => Cart::session(auth()->user()->id)->getContent(),
    //         'inventory_adjustments' => $request->input('inventory_adjustments'),
    //     ])->with('customer_id', $request->input('customer_id'))
    //         ->with('remarks', $request->input('remarks'))
    //         ->with('van_selling_ar_ledger', $van_selling_ar_ledger);
    // }

    // public function van_selling_inventory_adjustments_save(Request $request)
    // {
    //     date_default_timezone_set('Asia/Manila');
    //     $date = date('Y-m-d');
    //     $customer_id = $request->input('customer_id');

    //     // return $request->input();
    //     $user_name = User::select('name')->find(auth()->user()->id);
    //     $sku = Cart::session(auth()->user()->id)->getContent();

    //     $new_van_load = $request->input('total_adjustment_amount_positive') + $request->input('total_adjustment_amount_negative');

    //     $van_selling_inventory_adjustments_save = new Van_selling_inventory_adjustments([
    //         'user_id' => auth()->user()->id,
    //         'customer_id' => $customer_id,
    //         'total_amount' => $new_van_load,
    //         'date' => $date,
    //         'remarks' => $request->input('remarks'),
    //     ]);

    //     $van_selling_inventory_adjustments_save->save();

    //     foreach ($sku as $key => $data) {
    //         $amount[] = $data->price * $data->attributes->quantity_adjustments;

    //         $van_selling_inventory_adjustments_details_save = new Van_selling_inventory_adjustments_details([
    //             'vs_inv_adj_id' => $van_selling_inventory_adjustments_save->id,
    //             'principal' => $data->attributes->principal,
    //             'sku_code' => $data->id,
    //             'description' => $data->name,
    //             'old_quantity' => $data->attributes->beg,
    //             'adjusted_quantity' => $data->attributes->quantity_adjustments,
    //             'unit_price' => $data->price,
    //             'remarks' => $data->attributes->remarks,
    //         ]);

    //         $van_selling_inventory_adjustments_details_save->save();

    //         if ($data->attributes->quantity_adjustments < 0) {
    //             $total_negative = $data->attributes->final_quantity * $data->price;
    //             $van_selling_upload_ledger_negative = new Van_selling_upload_ledger([
    //                 'customer_id' => $request->input('customer_id'),
    //                 'principal' => $data->attributes->principal,
    //                 'sku_code' => $data->id,
    //                 'description' => $data->name,
    //                 'unit_of_measurement' => $data->attributes->unit_of_measurement,
    //                 'sku_type' => $data->attributes->sku_type,
    //                 'butal_equivalent' => $data->attributes->butal_equivalent,
    //                 'reference' => 'INVENTORY ADJUSTMENTS',
    //                 'beg' => $data->attributes->beg,
    //                 'van_load' => 0,
    //                 'sales' => 0,
    //                 'adjustments' => 0,
    //                 'inventory_adjustments' => $data->attributes->quantity_adjustments,
    //                 'clearing' => 0,
    //                 'end' => $data->attributes->final_quantity,
    //                 'unit_price' => $data->price,
    //                 'total' => $total_negative,
    //                 'running_balance' => $data->attributes->running_balance + $total_negative,
    //                 'date' => $date,
    //                 'remarks' => $data->attributes->remarks . " - " . $user_name->name,
    //             ]);

    //             $van_selling_upload_ledger_negative->save();
    //         } else {
    //             $total_positive = $data->attributes->final_quantity * $data->price;

    //             $van_selling_upload_ledger_positive = new Van_selling_upload_ledger([
    //                 'customer_id' => $request->input('customer_id'),
    //                 'principal' => $data->attributes->principal,
    //                 'sku_code' => $data->id,
    //                 'description' => $data->name,
    //                 'unit_of_measurement' => $data->attributes->unit_of_measurement,
    //                 'sku_type' => $data->attributes->sku_type,
    //                 'butal_equivalent' => $data->attributes->butal_equivalent,
    //                 'reference' => 'INVENTORY ADJUSTMENTS VAN LOAD',
    //                 'beg' => $data->attributes->beg,
    //                 'van_load' => $data->attributes->quantity_adjustments,
    //                 'sales' => 0,
    //                 'adjustments' => 0,
    //                 'inventory_adjustments' => 0,
    //                 'clearing' => 0,
    //                 'end' => $data->attributes->final_quantity,
    //                 'unit_price' => $data->price,
    //                 'total' => $total_positive,
    //                 'running_balance' => $data->attributes->running_balance + $total_positive,
    //                 'date' => $date,
    //                 'remarks' => $data->attributes->remarks . " - " . $user_name->name,
    //             ]);

    //             $van_selling_upload_ledger_positive->save();
    //         }
    //     }
    //     // if(array_sum($amount) != 0){
    //     //     $van_search = Van_selling_ar_ledger::where('customer_id',$request->input('customer_id'))->latest()->first();
    //     //     $running_balance = $van_search->running_balance + round(array_sum($amount),2);
    //     //     $van_selling_ledger_save = new Van_selling_ar_ledger([
    //     //                'customer_id' =>$request->input('customer_id'),
    //     //                'vs_inv_adj_id' => '',
    //     //                'cm_amount' => 0,
    //     //                'actual_stocks_on_hand' => 0,
    //     //                'amount' => $new_van_load,
    //     //                'inventory_adjustments' => 0,
    //     //                'over_short' => $van_search->over_short,
    //     //                'user_id' => auth()->user()->id,
    //     //                'collection' => 0,
    //     //                'running_balance' => $running_balance,
    //     //                'date' => $date, 
    //     //                'remarks' => 'NEW VAN LOAD FOR INVENTORY ADJUSTMENTS'
    //     //     ]);

    //     //     $van_selling_ledger_save->save();
    //     // }else{
    //     //     $van_search = Van_selling_ar_ledger::where('customer_id',$request->input('customer_id'))->latest()->first();
    //     //     $running_balance = $van_search->running_balance + round(array_sum($amount),2);
    //     //     $van_selling_ledger_save = new Van_selling_ar_ledger([
    //     //                'customer_id' =>$request->input('customer_id'),
    //     //                'vs_inv_adj_id' => '',
    //     //                'cm_amount' => 0,
    //     //                'actual_stocks_on_hand' => 0,
    //     //                'amount' => $new_van_load,
    //     //                'inventory_adjustments' => 0,
    //     //                'over_short' => $van_search->over_short,
    //     //                'user_id' => auth()->user()->id,
    //     //                'collection' => 0,
    //     //                'running_balance' => $running_balance,
    //     //                'date' => $date, 
    //     //                'remarks' => 'INVENTORY ADJUSTMENT AR MOVEMENT'
    //     //     ]);

    //     //     $van_selling_ledger_save->save();
    //     // }

    //     return 'saved';
    // }
}
