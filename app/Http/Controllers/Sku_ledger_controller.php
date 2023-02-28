<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_category;
use App\Sku_principal;
use App\Sku_add;
use DB;
use App\Sku_ledger;

use Illuminate\Http\Request;

class Sku_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $sku_category = Sku_category::select('id', 'category')->get();
            $sku_principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('sku_ledger', [
                'user' => $user,
                'sku_category' => $sku_category,
                'sku_principal' => $sku_principal,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_ledger',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function search_inventory_ledger(Request $request)
    {
        $var = explode('-', $request->input('date_as_of'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));
        //return $request->input();


        

        return $messages = Sku_ledger::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT * FROM sku_ledgers ORDER BY created_at DESC) t'))
            ->where('principal_id',$request->input('principal_id'))
            ->where('sku_type', $request->input('sku_type'))
            ->groupBy('t.sku_id')
            ->get();
       
        // return $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE principal_id = '$principal_id' ORDER BY id DESC LIMIT 1)AS sku_id GROUP BY sku_id"));

        //select * from (select * from flights ORDER BY effective_from DESC) AS x GROUP BY

        // $check_principal = Sku_add::select('id')->where('sku_type', $request->input('sku_type'))->where('sku_code', $request->input('search_for'))->first();
        // if ($check_principal) {
        //     $sku_ledger = Sku_ledger::where('sku_id', $check_principal->id)->get();

        //     return view('sku_ledger_show_data',[
        //         'sku_ledger' => $sku_ledger,
        //     ]);
        // } else {
        //     return 'no_data';
        // }
    }

    public function sku_ledger_show_sku_details($id)
    {


        $variable_explode = explode('=', $id);
        $sku_id = $variable_explode[0];
        $date_from = $variable_explode[1];
        $date_to = $variable_explode[2];

        $sku_ledger_details = Sku_ledger::select('sku_id', 'in_out_adjustments', 'rr_dr', 'sales_order_number', 'principal_invoice', 'quantity', 'running_balance', 'unit_cost', 'total_cost', 'adjustments', 'running_total_cost', 'final_unit_cost', 'transaction_date', 'user_id')->where('sku_id', $sku_id)->whereBetween('transaction_date', [$date_from, $date_to])->get();

        $counter = count($sku_ledger_details);

        return view('sku_ledger_show_sku_details', [
            'sku_ledger_details' => $sku_ledger_details
        ])->with('date_from', $date_from)
            ->with('date_to', $date_to)
            ->with('counter', $counter);
    }
}
