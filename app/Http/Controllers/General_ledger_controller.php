<?php

namespace App\Http\Controllers;

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

    public function general_ledger_generate(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $general_ledger = General_ledger::whereBetween('transaction_date',  [$date_from, $date_to])->get();

        return view('general_ledger_generate',[
            'general_ledger' => $general_ledger,
        ]);

    }
}
