<?php

namespace App\Http\Controllers;

use App\Chart_of_accounts;
use App\Chart_of_accounts_details;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Chart_of_accounts_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            return view('chart_of_accounts', [
                'user' => $user,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'chart_of_accounts',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function chart_of_accounts_transaction(Request $request)
    {
        $chart_of_accounts = Chart_of_accounts::select('account_name', 'account_number', 'id')
            ->get();

        return view('chart_of_accounts_transaction', [
            'chart_of_accounts' => $chart_of_accounts,
        ])->with('transaction', $request->input('transaction'));
    }

    public function chart_of_accounts_transaction_proceed(Request $request)
    {
        return view('chart_of_accounts_transaction_proceed')
            ->with('transaction', $request->input('transaction'))
            ->with('first_input', strtoupper($request->input('first_input')));
    }

    public function chart_of_accounts_final_summary(Request $request)
    {
        if ($request->input('transaction') == 'insert_subsidiary_ledger') {
            $fetch_chart_of_account = Chart_of_accounts_details::select('account_number', 'chart_of_accounts_id')
                ->where('chart_of_accounts_id', $request->input('first_input'))
                ->orderBy('id', 'desc')
                ->first();
        } else {
            $fetch_chart_of_account = '';
        }

        $second_input_checker = $request->input('second_input');
        if (isset($second_input_checker)) {
            $second_input = array_filter($request->input('second_input'));
        } else {
            $second_input = 0;
        }

        return view('chart_of_accounts_final_summary', [
            'fetch_chart_of_account' => $fetch_chart_of_account,
        ])->with('transaction', $request->input('transaction'))
            ->with('second_input', $second_input)
            ->with('first_input', strtoupper($request->input('first_input')))
            ->with('general_account_number', $request->input('general_account_number'));
    }

    public function chart_of_accounts_save(Request $request)
    {
        //return $request->input();

        if ($request->input('transaction') == 'new_general_ledger') {
            //return $request->input();
            $new = new Chart_of_accounts([
                'account_name' => strtoupper($request->input('general_ledger_account_name')),
                'account_number' => $request->input('general_ledger_account_number'),
            ]);

            $new->save();

            if ($request->input('subsidiary_ledger_account_name')) {
                for ($i = 0; $i < count($request->input('subsidiary_ledger_account_name')); $i++) {
                    $details = new Chart_of_accounts_details([
                        'chart_of_accounts_id' => $new->id,
                        'account_name' => strtoupper($request->input('subsidiary_ledger_account_name')[$i]),
                        'account_number' => $request->input('subsidiary_ledger_account_number')[$i],
                    ]);

                    $details->save();
                }
            }
        } else {
            for ($i = 0; $i < count($request->input('subsidiary_ledger_account_name')); $i++) {
                $details = new Chart_of_accounts_details([
                    'chart_of_accounts_id' => $request->input('chart_account_id'),
                    'account_name' => strtoupper($request->input('subsidiary_ledger_account_name')[$i]),
                    'account_number' => $request->input('subsidiary_ledger_account_number')[$i],
                ]);

                $details->save();
            }
        }
    }
}
