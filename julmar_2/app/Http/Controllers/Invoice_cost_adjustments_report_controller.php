<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use App\Invoice_cost_adjustments;
use App\Invoice_cost_adjustment_details;
use App\Principal_discount;
use App\User;
use Illuminate\Http\Request;

class Invoice_cost_adjustments_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->get();
            return view('invoice_cost_adjustments_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'invoice_cost_adjustments_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_cost_adjustments_report_show_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $variable_explode = explode('=', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];

        $invoice_adjustments_data = Invoice_cost_adjustments::where('principal_id', $request->input('principal'))->whereBetween('date', [$date_from, $date_to])->get();

        return view('invoice_cost_adjustments_report_list', [
            'invoice_adjustments_data' => $invoice_adjustments_data
        ])->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name);
    }

    public function invoice_cost_adjustments_show_details($id)
    {
        $variable_explode = explode('=', $id);
        $invoice_cost_adjustment_id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $particulars = $variable_explode[2];
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');


        $user = User::select('name')->where('id', auth()->user()->id)->first();

        $invoice_cost_adjustment_details = Invoice_cost_adjustment_details::where('invoice_cost_id', $invoice_cost_adjustment_id)->get();
        $invoice_cost_adjustment_data = Invoice_cost_adjustments::select('total_invoice_adjusted', 'total_bo_allowance', 'received_id')->where('id', $invoice_cost_adjustment_id)->first();
        $count = count($invoice_cost_adjustment_details);

        $principal_discount = Principal_discount::select('id', 'total_discount', 'total_bo_allowance_discount')->find($invoice_cost_adjustment_data->received->principal_discount_id);


        return view('invoice_cost_adjustments_show_details')->with('principal_name', $principal_name)
            ->with('prepared_by', $user)
            ->with('date', $date)
            ->with('id', $id)
            ->with('particulars', $particulars)
            ->with('invoice_cost_adjustment_data', $invoice_cost_adjustment_data)
            ->with('count', $count)
            ->with('invoice_cost_adjustment_details', $invoice_cost_adjustment_details)
            ->with('invoice_cost_adjustment_id', $invoice_cost_adjustment_id)
            ->with('principal_discount', $principal_discount);

        // if($principal_name == 'GCI'){

        //     $received_purchase_order = Received_purchase_order::select('discount_id')->where('id', $invoice_cost_adjustment_data->received_id)->first();
        //     $discount = Principal_discount_gci::find($received_purchase_order->discount_id);



        //     $discount_rate = $discount->logistics_fee  + $discount->selling_fee + $discount->cwo_discount + $discount->vmi_discount + $discount->per_category_sell_discount + $discount->total_sell_discount + $discount->dops_discount + $discount->dbs_discount + $discount->reach + $discount->shelf_management_discount + $discount->display_allowance + $discount->bleach_management_project + $discount->business_development_fund_discount + $discount->others; 
        //     $bo_allowance_discount_rate = $discount->bo_discount;



        //     return view('invoice_cost_adjustments_show_details')->with('principal_name', $principal_name)
        //         ->with('prepared_by', $user)
        //         ->with('date', $date)
        //         ->with('id', $id)
        //         ->with('particulars', $particulars)
        //         ->with('invoice_cost_adjustment_data', $invoice_cost_adjustment_data)
        //         ->with('count', $count)
        //         ->with('discount', $discount)
        //         ->with('invoice_cost_adjustment_details', $invoice_cost_adjustment_details)

        //         ->with('invoice_cost_adjustment_id',$invoice_cost_adjustment_id);
        // }elseif ($principal_name == 'PFC') {


        //     $received_purchase_order = Received_purchase_order::select('discount_id')->where('id', $invoice_cost_adjustment_data->received_id)->first();
        //     $discount_rate = Principal_discount_pfc::find($received_purchase_order->discount_id);

        //     return view('invoice_cost_adjustments_show_details')->with('principal_name', $principal_name)
        //         ->with('prepared_by', $user)
        //         ->with('date', $date)
        //         ->with('id', $id)
        //         ->with('particulars', $particulars)
        //         ->with('invoice_cost_adjustment_data', $invoice_cost_adjustment_data)
        //         ->with('count', $count)
        //         ->with('discount_rate', $discount_rate)
        //         ->with('invoice_cost_adjustment_details', $invoice_cost_adjustment_details)
        //          ->with('invoice_cost_adjustment_id',$invoice_cost_adjustment_id);
        // }elseif ($principal_name == 'EPI') {


        //     $received_purchase_order = Received_purchase_order::select('discount_id')->where('id', $invoice_cost_adjustment_data->received_id)->first();
        //     $discount_rate = Principal_discount_epi::find($received_purchase_order->discount_id);

        //     return view('invoice_cost_adjustments_show_details')->with('principal_name', $principal_name)
        //         ->with('prepared_by', $user)
        //         ->with('date', $date)
        //         ->with('id', $id)
        //         ->with('particulars', $particulars)
        //         ->with('invoice_cost_adjustment_data', $invoice_cost_adjustment_data)
        //         ->with('count', $count)
        //         ->with('discount_rate', $discount_rate)
        //         ->with('invoice_cost_adjustment_details', $invoice_cost_adjustment_details)
        //          ->with('invoice_cost_adjustment_id',$invoice_cost_adjustment_id);
        // }elseif ($principal_name == 'DOLE') {


        //     $received_purchase_order = Received_purchase_order::select('discount_id')->where('id', $invoice_cost_adjustment_data->received_id)->first();
        //     $discount_rate = Principal_discount_dole::find($received_purchase_order->discount_id);

        //     return view('invoice_cost_adjustments_show_details')->with('principal_name', $principal_name)
        //         ->with('prepared_by', $user)
        //         ->with('date', $date)
        //         ->with('id', $id)
        //         ->with('particulars', $particulars)
        //         ->with('invoice_cost_adjustment_data', $invoice_cost_adjustment_data)
        //         ->with('count', $count)
        //         ->with('discount_rate', $discount_rate)
        //         ->with('invoice_cost_adjustment_details', $invoice_cost_adjustment_details)
        //          ->with('invoice_cost_adjustment_id',$invoice_cost_adjustment_id);
        // }      
    }
}
