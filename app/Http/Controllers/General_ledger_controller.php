<?php

namespace App\Http\Controllers;

use App\Chart_of_accounts;
use App\Chart_of_accounts_details;
use App\General_ledger;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class General_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            // $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('general_ledger', [
                'user' => $user,
                // 'principal' => $principal,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'general_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function general_ledger_show_report_type(Request $request)
    {
        //return $request->input();
        if ($request->input('report_type') == 'general_ledger') {
            $chart_of_accounts = Chart_of_accounts::select('id', 'account_name')->get();

            return view('general_ledger_show_report_type', [
                'chart_of_accounts' => $chart_of_accounts,
            ])->with('report_type', $request->input('report_type'));
        } elseif ($request->input('report_type') == 'subsidiary_ledger') {
            $chart_of_accounts = Chart_of_accounts_details::select('id', 'account_name')->get();

            return view('general_ledger_show_report_type', [
                'chart_of_accounts' => $chart_of_accounts,
            ])->with('report_type', $request->input('report_type'));
        } else {
            $chart_of_accounts = Chart_of_accounts_details::select('id', 'account_name')->get();

            return view('general_ledger_show_report_type', [
                'chart_of_accounts' => $chart_of_accounts,
            ])->with('report_type', $request->input('report_type'));
        }
    }

    public function general_ledger_generate(Request $request)
    {
        //return $request->input();
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        if ($request->input('report_type') == 'general_ledger') {
            $chart_of_accounts = Chart_of_accounts::find($request->input('report_selection'));

            $general_ledger = General_ledger::where('general_account_number', $chart_of_accounts->account_number)
                ->whereBetween('transaction_date',  [$date_from, $date_to])
                ->orderBy('created_at')
                ->get();
        } elseif ($request->input('report_type') == 'subsidiary_ledger') {
            $chart_of_accounts = Chart_of_accounts_details::find($request->input('report_selection'));

            $general_ledger = General_ledger::where('account_number', $chart_of_accounts->account_number)
                ->whereBetween('transaction_date',  [$date_from, $date_to])
                ->orderBy('created_at')
                ->get();
        }else{
            
            // $ledger_data = DB::select("SELECT * FROM sku_ledgers WHERE id IN (SELECT MAX(id) FROM sku_ledgers
            // WHERE principal_id = '$principal_id' GROUP BY sku_id)");
        }

        return view('general_ledger_generate', [
            'general_ledger' => $general_ledger,
        ]);
    }
}
