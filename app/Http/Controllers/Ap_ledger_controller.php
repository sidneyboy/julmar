<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\User;
use App\Sku_principal;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Ap_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('ap_subsidiary_ledger', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_ledger_main_tab',
                'sub_tab' => 'manage_ledger_sub_tab',
                'active_tab' => 'ap_subsidiary_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function ap_ledger_subsidiary_ledger_show_report_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $ap_ledger = Ap_ledger::where('principal_id', $request->input('principal'))
            ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->get();

        return view('ap_ledger_subsidiary_ledger_show_report_list', [
            'ap_ledger' => $ap_ledger,
        ]);
    }

    public function ap_general_ledger()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('ap_general_ledger', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_ledger_main_tab',
                'sub_tab' => 'manage_ledger_sub_tab',
                'active_tab' => 'ap_general_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function ap_ledger_general_ledger_show_report_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $ap_ledger_debit_credit = Ap_ledger::select(
            DB::raw('sum(debit_record) as total_dr'),
            DB::raw('sum(credit_record) as total_cr'),
        )->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->first();


        $ap_ledger_running_balance = Ap_ledger::select(
            'running_balance',
        )->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->groupBy('principal_id')
            ->where('transaction', 'beginning')
            ->get();

        foreach ($ap_ledger_running_balance as $key => $data) {
            $running_balance[] = $data->running_balance;
        }

        return view('ap_ledger_general_ledger_show_report_list', [
            'ap_ledger_debit_credit' => $ap_ledger_debit_credit,
            'running_balance' => $running_balance,
        ]);
    }
}
