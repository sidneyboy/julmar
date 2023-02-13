<?php

namespace App\Http\Controllers;
use App\Sku_principal;
use App\Principal_ledger;
use App\User;
use Illuminate\Http\Request;

class Principal_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal_data = Sku_principal::get();
            return view('principal_ledger', [
                'user' => $user,
                'principal_data' => $principal_data,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'principal_ledger',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function principal_ledger_generate_report(Request $request)
    {
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $principal_ledger = Principal_ledger::where('principal_id', $request->input('principal'))->whereBetween('date', [$date_from, $date_to])->get();

        $principal_ledger_counter = count($principal_ledger);

        if ($principal_ledger_counter != 0) {
            return view('principal_ledger_generate_report', [
                'principal_ledger' => $principal_ledger,
            ]);
        } else {
            return 'no_data';
        }
    }
}
