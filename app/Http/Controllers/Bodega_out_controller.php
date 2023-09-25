<?php

namespace App\Http\Controllers;

use App\Sku_add;
use DB;
use App\Sku_ledgers;
use App\Sku_price_details;
use App\Sku_principal;
use App\Bodega_out;
use App\Bodega_out_details;
use App\Sku_ledger;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bodega_out_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')
                ->where('principal', '!=', 'none')
                ->where('principal', '!=', 'EPI')
                ->get();
            return view('bodega_out', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'bodega_out',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bodega_out_show_input(Request $request)
    {

        $variable_explode = explode('=', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];
        $sku_add = Sku_add::select('id', 'description', 'sku_code', 'category_id', 'sku_type')
            ->where('sku_type', $request->input('sku_type'))
            ->where('principal_id', $principal_id)
            ->get();

        return view('bodega_out_input', [
            'sku_add' => $sku_add,
        ])->with('sku_type', $request->input('sku_type'))
            ->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name);
    }

    public function show_equivalent(Request $request)
    {

        $equivalent_butal_pcs = Sku_add::select('equivalent_butal_pcs')->find($request->input('sku'));

        return $equivalent_butal_pcs->equivalent_butal_pcs;
    }

    public function bodega_out_summary(Request $request)
    {

        //return $request->input();
        $sku_add = Sku_add::find($request->input('sku'));
        $id = $request->input('sku');

        if ($sku_add->equivalent_sku_entryNo == 0 or '') {
            if ($request->input('sku_type') == 'Case') {
                return 'There is no equivalent butal for this SKU';
            } else {
                return 'There is no equivalent case for this SKU';
            }
        } else {
            $equivalents = Sku_add::find($sku_add->equivalent_sku_entryNo);
            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $count_ledger_counter = count($ledger_results);

            return view('bodega_out_final_summary')
                ->with('convert', $request->input('convert'))
                ->with('uom', $request->input('uom'))
                ->with('ledger_results', $ledger_results)
                ->with('sku_add', $sku_add)
                ->with('equivalents', $equivalents)
                ->with('sku_type', $request->input('sku_type'))
                ->with('count_ledger_counter', $count_ledger_counter)
                ->with('principal_id', $request->input('principal_id'));
        }
    }

    public function bodega_out_saved(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $new_bodega_out = new Bodega_out([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'remarks' => $request->input('remarks'),
            'date' => $date,
        ]);

        $new_bodega_out->save();

        $new_bodega_out_details = new Bodega_out_details([
            'bodega_out_id' => $new_bodega_out->id,
            'out_from_sku_id' => $request->input('out_from_sku_id'),
            'out_from_quantity' => $request->input('out_from_quantity'),
            'in_to_sku_id' => $request->input('in_to_sku_id'),
            'in_to_quantity' => $request->input('in_to_quantity'),
        ]);

        $new_bodega_out_details->save();

        $out_from_sku_id = $request->input('out_from_sku_id');

        $out_from_sku_ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$out_from_sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
        $out_from_sku_count_ledger_row = count($out_from_sku_ledger_results);

        $sku_type_data_first = Sku_add::select('sku_type')->find($out_from_sku_id);

        if ($out_from_sku_count_ledger_row > 0) {
            $out_from_sku_running_balance = $out_from_sku_ledger_results[0]->running_balance - $request->input('out_from_quantity');
            $average_cost = $out_from_sku_ledger_results[0]->running_amount / $out_from_sku_ledger_results[0]->running_balance;
            $amount = ($average_cost * $request->input('out_from_quantity')) * -1;
            $out_from_sku_ledger_new_sku_ledger = new Sku_ledger([
                'sku_id' => $out_from_sku_id,
                'quantity' => $request->input('out_from_quantity'),
                'running_balance' => $out_from_sku_running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'bodega out',
                'all_id' => $new_bodega_out->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $sku_type_data_first->sku_type,
                'final_unit_cost' => $average_cost,
                'amount' => $amount,
                'running_amount' => $out_from_sku_ledger_results[0]->running_amount + $amount,
            ]);

            $out_from_sku_ledger_new_sku_ledger->save();
        } else {
            return 'no_inventory';
        }

        $in_to_sku_id = $request->input('in_to_sku_id');

        $in_to_sku_ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$in_to_sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
        $in_to_sku_count_ledger_row = count($in_to_sku_ledger_results);

        $sku_type_data_second = Sku_add::select('sku_type')->find($in_to_sku_id);

        if ($in_to_sku_count_ledger_row > 0) {
            $in_to_sku_running_balance = $in_to_sku_ledger_results[0]->running_balance + $request->input('in_to_quantity');
            $out_from_sku_running_balance = $in_to_sku_ledger_results[0]->running_balance + $request->input('in_to_quantity');
            $average_cost = $in_to_sku_ledger_results[0]->running_amount / $in_to_sku_ledger_results[0]->running_balance;
            $amount = $average_cost * $request->input('out_from_quantity');
            $in_to_sku_ledger_new_sku_ledger = new Sku_ledger([
                'sku_id' => $in_to_sku_id,
                'quantity' => $request->input('in_to_quantity'),
                'running_balance' => $in_to_sku_running_balance,
                'user_id' => auth()->user()->id,
                'transaction_type' => 'bodega in',
                'all_id' => $new_bodega_out->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $sku_type_data_second->sku_type,
                'final_unit_cost' => $average_cost,
                'amount' => $amount,
                'running_amount' => $in_to_sku_ledger_results[0]->running_amount + $amount,
            ]);

            $in_to_sku_ledger_new_sku_ledger->save();
        } else {
            $in_to_sku_ledger_new_sku_ledger = new Sku_ledger([
                'sku_id' => $in_to_sku_id,
                'quantity' => $request->input('in_to_quantity'),
                'running_balance' => $request->input('in_to_quantity'),
                'user_id' => auth()->user()->id,
                'transaction_type' => 'bodega in',
                'all_id' => $new_bodega_out->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $sku_type_data_second->sku_type,
                'final_unit_cost' => 0,
                'amount' => 0,
                'running_amount' => 0,
            ]);

            $in_to_sku_ledger_new_sku_ledger->save();
        }

        return 'saved';
    }
}
