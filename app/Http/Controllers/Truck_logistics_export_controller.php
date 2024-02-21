<?php

namespace App\Http\Controllers;

use App\Logistics;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_logistics_export_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            $logistics = Logistics::select('id', 'driver')->where('arrival_date', null)->get();

            return view('truck_logistics_export', [
                'logistics' => $logistics,
                'user' => $user,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_logistics_export',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_logistics_export_proceed(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $logistics = Logistics::select('id', 'location_id', 'created_at', 'user_id', 'driver', 'truck_id', 'helper_1', 'helper_2')
            ->where('id', $request->input('logistics_id'))
            ->first();

        return view('truck_logistics_export_proceed',[
            'logistics' => $logistics,
        ])->with('date',$date);
    }
}
