<?php

namespace App\Http\Controllers;
use App\User;
use App\Bad_order;
use App\Return_good_stock;
use Illuminate\Http\Request;

class Warehouse_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);
            $bo = Bad_order::select('id','pcm_number','principal_id','agent_id')->get();
            $rgs = Return_good_stock::select('id','pcm_number','principal_id','agent_id')->get();
            return view('warehouse_pcm', [
                'user' => $user,
                'bo' => $bo,
                'rgs' => $rgs,
                'main_tab' => 'manage_custodian_main_tab',
                'sub_tab' => 'manage_custodian_sub_tab',
                'active_tab' => 'warehouse_pcm',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_pcm_proceed(Request $request)
    {
        $explode = explode('-',$request->input('pcm_id'));
        $type = $explode[0];
        $id = $explode[1];

        if ($type == 'rgs') {
            $pcm = Return_good_stock::find($id);
        }else if($type == 'bo'){
            $pcm = Bad_order::find($id);
        }

        return view('warehouse_pcm_proceed',[
            'pcm' => $pcm
        ])->with('type',$type)
        ->with('id',$id);
    }


    public function warehouse_pcm_final_summary(Request $request)
    {
        if ($type == 'rgs') {
            $pcm = Return_good_stock::find($id);
        }else if($type == 'bo'){
            $pcm = Bad_order::find($id);
        }
    }
}
