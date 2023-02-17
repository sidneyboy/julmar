<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Van_selling_ar_ledger;
use Illuminate\Http\Request;

class Van_selling_actual_stocks_on_hand_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $van_selling_agent = Customer::select('store_name', 'id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_actual_stocks_on_hand', [
                'user' => $user,
                'van_selling_agent' => $van_selling_agent,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_actual_stocks_on_hand',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_actual_stocks_on_hand_proceed(Request $request)
    {

        $van_selling_ledger = Van_selling_ar_ledger::select('principal_id', 'customer_id', 'amount', 'collection', 'cm_amount', 'running_balance', 'date')->where('customer_id', $request->input('store_id'))->orderBy('id', 'desc')->first();

        if ($van_selling_ledger) {
            return view('van_selling_actual_stocks_on_hand_proceed')->with('van_selling_ledger', $van_selling_ledger)
                ->with('customer_id', $request->input('store_id'));
        } else {
            return 'No AR Ledger';
        }
    }

    public function van_selling_actual_stocks_on_hand_final_summary(Request $request)
    {
        $user = User::select('position')->where('secret_key', $request->input('password'))->first();

        if ($user) {
            if ($user->position == 'Audit_head' || $user->position == 'Audit_staff') {
                return view('van_selling_actual_stocks_on_hand_final_summary')
                    ->with('actual_stocks_on_hand', str_replace(',', '', $request->input('actual_stocks_on_hand')))
                    ->with('amount', $request->input('amount'))
                    ->with('cm_amount', $request->input('cm_amount'))
                    ->with('collection', $request->input('collection'))
                    ->with('customer_id', $request->input('customer_id'))
                    ->with('date', $request->input('date'))
                    ->with('password', $request->input('password'))
                    ->with('reference', $request->input('reference'))
                    ->with('running_balance', $request->input('running_balance'))
                    ->with('store_name', $request->input('store_name'));
            } else {
                return 'access_denied';
            }
        } else {
            return 'access_denied';
        }
    }

    public function van_selling_actual_stocks_on_hand_save(Request $request)
    {
        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $van_search = Van_selling_ar_ledger::select('should_be', 'over_short', 'outstanding_balance')->where('customer_id', $request->input('customer_id'))->latest()->first();

        $over_short = $van_search->over_short + $request->input('over_short');

        if ($over_short > 0) {
            if ($van_search->running_balance == 0) {
                $van_selling_ledger_save = new Van_selling_ar_ledger([
                    'customer_id' => $request->input('customer_id'),
                    'cm_amount' => 0,
                    'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
                    'amount' => 0,
                    'collection' => 0,
                    'over_short' => $over_short,
                    'running_balance' => $request->input('running_balance'),
                    'user_id' => auth()->user()->id,
                    'outstanding_balance' => $request->input('running_balance'),
                    'date' => $date,
                ]);

                $van_selling_ledger_save->save();
                return 'saved';
            } else {
                $van_selling_ledger_save = new Van_selling_ar_ledger([
                    'customer_id' => $request->input('customer_id'),
                    'cm_amount' => 0,
                    'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
                    'amount' => 0,
                    'collection' => 0,
                    'over_short' => $over_short,
                    'running_balance' => $request->input('running_balance'),
                    'user_id' => auth()->user()->id,
                    'outstanding_balance' => $van_search->running_balance,
                    'date' => $date,
                ]);

                $van_selling_ledger_save->save();
                return 'saved';
            }
        } else {

            if ($van_search->outstanding_balance == 0) {
                $van_selling_ledger_save = new Van_selling_ar_ledger([
                    'customer_id' => $request->input('customer_id'),
                    'cm_amount' => 0,
                    'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
                    'amount' => 0,
                    'collection' => 0,
                    'over_short' => $van_search->over_short,
                    'running_balance' => $request->input('running_balance'),
                    'user_id' => auth()->user()->id,
                    'outstanding_balance' => $request->input('running_balance'),
                    'date' => $date,
                ]);

                $van_selling_ledger_save->save();
                return 'saved';
            } else {
                $van_selling_ledger_save = new Van_selling_ar_ledger([
                    'customer_id' => $request->input('customer_id'),
                    'cm_amount' => 0,
                    'actual_stocks_on_hand' => $request->input('actual_stocks_on_hand'),
                    'amount' => 0,
                    'collection' => 0,
                    'over_short' => $van_search->over_short,
                    'running_balance' => $request->input('running_balance'),
                    'user_id' => auth()->user()->id,
                    'outstanding_balance' => $request->input('running_balance'),
                    'date' => $date,
                ]);

                $van_selling_ledger_save->save();

                $new_vanload = ($request->input('running_balance') - $request->input('actual_stocks_on_hand')) * -1;

                $new_running_outstanding_balance = $new_vanload + $request->input('running_balance');

                $new_van_selling_ledger_saved_van_load = new Van_selling_ar_ledger([
                    'customer_id' => $request->input('customer_id'),
                    'user_id' => auth()->user()->id,
                    'over_short' => $van_search->over_short,
                    'amount' => $new_vanload,
                    'running_balance' => $new_running_outstanding_balance,
                    'outstanding_balance' => $new_running_outstanding_balance,
                    'date' => $date,
                    'remarks' => 'Adjustment vanload base on actual stocks on hand (OVER)',
                ]);

                $new_van_selling_ledger_saved_van_load->save();
            }
        }
    }
}
