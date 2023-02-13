<?php

namespace App\Http\Controllers;
use App\Sku_principal;
use App\Bodega_out;
use App\Bodega_out_details;
use App\User;
use Illuminate\Http\Request;

class Bodega_out_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bodega_out_report_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));



        $bodega_out = bodega_out::where('principal_id', $request->input('principal'))->whereBetween('date', [$date_from, $date_to])->get();

        return view('bodega_out_report_list', [
            'bodega_out' => $bodega_out
        ]);
    }

    public function bodega_out_show_details($id)
    {
        $variable_explode = explode('=', $id);
        $id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $remarks = $variable_explode[2];

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $user = User::select('name')->where('id', auth()->user()->id)->first();
        $bodega_out_details = bodega_out_details::where('bodega_out_id', $id)->first();

        $explode_prices = explode('=', $bodega_out_details->fuc_prices);
        $final_unit_cost = $explode_prices[0];
        $price_1 = $explode_prices[1];
        $price_2 = $explode_prices[2];
        $price_3 = $explode_prices[3];

        return view('bodega_out_show_details')->with('principal_name', $principal_name)
            ->with('prepared_by', $user)
            ->with('date', $date)
            ->with('id', $id)
            ->with('remarks', $remarks)
            ->with('bodega_out_details', $bodega_out_details)
            ->with('price_1', $price_1)
            ->with('price_2', $price_2)
            ->with('price_3', $price_3)
            ->with('final_unit_cost', $final_unit_cost);
    }
}
