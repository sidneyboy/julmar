<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice_raw;
use App\Sku_principal;
use App\Sku_add;
use App\Agent;
use App\Bad_order;
use App\Bad_order_details;
use App\Bad_order_draft;
use DB;
use Illuminate\Http\Request;

class Warehouse_bo_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);

            return view('warehouse_bo', [
                'user' => $user,
                'main_tab' => 'manage_custodian_main_tab',
                'sub_tab' => 'manage_custodian_sub_tab',
                'active_tab' => 'warehouse_bo',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function warehouse_bo_proceed(Request $request)
    {
        $barcode_checker = Sku_add::select('id')->where('barcode', $request->input('barcode'))->first();
        $agent = Agent::select('id', 'full_name')->get();
        if ($barcode_checker) {
            $draft_checker = Bad_order_draft::where('sku_id', $barcode_checker->id)->count();
            if ($draft_checker == 0) {
                $new_draft = new Bad_order_draft([
                    'sku_id' => $barcode_checker->id,
                    'user_id' => auth()->user()->id,
                ]);

                $new_draft->save();

                $draft = Bad_order_draft::where('user_id', auth()->user()->id)->get();

                return view('warehouse_bo_proceed', [
                    'draft' => $draft,
                    'agent' => $agent,
                ]);
            } else {
                $draft = Bad_order_draft::where('user_id', auth()->user()->id)->get();

                return view('warehouse_bo_proceed', [
                    'draft' => $draft,
                    'agent' => $agent,
                ]);
            }
        } else {
            return 'No Data Found!';
        }
    }

    public function warehouse_bo_final_summary(Request $request)
    {

        $draft = Bad_order_draft::whereIn('id', $request->input('id'))->get();
        $agent = Agent::select('id', 'full_name')->find($request->input('agent_id'));
        return view('warehouse_bo_final_summary', [
            'draft' => $draft,
            'agent' => $agent,
            'id' => $request->input('id'),
            'bo_quantity' => $request->input('bo_quantity'),
        ]);
    }

    public function warehouse_bo_saved(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        //return $request->input();

        $new_bo = new Bad_order([
            'agent_id' => $request->input('agent_id'),
            'user_id' => auth()->user()->id,
            'principal_id' => $request->input('principal_id'),
            'sku_type' => $request->input('sku_type'),
        ]);

        $new_bo->save();

        foreach ($request->input('sku_id') as $key => $data) {
            $new_bo_details = new Bad_order_details([
                'bad_order_id' => $new_bo->id,
                'sku_id' => $data,
                'quantity' => $request->input('bad_order_quantity')[$data],
            ]);

            $new_bo_details->save();

            // $sku_id = $request->input('sku_id')[$data];
            // $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            // $count_ledger_row = count($ledger_results);

            // if ($count_ledger_row > 0) {
            //     $running_balance = $ledger_results[0]->running_balance - $request->input('returned_quantity')[$data];
            //     $new_sku_ledger = new Sku_ledger([
            //         'sku_id' => $request->input('sku_id')[$data],
            //         'quantity' => $request->input('returned_quantity')[$data],
            //         'running_balance' => $running_balance,
            //         'user_id' => auth()->user()->id,
            //         'transaction_type' => 'releasing',
            //         'all_id' => $request->input('delivery_receipt')[$data],
            //         'principal_id' => $request->input('principal_id'),
            //         'sku_type' => $request->input('sku_type')[$data],
            //     ]);

            //     $new_sku_ledger->save();
            // } else {
            //     $new_sku_ledger = new Sku_ledger([
            //         'sku_id' => $request->input('sku_id')[$data],
            //         'quantity' => $request->input('returned_quantity')[$data],
            //         'running_balance' => $request->input('returned_quantity')[$data],
            //         'user_id' => auth()->user()->id,
            //         'transaction_type' => 'releasing',
            //         'all_id' => $request->input('delivery_receipt')[$data],
            //         'principal_id' => $request->input('principal_id'),
            //         'sku_type' => $request->input('sku_type')[$data],
            //     ]);

            //     $new_sku_ledger->save();
            // }
        }

        $deleted = Bad_order_draft::where('user_id', auth()->user()->id)->delete();

    }
}
