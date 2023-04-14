<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use DB;
use App\Bo_allowance_adjustments;
use App\Bo_allowance_adjustments_details;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bo_allowance_adjustments_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
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
            return redirect('/')->with('error', 'Session Expired. /');
        }
    }

    public function bo_allowance_adjustments_generate_report(Request $request)
    {

        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $bo_adjustments_data = Bo_allowance_adjustments::where('principal_id', $request->input('principal'))->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('bo_allowance_adjustments_report_list', [
            'bo_adjustments_data' => $bo_adjustments_data
        ]);
    }

    public function bo_allowance_adjustments_show_details($id)
    {
        //return $id;
        $bo_adjustments_details = Bo_allowance_adjustments_details::where('bo_allowance_id', $id)->get();
        return view('bo_allowance_adjustments_show_details', [
            'bo_adjustments_details' => $bo_adjustments_details,
        ]);
    }
}
