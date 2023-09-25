<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\User;
use App\Sku_principal;
use App\Purchase_order;
use App\Principal_ledger;
use App\Disbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Disbursement_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            // $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('disbursement', [
                'user' => $user,
                // 'principal' => $principal,
                'main_tab' => '',
                'sub_tab' => '',
                'active_tab' => 'disbursement',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function disbursement_show_selection(Request $request)
    {
        if ($request->input('disbursement') == 'payment to principal') {
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            
            return view('disbursement_show_selection', [
                'principal' => $principal,
            ])->with('disbursement', $request->input('disbursement'));
        }
    }

    public function disbursement_proceed(Request $request)
    {
        // $purchase_order = Purchase_order::select('id', 'purchase_id')->where('principal_id', $request->input('principal_id'))->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();
        return view('disbursement_proceed')->with('disbursement', $request->input('disbursement'))
            ->with('principal_id', $request->input('principal_id'));
    }

    public function disbursement_final_summary(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        return view('disbursement_final_summary')->with('amount', str_replace(',', '', $request->input('amount')))
            ->with('bank', $request->input('bank'))
            ->with('payee', $request->input('payee'))
            ->with('particulars', $request->input('particulars'))
            ->with('amount', str_replace(',', '', $request->input('amount')))
            ->with('amount_in_words', $request->input('amount_in_words'))
            ->with('credit', str_replace(',', '', $request->input('credit')))
            ->with('cv_number', $request->input('cv_number'))
            ->with('debit', str_replace(',', '', $request->input('debit')))
            ->with('remarks', $request->input('remarks'))
            ->with('title', $request->input('title'))
            ->with('check_deposit_slip', $request->input('check_deposit_slip'))
            ->with('date', $date)
            ->with('disbursement', $request->input('disbursement'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('purchase_id', $request->input('purchase_id'));
    }

    public function disbursement_saved(Request $request)
    {
        //dd($request->all());
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $new = new Disbursement([
            'user_id' => auth()->user()->id,
            'disbursement' => $request->input('disbursement'),
            'bank' => $request->input('bank'),
            'check_deposit_slip' => $request->input('check_deposit_slip'),
            'principal_id' => $request->input('principal_id'),
            'amount' => $request->input('amount'),
            'payee' => $request->input('payee'),
            'amount_in_words' => $request->input('amount_in_words'),
            'title' => $request->input('title'),
            'debit' => $request->input('debit'),
            'credit' => $request->input('credit'),
            'particulars' => $request->input('particulars'),
            'cv_number' => $request->input('cv_number'),
            'remarks' => $request->input('remarks'),
        ]);

        $new->save();

        $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();
        if ($principal_ledger_latest) {
            $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'date' => $date,
                'all_id' => $new->id,
                'transaction' => $request->input('disbursement'),
                'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
                'received' => 0,
                'returned' => 0,
                'adjustment' => 0,
                'payment' =>  $request->input('amount'),
                'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('amount'),
            ]);

            $principal_ledger_saved->save();
        } else {
            $principal_ledger_saved = new Principal_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'date' => $date,
                'all_id' => $new->id,
                'transaction' => $request->input('disbursement'),
                'accounts_payable_beginning' => 0,
                'received' => 0,
                'returned' => 0,
                'adjustment' => 0,
                'payment' => $request->input('amount'),
                'accounts_payable_end' => $request->input('amount') * -1,
            ]);

            $principal_ledger_saved->save();
        }


        $ap_ledger_last_transaction = Ap_ledger::select('running_balance')
            ->where('principal_id', $request->input('principal_id'))
            ->orderBy('id', 'desc')->take(1)->first();

        if ($ap_ledger_last_transaction) {
            $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - $request->input('amount');
        } else {
            $ap_ledger_running_balance = $request->input('amount');
        }
        $new_ap_ledger = new Ap_ledger([
            'principal_id' => $request->input('principal_id'),
            'user_id' => auth()->user()->id,
            'transaction_date' => $date,
            'description' => 'Payment to Principal',
            'debit_record' => $request->input('amount'),
            'credit_record' => 0,
            'running_balance' => $ap_ledger_running_balance,
            'transaction' => 'payment to principal',
            'reference' => $new->id,
            'remarks' => $request->input('particulars') . ', ' . $request->input('remarks'),
        ]);

        $new_ap_ledger->save();

        // Purchase_order::where('id', $request->input('purchase_order_id'))
        //     ->update([
        //         'status' => 'paid',
        //     ]);

        // return 'saved';
    }
}
