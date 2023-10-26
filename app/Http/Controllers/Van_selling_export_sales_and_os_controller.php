<?php

namespace App\Http\Controllers;

use App\User;
use App\Vs_os_details;
use App\Vs_sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Van_selling_export_sales_and_os_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('van_selling_export_sales_and_os', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_export_sales_and_os',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_export_sales_and_os_generate(Request $request)
    {
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        if ($request->input('report_type') == 'os') {
            $van_data = Vs_os_details::whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->orderBy('id', 'desc')->get();
        } elseif ($request->input('report_type') == 'van_selling_sales') {
            $van_data = Vs_sales::whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->orderBy('id', 'desc')->get();
        }

        return view('van_selling_export_sales_and_os_generate', [
            'van_data' => $van_data,
        ])->with('report_type', $request->input('report_type'));
    }
}
