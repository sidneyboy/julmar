<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_category;
use App\Sku_principal;
use App\Sku_add;
use DB;
use App\Sku_ledger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Sku_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
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
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function search_inventory_ledger(Request $request)
    {
        $principal_id = $request->input('principal_id');
        $sku_type = $request->input('sku_type');
        if ($sku_type == 'all') {
            $sku_ledger = DB::select("SELECT * FROM sku_ledgers WHERE id IN (SELECT MAX(id) FROM sku_ledgers
            WHERE principal_id = '$principal_id' GROUP BY sku_id)");
        }else{
            $sku_ledger = DB::select("SELECT * FROM sku_ledgers WHERE id IN (SELECT MAX(id) FROM sku_ledgers
            WHERE principal_id = '$principal_id' AND sku_type = '$sku_type' GROUP BY sku_id)");
        }

        for ($i=0; $i < count($sku_ledger); $i++) { 
            $description[] = Sku_add::select('sku_code','description','sku_type','id')->find($sku_ledger[$i]->sku_id); 
            $name[] = User::select('name')->find($sku_ledger[$i]->user_id);
        }
        

        return view('sku_ledger_show_data', [
            'sku_ledger' => $sku_ledger,
            'description' => $description,
            'name' => $name,
        ]);
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
