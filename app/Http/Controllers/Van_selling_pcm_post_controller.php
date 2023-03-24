<?php

namespace App\Http\Controllers;

use App\User;
use App\Vs_pcm;
use App\Vs_inventory_ledger;
use App\Sku_ledger;
use DB;
use Illuminate\Http\Request;

class Van_selling_pcm_post_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $pcm = Vs_pcm::where('status', null)->get();
            return view('van_selling_pcm_post', [
                'user' => $user,
                'pcm' => $pcm,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_pcm_post',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_pcm_post_generate(Request $request)
    {
        $pcm = Vs_pcm::find($request->input('pcm_id'));

        return view('van_selling_pcm_post_generate', [
            'pcm' => $pcm
        ]);
    }

    public function van_selling_pcm_post_save(Request $request)
    {
        //return $request->input();
        Vs_pcm::where('id', $request->input('pcm_id'))
            ->update([
                'status' => 'posted',
                'posted_by' => auth()->user()->id,
            ]);

        $pcm = Vs_pcm::select('id', 'customer_id')->find($request->input('pcm_id'));
        $customer_id = $pcm->customer_id;
        foreach ($pcm->pcm_details as $key => $details) {
            $sku_id = $details->sku_id;

            if ($details->remarks == 'BO') {
                $ledger_results =  DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_id = '$sku_id' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                $new_inventory_ledger = new Vs_inventory_ledger([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $customer_id,
                    'principal_id' => $ledger_results[0]->principal_id,
                    'transaction' => 'credit memo',
                    'sku_id' => $details->sku_id,
                    'beginning_inventory' => $ledger_results[0]->ending_inventory,
                    'quantity' => ($details->quantity) * -1,
                    'ending_inventory' => $ledger_results[0]->ending_inventory - $details->quantity,
                    'unit_price' => $details->unit_price,
                    'all_id' => $request->input('pcm_id'),
                    'sku_code' => $ledger_results[0]->sku_code,
                ]);
                $new_inventory_ledger->save();
            } else {
                $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                $running_balance = $ledger_results[0]->running_balance + $details->quantity;
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $sku_id,
                    'quantity' => $details->quantity,
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'vs credit memo',
                    'all_id' => $request->input('pcm_id'),
                    'principal_id' => $ledger_results[0]->principal_id,
                    'sku_type' => $ledger_results[0]->sku_type,
                ]);

                $new_sku_ledger->save();
            }
        }
    }
}
