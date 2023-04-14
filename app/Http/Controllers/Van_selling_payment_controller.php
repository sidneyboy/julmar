<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Van_selling_ar_ledger;
use App\Vs_collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Van_selling_payment_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('store_name', 'id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_payment', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_payment',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_payment_search_store_code(Request $request)
    {
        $ledger = Van_selling_ar_ledger::where('customer_id', $request->input('customer_id'))->latest()->first();

        return view('van_selling_payment_search_store_code', [
            'ledger' => $ledger,
        ])->with('customer_id', $request->input('customer_id'))
            ->with('bank', $request->input('bank'))
            ->with('reference', $request->input('reference'))
            ->with('remarks', $request->input('remarks'))
            ->with('amount', str_replace(',', '', $request->input('amount')));
    }

    public function van_selling_payment_save(Request $request)
    {
       // return $request->input();

        $new_collection = new Vs_collection([
            'user_id' => auth()->user()->id,
            'customer_id' => $request->input('customer_id'),
            'total_amount' => $request->input('amount'),
            'bank' => $request->input('bank'),
            'reference' => $request->input('reference'),
            'remarks' => $request->input('remarks'),
        ]);

        $new_collection->save();

        $new = new Van_selling_ar_ledger([
            'customer_id' => $request->input('customer_id'),
            'user_id' => auth()->user()->id,
            'transaction' => 'collection',
            'all_id' => $new_collection->id,
            'running_balance' => $request->input('running_balance'),
            'amount' => $request->input('amount')*-1,
            'short' => 0,
            'outstanding_balance' => $request->input('running_balance') - $request->input('amount'),
            'remarks' => $request->input('remarks'),
        ]);

        $new->save();
    }
}
