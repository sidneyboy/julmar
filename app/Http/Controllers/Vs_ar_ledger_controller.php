<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Van_selling_ar_ledger;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Vs_ar_ledger_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'kind_of_business')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_ar_ledger', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_ar_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_ar_ledger_generate_data(Request $request)
    {
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))
            ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('van_selling_ar_ledger_generate_data', [
            'ledger' => $ledger,
        ])->with('customer_id', $request->input('customer_id'));
    }

    public function van_selling_ar_ledger_adjustment()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'kind_of_business')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_ar_ledger_adjustment', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_ar_ledger',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_ar_ledger_adjustments_proceed(Request $request)
    {
        $ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        return view('van_selling_ar_ledger_adjustments_proceed', [
            'ledger' => $ledger,
            'customer_id' => $request->input('customer_id'),
            'remarks' => $request->input('remarks'),
            'adjustment' => str_replace(',', '', $request->input('adjustment')),
        ]);
    }

    public function van_selling_ar_ledger_adjustments_proceed_save(Request $request)
    {
        $ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))
            ->orderBy('id', 'desc')
            ->limit(1)
            ->first();

        $new = new Van_selling_ar_ledger([
            'customer_id' => $request->input('customer_id'),
            'user_id' => auth()->user()->id,
            'transaction' => 'adjustments',
            'all_id' => 'n/a',
            'running_balance' => $ledger->outstanding_balance,
            'amount' => $request->input('adjustment'),
            'short' => $ledger->short,
            'outstanding_balance' => $request->input('new_outstanding_balance'),
            'remarks' => $request->input('remarks'),
        ]);

        $new->save();
    }
}
