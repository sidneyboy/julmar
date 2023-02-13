<?php

namespace App\Http\Controllers;

use App\User;
use App\Received_purchase_order;
use App\Sku_principal;
use App\Principal_ledger;
use Illuminate\Http\Request;

class Bo_allowance_total_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_data = Received_purchase_order::orderBy('id', 'desc', 'purchase_order_id', 'dr_si')->get();
            $principals = Sku_principal::where('principal', '!=', 'none')->get();
            return view('bo_allowance_total', [
                'user' => $user,
                'received_data' => $received_data,
                'principals' => $principals,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'bo_allowance_total',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bo_allowance_total_generate_page(Request $request)
    {

        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $received = Received_purchase_order::where('principal_id', $request->input('principal'))->whereBetween('date', [$date_from, $date_to])->get();

        return view('bo_allowance_total_generate_page', [
            'received' => $received,
        ])->with('remarks', $request->input('remarks'))
            ->with('principal', $request->input('principal'))
            ->with('date_range', $request->input('date_range'));
    }

    public function bo_allowance_total_proceed_to_final_summary(Request $request)
    {
        //return $request->input();
        $received = Received_purchase_order::findMany($request->input('dr_id'));
        return view('bo_allowance_total_proceed_to_final_summary_page', [
            'received' => $received,
        ])->with('bo_rate', $request->input('bo_rate'))
            ->with('remarks', $request->input('remarks'))
            ->with('principal', $request->input('principal'))
            ->with('date_range', $request->input('date_range'));
    }

    public function bo_allowance_total_save(Request $request)
    {
        // $request->input();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal'))->orderBy('id', 'DESC')->limit(1)->first();

        $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
        $principal_ledger_saved = new Principal_ledger([
            'principal_id' => $request->input('principal'),
            'date' => $date,
            'rr_dr' => '',
            'principal_invoice' => '',
            'transaction' => 'bo total adjustments',
            'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            'received' => 0,
            'returned' => 0,
            'adjustment' => $request->input('bo_allowance_total_adjustment') * -1,
            'payment' => 0,
            'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('bo_allowance_total_adjustment'),
        ]);
        $principal_ledger_saved->save();

        return 'saved';
    }
}
