<?php

namespace App\Http\Controllers;

use App\User;
use App\Return_good_stock;
use Illuminate\Http\Request;

class Warehouse_rgs_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
           
            return view('warehouse_rgs_report', [
                'user' => $user,
                'main_tab' => 'manage_custodian_main_tab',
                'sub_tab' => 'manage_custodian_sub_tab',
                'active_tab' => 'warehouse_rgs_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }
}
