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

    public function ap_ledger_subsidiary_cut_off($principal_id)
    {

        if (Auth::check()) {
            date_default_timezone_set('Asia/Manila');


            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $ap_ledger_last_beginning = Ap_ledger::select('created_at')
                ->where('principal_id', $principal_id)
                ->where('transaction', 'beginning')
                ->orderBy('id', 'desc')
                ->first();
            $date_from = date('Y-m-d', strtotime($ap_ledger_last_beginning->created_at));
            $date_now = date('Y-m-d');
            $ap_ledger = Ap_ledger::where('principal_id', $principal_id)
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_now])
                ->get();


            return view('ap_ledger_subsidiary_cut_off', [
                'user' => $user,
                'principal_id' => $principal_id,
                'ap_ledger' => $ap_ledger,
                'main_tab' => 'manage_ledger_main_tab',
                'sub_tab' => 'manage_ledger_sub_tab',
                'active_tab' => 'ap_subsidiary_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function ap_ledger_subsidiary_cut_off_save(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $ap_ledger_last_transaction = Ap_ledger::where('principal_id', $request->input('principal_id'))
            ->orderBy('id', 'desc')
            ->first();

        $new_cut_off = new Ap_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transaction_date' => $date,
            'description' => 'Cut off',
            'debit_record' => $ap_ledger_last_transaction->debit_record,
            'credit_record' => $ap_ledger_last_transaction->credit_record,
            'running_balance' => $ap_ledger_last_transaction->running_balance,
            'transaction' => 'cut off',
            'remarks' => $request->input('remarks'),
            'close_date' => $date,
        ]);

        $new_cut_off->save();

        $new_beginning = new Ap_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transaction_date' => $date,
            'description' => 'Beginning',
            'debit_record' => $ap_ledger_last_transaction->debit_record,
            'credit_record' => $ap_ledger_last_transaction->credit_record,
            'running_balance' => $ap_ledger_last_transaction->running_balance,
            'transaction' => 'beginning',
            'remarks' => '',
        ]);

        $new_beginning->save();
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

        $explode = explode(',', $request->input('principal'));
        $principal_id = $explode[0];
        $principal = $explode[1];

        $ap_ledger_debit_credit = Ap_ledger::select(
            DB::raw('sum(debit_record) as total_dr'),
            DB::raw('sum(credit_record) as total_cr'),
        )->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->where('principal_id', $principal_id)
            ->where('transaction','!=','beginning')
            ->where('transaction','!=','cut off')
            ->first();


        $ap_ledger_running_balance = Ap_ledger::select(
            'running_balance','id',
        )->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->where('principal_id',$principal_id)
            
            ->first();

        // foreach ($ap_ledger_running_balance as $key => $data) {
        //     $running_balance[] = $data->running_balance;
        // }

        return view('ap_ledger_general_ledger_show_report_list', [
            'ap_ledger_debit_credit' => $ap_ledger_debit_credit,
            'ap_ledger_running_balance' => $ap_ledger_running_balance,
            'principal' => $principal,
            // 'running_balance' => $running_balance,
        ]);
    }

    public function ap_ledger_general_ledger_show_search_type(Request $request)
    {
        if ($request->input('search_type') == 'per_cut_off_date') {
            $ap_ledger_beginning = Ap_ledger::select('created_at')->where('transaction', 'beginning')
                ->orderBy('id', 'desc')
                ->get();

            return view('ap_ledger_general_ledger_show_search_type', [
                'ap_ledger_beginning' => $ap_ledger_beginning,
            ]);
        } else {
            return 'date_range';
        }
    }
}
