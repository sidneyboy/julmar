<?php

namespace App\Http\Controllers;


use App\User;
use App\Bad_order;
use App\Sku_principal;
use DB;
use Illuminate\Http\Request;

class Warehouse_bo_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')
                ->where('principal', '!=', 'none')
                ->get();
            return view('warehouse_bo_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'warehouse_bo_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_bo_report_proceed(Request $request)
    {
        //return $request->input();
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $bo = Bad_order::where('principal_id', $request->input('principal'))
                        ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                        ->get();

        return view('warehouse_bo_report_proceed', [
            'bo' => $bo,
        ]);
    }
}
