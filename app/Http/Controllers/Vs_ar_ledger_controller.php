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

        $ledger = Van_selling_ar_ledger::where('customer_id',$request->input('customer_id'))
                ->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('van_selling_ar_ledger_generate_data',[
            'ledger' => $ledger,
        ]);
    }
}
