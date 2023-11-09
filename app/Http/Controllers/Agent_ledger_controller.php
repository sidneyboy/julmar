<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Sales_invoice;
use App\Sku_principal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Agent_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $agent = Agent::select('id', 'full_name')->get();
            $principal = Sku_principal::select('id', 'principal')
                ->where('principal', '!=', 'none')
                ->get();
            return view('agent_ledger', [
                'user' => $user,
                'agent' => $agent,
                'principal' => $principal,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'agent_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function agent_ledger_generate(Request $request)
    {

        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $sales_invoice = Sales_invoice::where('principal_id', $request->input('principal_id'))
            ->where('agent_id', $request->input('agent_id'))
            ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->get();

        return view('agent_ledger_generate', [
            'sales_invoice' => $sales_invoice,
        ]);
    }
}
