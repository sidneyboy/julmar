<?php

namespace App\Http\Controllers;
use App\Sku_principal;
use App\Bodega_out;
use App\Bodega_out_details;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bodega_out_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('bodega_out_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'bodega_out_report',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bodega_out_report_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));



        $bodega_out = bodega_out::where('principal_id', $request->input('principal'))->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('bodega_out_report_list', [
            'bodega_out' => $bodega_out
        ]);
    }

    public function bodega_out_show_details($id)
    {
 
        $bodega_out = bodega_out::find($id);
        $bodega_out_details = Bodega_out_details::where('bodega_out_id',$id)->get();

        return view('bodega_out_show_details',[
            'bodega_out' => $bodega_out,
            'bodega_out_details' => $bodega_out_details,
        ]);
    }
}
