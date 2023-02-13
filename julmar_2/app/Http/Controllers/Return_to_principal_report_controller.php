<?php

namespace App\Http\Controllers;

use App\Return_to_principal;
use App\Sku_principal;
use App\Return_to_principal_details;
use App\Principal_discount;
use App\User;
use Illuminate\Http\Request;

class Return_to_principal_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $return_to_principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('return_to_principal_report', [
                'user' => $user,
                'return_to_principal' => $return_to_principal,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'return_to_principal_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function return_to_principal_report_data(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $variable_explode = explode('=', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];

        $return_to_principal_data = Return_to_principal::where('principal_id', $principal_id)->whereBetween('date', [$date_from, $date_to])->get();

        return view('return_to_principal_reports_show_list', [
            'return_to_principal_data' => $return_to_principal_data
        ]);
    }

    public function return_to_principal_show_list_details(Request $request, $id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');


        $variable_explode = explode('=', $id);
        $return_id = $variable_explode[0];
        $principal_name = $variable_explode[1];

        $return_to_principal = Return_to_principal::find($return_id);
        $return_details_data = Return_to_principal_details::where('return_to_principal_id', $return_id)->get();

        $principal_discount = Principal_discount::select('id', 'total_discount', 'total_bo_allowance_discount')->find($return_to_principal->received->principal_discount_id);
        $user = User::where('id', auth()->user()->id)->first();
        return view('return_to_principal_show_list_details', [
            'return_details_data' => $return_details_data
        ])->with('principal_name', $principal_name)
            ->with('date', $date)
            ->with('prepared_by', $user)
            ->with('return_id', $return_id)
            ->with('return_to_principal', $return_to_principal)
            ->with('principal_discount', $principal_discount);
    }
}
