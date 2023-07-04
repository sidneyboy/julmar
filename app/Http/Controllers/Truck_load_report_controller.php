<?php

namespace App\Http\Controllers;

use App\User;
use App\Logistics;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_load_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('truck_load_report', [
                'user' => $user,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_load_report',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_load_report_show(Request $request)
    {
     
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $logistics = Logistics::whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('truck_load_report_show',[
            'logistics' => $logistics,
        ]);
    }
}
