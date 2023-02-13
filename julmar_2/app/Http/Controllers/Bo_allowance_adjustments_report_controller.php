<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use Session;
use App\Bo_allowance_adjustments;
use App\Bo_allowance_adjustments_details;
use App\User;
use Illuminate\Http\Request;

class Bo_allowance_adjustments_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('bo_allowance_adjustments_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'bo_allowance_adjustments_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bo_allowance_adjustments_generate_report(Request $request)
    {

        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));



        $bo_adjustments_data = Bo_allowance_adjustments::where('principal_id', $request->input('principal'))->whereBetween('date', [$date_from, $date_to])->get();

        return view('bo_allowance_adjustments_report_list', [
            'bo_adjustments_data' => $bo_adjustments_data
        ]);
    }

    public function bo_allowance_adjustments_show_details($id)
    {
        $variable_explode = explode('=', $id);
        $id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $particulars = $variable_explode[2];
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $user = User::select('name')->where('id', auth()->user()->id)->first();
        $bo_adjustments_details = Bo_allowance_adjustments_details::where('bo_allowance_id', $id)->get();
        $bo_total_adjusted_amount = Bo_allowance_adjustments::select('bo_allowance_deduction', 'vat_deduction', 'net_deduction')->where('id', $id)->first();
        return view('bo_allowance_adjustments_show_details', [
            'bo_adjustments_details' => $bo_adjustments_details,
        ])->with('principal_name', $principal_name)
            ->with('prepared_by', $user)
            ->with('date', $date)
            ->with('id', $id)
            ->with('particulars', $particulars)
            ->with('bo_total_adjusted_amount', $bo_total_adjusted_amount);
    }
}
