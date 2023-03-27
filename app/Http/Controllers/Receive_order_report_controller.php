<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use App\Received_purchase_order;
use App\Sku_add_details;
use App\Return_to_principal;
use App\Bo_allowance_adjustments;
use App\Invoice_cost_adjustments;
use App\Principal_discount;
use App\Principal_discount_details;
use App\User;
use DB;
use Illuminate\Http\Request;

class Receive_order_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            $principals = Sku_principal::select('id', 'contact_number', 'principal')->where('principal','!=','none')->get();
            return view('receive_order_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'receive_order_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function receive_order_report_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));


        $variable_explode = explode('=', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $date = date('F j, Y', strtotime($date_from)) . ' - ' . date('F j, Y', strtotime($date_to));

        $received_purchase_order = Received_purchase_order::where('principal_id', $principal_id)->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->orderBy('id','desc')->get();

        return view('receive_order_report_show_list', [
            'received_purchase_order' => $received_purchase_order,
        ])->with('principal_name', $principal_name)
            ->with('date', $date)
            ->with('date_from_to', $request->input('date'))
            ->with('principal', $request->input('principal'))
            ->with('date_from', $date_from)
            ->with('date_to', $date_to)
            ->with('principal_id', $principal_id);
    }

    public function received_order_report_show_details($id)
    {
       $received_purchase_order = Received_purchase_order::find($id);

       return view('received_order_report_show_details',[
        'received_purchase_order' => $received_purchase_order,
       ]);
    }

    public function discount_allocation($id)
    {

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');

        $variable_explode = explode('=', $id);
        $data_id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $logistics_fee = $variable_explode[2];
        $selling_fee = $variable_explode[3];
        $cwo_discount = $variable_explode[4];
        $vmi_discount = $variable_explode[5];
        $per_category_sell_discount = $variable_explode[6];
        $total_sell_discount = $variable_explode[7];
        $dops_discount = $variable_explode[8];
        $dbs_discount = $variable_explode[9];
        $reach = $variable_explode[10];
        $shelf_management_discount = $variable_explode[11];
        $display_allowance = $variable_explode[12];
        $bleach_management_project = $variable_explode[13];
        $business_development_fund_discount = $variable_explode[14];
        $others = $variable_explode[15];

        $received_details = Sku_add_details::where('received_id', $data_id)->get();
        $received_data = Received_purchase_order::where('id', $data_id)->first();
        $prepared_by = User::select('name')->find(auth()->user()->id);



        return view('received_order_discount_allowance', [
            'received_details' => $received_details
        ])->with('principal_name', $principal_name)
            ->with('date', $date)
            ->with('prepared_by', $prepared_by->name)
            ->with('id', $data_id)
            ->with('logistics_fee', $logistics_fee)
            ->with('selling_fee', $selling_fee)
            ->with('cwo_discount', $cwo_discount)
            ->with('vmi_discount', $vmi_discount)
            ->with('per_category_sell_discount', $per_category_sell_discount)
            ->with('total_sell_discount', $total_sell_discount)
            ->with('dops_discount', $dops_discount)
            ->with('dbs_discount', $dbs_discount)
            ->with('reach', $reach)
            ->with('shelf_management_discount', $shelf_management_discount)
            ->with('display_allowance', $display_allowance)
            ->with('bleach_management_project', $bleach_management_project)
            ->with('business_development_fund_discount', $business_development_fund_discount)
            ->with('received_data', $received_data)
            ->with('others', $others);
    }

    public function received_sku_report($id)
    {
        return $id;
    }

    public function discount_allocation_all($id)
    {


        $var = explode('=', $id);
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));
        $principal_id = $var[2];
        $principal_name = $var[3];
        $prepared_by = User::select('name')->find(auth()->user()->id);
        if ($principal_name == 'GCI') {

            $received_discount_rate = [];
            $return_discount_rate = [];

            $received_order_data = Received_purchase_order::select('id', 'discount_id', 'principal_id', 'dr_si', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'grand_final_total_cost', 'total_bo_allowance', 'total_every_discount', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $return_order_data = Return_to_principal::select('id', 'received_id', 'principal_id', 'received_id', 'discount_id', 'return_vatable_purchase', 'return_less_discount', 'return_net_discount', 'return_vat_amount', 'return_net_of_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($received_order_data) {
                foreach ($received_order_data as $key => $data) {
                    $received_discount_rate[] = Principal_discount_gci::find($data->discount_id);
                }
            } else {
                $received_discount_rate[] = '';
            }

            if ($return_order_data) {
                foreach ($return_order_data as $key => $return) {
                    $return_discount_rate[] = Principal_discount_gci::find($return->discount_id);
                }
            } else {
                $return_discount_rate[] = '';
            }


            $return_counter = count($return_order_data);
            $received_counter = count($received_order_data);

            return view('received_order_discount_allocation_all', [
                'received_order_data' => $received_order_data,
                'return_order_data' => $return_order_data,
            ])->with('principal_name', $principal_name)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('prepared_by', $prepared_by)
                ->with('received_discount_rate', $received_discount_rate)
                ->with('return_discount_rate', $return_discount_rate)
                ->with('return_counter', $return_counter)
                ->with('received_counter', $received_counter);
        } elseif ($principal_name == 'PPMC') {
            return 'NO INSTRUCTIONS YET';
        }
    }

    public function received_order_report_print($id)
    {

        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');
        $var = explode('=', $id);
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));
        $principal_id = $var[2];
        $principal_name = $var[3];
        $method = $var[4];
        $prepared_by = User::select('name')->find(auth()->user()->id);


        if ($principal_name == 'GCI') {

            $received_discount_rate = [];
            $received_discount_rate_array = [];
            $return_discount_rate = [];
            $return_discount_rate_array = [];


            $received_order_data = Received_purchase_order::select('id', 'discount_id', 'principal_id', 'dr_si', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'grand_final_total_cost', 'total_bo_allowance', 'total_every_discount', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($received_order_data) {
                foreach ($received_order_data as $key => $data) {
                    $received_discount_rate[] = Principal_discount_gci::find($data->discount_id);
                }
                foreach ($received_discount_rate as $key => $data) {
                    $sum_discount = $data->logistics_fee + $data->selling_fee + $data->cwo_discount + $data->vmi_discount + $data->per_category_sell_discount + $data->total_sell_discount + $data->dops_discount + $data->dbs_discount + $data->reach + $data->shelf_management_discount + $data->display_allowance + $data->bleach_management_project + $data->business_development_fund_discount + $data->others;

                    $received_discount_rate_array[] = $sum_discount / 100;
                }
            } else {
                $received_discount_rate[] = '';
            }

            $return_order_data = Return_to_principal::select('id', 'received_id', 'principal_id', 'received_id', 'discount_id', 'return_vatable_purchase', 'return_less_discount', 'return_net_discount', 'return_vat_amount', 'return_net_of_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($return_order_data) {
                foreach ($return_order_data as $key => $return) {
                    $return_discount_rate[] = Principal_discount_gci::find($return->discount_id);
                }
                foreach ($return_discount_rate as $key => $data) {
                    $sum_discount = $data->logistics_fee + $data->selling_fee + $data->cwo_discount + $data->vmi_discount + $data->per_category_sell_discount + $data->total_sell_discount + $data->dops_discount + $data->dbs_discount + $data->reach + $data->shelf_management_discount + $data->display_allowance + $data->bleach_management_project + $data->business_development_fund_discount + $data->others;

                    $return_discount_rate_array[] = $sum_discount / 100;
                }
            } else {
                $return_discount_rate[] = '';
            }

            $bo_adjustment_data = Bo_allowance_adjustments::select('id', 'received_id', 'principal_id', 'bo_allowance_deduction', 'vat_deduction', 'net_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $invoice_cost_data = Invoice_cost_adjustments::select('id', 'received_id', 'principal_id', 'total_invoice_adjusted', 'total_bo_allowance', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'net_adjustment', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $received_counter = count($received_order_data);
            $bo_counter = count($bo_adjustment_data);
            $invoice_counter = count($invoice_cost_data);
            $return_counter = count($return_order_data);

            return view('received_order_report_print', [
                'received_order_data' => $received_order_data,
                'bo_adjustment_data' => $bo_adjustment_data,
                'return_order_data' => $return_order_data,
                'invoice_cost_data' => $invoice_cost_data,
            ])->with('date', $date)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('method', $method)
                ->with('prepared_by', $prepared_by)
                ->with('received_discount_rate', $received_discount_rate)
                ->with('received_discount_rate_array', $received_discount_rate_array)
                ->with('return_discount_rate', $return_discount_rate)
                ->with('return_discount_rate_array', $return_discount_rate_array)
                ->with('received_counter', $received_counter)
                ->with('bo_counter', $bo_counter)
                ->with('invoice_counter', $invoice_counter)
                ->with('return_counter', $return_counter);
            return 'gci';
        } elseif ($principal_name == 'PFC') {
            $received_discount_rate = [];
            $return_discount_rate = [];


            $received_order_data = Received_purchase_order::select('id', 'discount_id', 'principal_id', 'dr_si', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'grand_final_total_cost', 'total_bo_allowance', 'total_every_discount', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($received_order_data) {
                foreach ($received_order_data as $key => $data) {
                    $received_discount_rate[] = Principal_discount_pfc::find($data->discount_id);
                }
            } else {
                $received_discount_rate[] = '';
            }

            $return_order_data = Return_to_principal::select('id', 'received_id', 'principal_id', 'received_id', 'discount_id', 'return_vatable_purchase', 'return_less_discount', 'return_net_discount', 'return_vat_amount', 'return_net_of_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($return_order_data) {
                foreach ($return_order_data as $key => $return) {
                    $return_discount_rate[] = Principal_discount_pfc::find($return->discount_id);
                }
            } else {
                $return_discount_rate[] = '';
            }

            $bo_adjustment_data = Bo_allowance_adjustments::select('id', 'received_id', 'principal_id', 'bo_allowance_deduction', 'vat_deduction', 'net_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $invoice_cost_data = Invoice_cost_adjustments::select('id', 'received_id', 'principal_id', 'total_invoice_adjusted', 'total_bo_allowance', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'net_adjustment', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $received_counter = count($received_order_data);
            $bo_counter = count($bo_adjustment_data);
            $invoice_counter = count($invoice_cost_data);
            $return_counter = count($return_order_data);

            return view('received_order_report_print', [
                'received_order_data' => $received_order_data,
                'bo_adjustment_data' => $bo_adjustment_data,
                'return_order_data' => $return_order_data,
                'invoice_cost_data' => $invoice_cost_data,
            ])->with('date', $date)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('method', $method)
                ->with('prepared_by', $prepared_by)
                ->with('received_discount_rate', $received_discount_rate)
                ->with('return_discount_rate', $return_discount_rate)
                ->with('received_counter', $received_counter)
                ->with('bo_counter', $bo_counter)
                ->with('invoice_counter', $invoice_counter)
                ->with('return_counter', $return_counter);
        } elseif ($principal_name == 'PPMC') {


            $received_order_data = Received_purchase_order::where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();
            $bo_adjustment_data = Bo_allowance_adjustments::where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();


            $invoice_cost_data = Invoice_cost_adjustments::where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $variable_explode = explode('=', $received_order_data[0]['total_every_discount']);
            $trade_discount_1 = $variable_explode[0];
            $trade_discount_2 = $variable_explode[1];
            $dizer_allowance = $variable_explode[2];
            $dste = $variable_explode[3];
            $optimix = $variable_explode[4];

            return view('received_order_report_print', [
                'received_order_data' => $received_order_data,
                'bo_adjustment_data' => $bo_adjustment_data,
                'invoice_cost_data' => $invoice_cost_data,
            ])->with('principal_name', $principal_name)
                ->with('date', $date)
                ->with('trade_discount_1', $trade_discount_1)
                ->with('trade_discount_2', $trade_discount_2)
                ->with('dizer_allowance', $dizer_allowance)
                ->with('dste', $dste)
                ->with('optimix', $optimix)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('method', $method)
                ->with('prepared_by', $prepared_by);
            return 'ppmc';
        } elseif ($principal_name == 'EPI') {
            $received_discount_rate = [];
            $return_discount_rate = [];


            $received_order_data = Received_purchase_order::select('id', 'discount_id', 'principal_id', 'dr_si', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'grand_final_total_cost', 'total_bo_allowance', 'total_every_discount', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($received_order_data) {
                foreach ($received_order_data as $key => $data) {
                    $received_discount_rate[] = Principal_discount_epi::find($data->discount_id);
                }
            } else {
                $received_discount_rate[] = '';
            }

            $return_order_data = Return_to_principal::select('id', 'received_id', 'principal_id', 'received_id', 'discount_id', 'return_vatable_purchase', 'return_less_discount', 'return_net_discount', 'return_vat_amount', 'return_net_of_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($return_order_data) {
                foreach ($return_order_data as $key => $return) {
                    $return_discount_rate[] = Principal_discount_epi::find($return->discount_id);
                }
            } else {
                $return_discount_rate[] = '';
            }

            $bo_adjustment_data = Bo_allowance_adjustments::select('id', 'received_id', 'principal_id', 'bo_allowance_deduction', 'vat_deduction', 'net_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $invoice_cost_data = Invoice_cost_adjustments::select('id', 'received_id', 'principal_id', 'total_invoice_adjusted', 'total_bo_allowance', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'net_adjustment', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $received_counter = count($received_order_data);
            $bo_counter = count($bo_adjustment_data);
            $invoice_counter = count($invoice_cost_data);
            $return_counter = count($return_order_data);

            return view('received_order_report_print', [
                'received_order_data' => $received_order_data,
                'bo_adjustment_data' => $bo_adjustment_data,
                'return_order_data' => $return_order_data,
                'invoice_cost_data' => $invoice_cost_data,
            ])->with('date', $date)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('method', $method)
                ->with('prepared_by', $prepared_by)
                ->with('received_discount_rate', $received_discount_rate)
                ->with('return_discount_rate', $return_discount_rate)
                ->with('received_counter', $received_counter)
                ->with('bo_counter', $bo_counter)
                ->with('invoice_counter', $invoice_counter)
                ->with('return_counter', $return_counter);
        } elseif ($principal_name == 'DOLE') {
            $received_discount_rate = [];
            $return_discount_rate = [];


            $received_order_data = Received_purchase_order::select('id', 'discount_id', 'principal_id', 'dr_si', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'grand_final_total_cost', 'total_bo_allowance', 'total_every_discount', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($received_order_data) {
                foreach ($received_order_data as $key => $data) {
                    $received_discount_rate[] = Principal_discount_dole::find($data->discount_id);
                }
            } else {
                $received_discount_rate[] = '';
            }

            $return_order_data = Return_to_principal::select('id', 'received_id', 'principal_id', 'received_id', 'discount_id', 'return_vatable_purchase', 'return_less_discount', 'return_net_discount', 'return_vat_amount', 'return_net_of_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            if ($return_order_data) {
                foreach ($return_order_data as $key => $return) {
                    $return_discount_rate[] = Principal_discount_dole::find($return->discount_id);
                }
            } else {
                $return_discount_rate[] = '';
            }

            $bo_adjustment_data = Bo_allowance_adjustments::select('id', 'received_id', 'principal_id', 'bo_allowance_deduction', 'vat_deduction', 'net_deduction', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $invoice_cost_data = Invoice_cost_adjustments::select('id', 'received_id', 'principal_id', 'total_invoice_adjusted', 'total_bo_allowance', 'vatable_purchase', 'less_discount', 'net_discount', 'vat_amount', 'net_adjustment', 'date')->where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

            $received_counter = count($received_order_data);
            $bo_counter = count($bo_adjustment_data);
            $invoice_counter = count($invoice_cost_data);
            $return_counter = count($return_order_data);

            return view('received_order_report_print', [
                'received_order_data' => $received_order_data,
                'bo_adjustment_data' => $bo_adjustment_data,
                'return_order_data' => $return_order_data,
                'invoice_cost_data' => $invoice_cost_data,
            ])->with('date', $date)
                ->with('date_from', $date_from)
                ->with('date_to', $date_to)
                ->with('principal_id', $principal_id)
                ->with('principal_name', $principal_name)
                ->with('method', $method)
                ->with('prepared_by', $prepared_by)
                ->with('received_discount_rate', $received_discount_rate)
                ->with('return_discount_rate', $return_discount_rate)
                ->with('received_counter', $received_counter)
                ->with('bo_counter', $bo_counter)
                ->with('invoice_counter', $invoice_counter)
                ->with('return_counter', $return_counter);
        }
    }
}
