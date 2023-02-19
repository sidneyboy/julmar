<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use App\Van_selling_ar_ledger;
use Illuminate\Http\Request;

class Van_selling_ar_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_ar', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_ar',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_ar_generate(Request $request)
    {
        $explode = explode(',', $request->input('customer_id'));
        $customer_id = $explode[0];
        $store_name = $explode[1];

        return view('van_selling_ar_generate')
            ->with('customer_id', $customer_id)
            ->with('store_name', $store_name);
    }

    public function van_selling_ar_proceed_to_final_summary(Request $request)
    {

        return view('van_selling_ar_proceed_to_final_summary')
            ->with('actual_stocks_on_hand', str_replace(',', '', $request->input('actual_stocks_on_hand')))
            ->with('running_balance', str_replace(',', '', $request->input('running_balance')))
            ->with('store_name', $request->input('store_name'))
            ->with('customer_id', $request->input('customer_id'));
    }

    public function van_selling_ar_save(Request $request)
    {
       // return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        // if ($request->input('over_short') > 0) {
        //     $van_selling_ar_ledger = new Van_selling_ar_ledger([
        //         'customer_id' => $request->input('customer_id'),
        //         'should_be' => $request->input('running_balance'),
        //         'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
        //         'over' => 0,
        //         'short' => $request->input('over_short'),
        //         'user_id' => auth()->user()->id,
        //         'date' => $date,
        //     ]);

        //     $van_selling_ar_ledger->save();
        // }else{
        //     $van_selling_ar_ledger = new Van_selling_ar_ledger([
        //         'customer_id' => $request->input('customer_id'),
        //         'should_be' => $request->input('running_balance'),
        //         'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
        //         'over' => $request->input('over_short'),
        //         'short' => 0,
        //         'user_id' => auth()->user()->id,
        //         'date' => $date,
        //     ]);

        //     $van_selling_ar_ledger->save();
        // }

        $van_selling_ar_ledger = new Van_selling_ar_ledger([
            'customer_id' => $request->input('customer_id'),
            'running_balance' => $request->input('running_balance'),
            'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
            'outstanding_balance' => $request->input('running_balance'),
            'running_balance' => $request->input('running_balance'),
            'over_short' => $request->input('over_short'),
            'user_id' => auth()->user()->id,
            'date' => $date,
        ]);

        $van_selling_ar_ledger->save();

        return 'saved';

        // if ($request->input('over') != 0 AND $request->input('short') != 0) {
        // 	return 'error';
        // }else if ($request->input('over') != 0) {
        // 	$van_selling_ar_ledger = new Van_selling_ar_ledger([
        // 		'customer_id' => $request->input('customer_id'),
        //      'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
        //      'over_short' => $request->input('over')*-1,
        //      'running_balance' => $request->input('running_balance'),
        //      'user_id' => auth()->user()->id,
        //      'date' => $date,
        // 	]);

        // 	$van_selling_ar_ledger->save();

        // 	return 'saved';
        // }else if($request->input('short') != 0){
        // 	$van_selling_ar_ledger = new Van_selling_ar_ledger([
        // 		'customer_id' => $request->input('customer_id'),
        //      'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
        //      'over_short' => $request->input('short'),
        //      'running_balance' => $request->input('running_balance'),
        //      'user_id' => auth()->user()->id,
        //      'date' => $date,
        // 	]);

        // 	$van_selling_ar_ledger->save();

        // 	return 'saved';
        // }


    }
}
