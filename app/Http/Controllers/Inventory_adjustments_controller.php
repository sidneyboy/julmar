<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Sku_add;
use App\Sku_ledger;
use Illuminate\Http\Request;

class Inventory_adjustments_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('inventory_adjustments', [
                'user' => $user,
                'principal' => $principal,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'inventory_adjustments',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function inventory_adjustments_proceed(Request $request)
    {
        $sku = Sku_add::select('sku_code', 'id', 'description', 'sku_type')
            ->where('principal_id', $request->input('principal_id'))
            ->where('sku_type', $request->input('sku_type'))
            ->get();

        return view('inventory_adjustments_proceed', [
            'sku' => $sku,
        ]);
    }

    public function inventory_adjustments_proceed_to_final_summary(Request $request)
    {
        //return $request->input();
        $ledger = Sku_ledger::select('sku_id', 'running_balance', 'principal_id', 'sku_type')->where('sku_id', $request->input('sku_id'))
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        if ($ledger) {
            return view('inventory_adjustments_proceed_to_final_summary', [
                'ledger' => $ledger,
            ])->with('quantity', $request->input('quantity'));
        }else{
            return 'no_quantity';
        }
    }

    public function inventory_adjustments_saved(Request $request)
    {
        //return $request->input();
       $ledger = Sku_ledger::select('sku_id', 'running_balance', 'principal_id', 'sku_type','amount','running_amount')->where('sku_id', $request->input('sku_id'))
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        $total = $request->input('adjustments') * $ledger->amount;
        $running_amount = $ledger->running_amount + $total;
        $new = new Sku_ledger([
            'sku_id' => $request->input('sku_id'),
            'quantity' => 0,
            'user_id' => auth()->user()->id,
            'transaction_type' => 'inventory adjustment',
            'principal_id' => $request->input('principal_id'),
            'sku_type' => $request->input('sku_type'),
            'remarks' => $request->input('remarks'),
            'adjustments' => $request->input('adjustments'),
            'running_balance' => $ledger->running_balance + $request->input('adjustments'),
            'amount' => $ledger->amount,
            'running_amount' => $running_amount,
        ]);

        $new->save();
    }
}
