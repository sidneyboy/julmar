<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\User;
use App\Sku_principal;
use App\Purchase_order;
use App\Principal_ledger;
use App\Disbursement;
use App\Disbursement_jer;
use App\Received_jer;
use App\Received_purchase_order;
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
        // $purchase_order_unpaid = Purchase_order::select('id', 'purchase_id')
        // ->where('principal_id',$request->input('principal_id'))
        //     ->where('payment_term', 'cash with order')
        //     ->where('payment_status', null)
        //     ->orWhere('payment_status', 'partial')
        //     ->get();

        $receive_purchase_order_unpaid = Received_purchase_order::select('id')
            ->where('principal_id', $request->input('principal_id'))
            ->where('payment_status', null)
            ->orWhere('payment_status', 'partial')
            ->get();

        return view('disbursement_proceed', [
            // 'purchase_order_unpaid' => $purchase_order_unpaid,
            'receive_purchase_order_unpaid' => $receive_purchase_order_unpaid,
        ])->with('disbursement', $request->input('disbursement'))
            ->with('principal_id', $request->input('principal_id'));
    }

    public function disbursement_show_po_rr_payable(Request $request)
    {
        $explode = explode('|', $request->input('po_rr_id'));
        $po_rr_data = $explode[0];

        $explode_po_rr_data = explode('-', $po_rr_data);
        $transaction = $explode_po_rr_data[0];
        $po_rr_id = $explode_po_rr_data[1];



        if ($transaction == "RR ") {
            $checker = Received_purchase_order::select('payment_status')
                ->where('id', $po_rr_id)
                ->first();

            if ($checker->payment_status == 'partial') {
                $prev_payment = Disbursement::where('po_rr_id', $po_rr_id)
                    ->sum('amount');

                $receive_purchase_order_unpaid_amount = Received_jer::select('dr')
                    ->where('received_id', $po_rr_id)
                    ->first();

                $amount_payable = $receive_purchase_order_unpaid_amount->dr - $prev_payment;
            } else {
                $receive_purchase_order_unpaid_amount = Received_jer::select('dr')
                    ->where('received_id', $po_rr_id)
                    ->first();

                $amount_payable = $receive_purchase_order_unpaid_amount->dr;
            }
        } else {
            $checker = Purchase_order::select('payment_status')
                ->where('id', $po_rr_id)
                ->first();

            if ($checker->payment_status == 'partial') {
                $prev_payment = Disbursement::where('po_rr_id', $po_rr_id)
                    ->sum('amount');

                $amount_payable = Disbursement::select('amount_payble')
                    ->where('po_rr_id', $po_rr_id)
                    ->first();

                $amount_payable = $amount_payable->amount_payable - $prev_payment;
            } else {
                $receive_purchase_order_unpaid_amount = Purchase_order::select('dr')
                    ->where('received_id', $po_rr_id)
                    ->first();

                $amount_payable = $receive_purchase_order_unpaid_amount->dr;
            }
        }

        return view('disbursement_show_po_rr_payable')
            ->with('amount_payable', $amount_payable);
    }

    public function disbursement_final_summary(Request $request)
    {

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $explode = explode('|', $request->input('po_rr_id'));
        $po_rr_id = $explode[0];
        $po_rr = $explode[1];

        $principal_name = Sku_principal::select('principal')
            ->find($request->input('principal_id'));

        return view('disbursement_final_summary')
            ->with('bank', $request->input('bank'))
            ->with('po_rr_id', $po_rr_id)
            ->with('po_rr', $po_rr)
            ->with('particulars', $request->input('particulars'))
            ->with('amount', str_replace(',', '', $request->input('amount')))
            ->with('amount_payable', str_replace(',', '', $request->input('amount_payable')))
            ->with('original_amount_payable', str_replace(',', '', $request->input('original_amount_payable')))
            ->with('cv_number', $request->input('cv_number'))
            ->with('check_deposit_slip', $request->input('check_deposit_slip'))
            ->with('date', $date)
            ->with('disbursement', $request->input('disbursement'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('purchase_id', $request->input('purchase_id'))
            ->with('principal_name', $principal_name);
    }

    public function disbursement_saved(Request $request)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $explode = explode('-', $request->input('po_rr_id'));
        $transaction = $explode[0];
        $po_rr_id = $explode[1];

        $new = new Disbursement([
            'user_id' => auth()->user()->id,
            'disbursement' => $request->input('disbursement'),
            'bank' => $request->input('bank'),
            'check_deposit_slip' => $request->input('check_deposit_slip'),
            'principal_id' => $request->input('principal_id'),
            'amount' => $request->input('amount'),
            'amount_payable' => str_replace(',', '', $request->input('amount_payable')),
            'particulars' => $request->input('particulars'),
            'cv_number' => $request->input('cv_number'),
            'po_rr_id' => $po_rr_id,
            'transaction' => $transaction,
        ]);

        $new->save();

        $new_jer = new Disbursement_jer([
            'disbursement_id' => $new->id,
            'principal_id' => $request->input('principal_id'),
            'debit_record' => $request->input('amount'),
            'credit_record' => $request->input('amount'),
        ]);

        $new_jer->save();



        if ($transaction == 'PO') {
            if ($request->input('outstanding_balance') != 0) {
                Purchase_order::where('id', $po_rr_id)
                    ->update(['payment_status' => 'partial']);
            } else {
                Purchase_order::where('id', $po_rr_id)
                    ->update(['payment_status' => 'paid']);
            }
        } else {
            if ($request->input('outstanding_balance') != 0) {
                Received_purchase_order::where('id', $po_rr_id)
                    ->update(['payment_status' => 'partial']);
            } else {
                Received_purchase_order::where('id', $po_rr_id)
                    ->update(['payment_status' => 'paid']);
            }
        }

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
    }
}
