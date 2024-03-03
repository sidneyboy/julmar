<?php

namespace App\Http\Controllers;

use App\Return_to_principal;
use App\Sku_principal;
use App\Return_to_principal_details;
use App\Principal_discount;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Return_to_principal_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('return_to_principal_reports', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'return_to_principal_reports',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
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

        $return_to_principal_data = Return_to_principal::where('principal_id', $principal_id)
                ->whereBetween('date',[$date_from,$date_to])
                ->orderBy('id','desc')
                ->get();
        //->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
        return view('return_to_principal_reports_show_list', [
            'return_to_principal_data' => $return_to_principal_data
        ]);
    }

    public function return_to_principal_show_list_details($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');

        $return_to_principal = Return_to_principal::select('id','received_id')->find($id);
        
  
        return view('return_to_principal_show_list_details', [
            'return_to_principal' => $return_to_principal
        ]);
    }
}
