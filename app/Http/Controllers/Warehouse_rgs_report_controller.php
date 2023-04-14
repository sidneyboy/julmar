<?php

namespace App\Http\Controllers;

use App\User;
use App\Return_good_stock;
use App\Sku_principal;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Warehouse_rgs_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')
                ->where('principal', '!=', 'none')
                ->get();
            return view('warehouse_rgs_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'warehouse_rgs_report',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_rgs_report_proceed(Request $request)
    {
        //return $request->input();
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $rgs = Return_good_stock::where('principal_id', $request->input('principal'))
                        ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                        ->get();

        return view('warehouse_rgs_report_proceed', [
            'rgs' => $rgs,
        ]);
    }
}
