<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\Chart_of_accounts;
use App\Chart_of_accounts_details;
use App\Customer;
use App\User;
use App\Sku_principal;
use App\Purchase_order;
use App\Principal_ledger;
use App\Disbursement;
use App\Disbursement_jer;
use App\Disbursement_others;
use App\Ewt_rate;
use App\General_ledger;
use App\Received_jer;
use App\Received_purchase_order;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_collection_jer;
use App\Sales_invoice_collection_receipt;
use App\Sales_invoice_collection_receipt_details;
use App\Sales_invoice_jer;
use App\Transaction_entry;
use Generator;
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
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
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
            $ewt_rate = Ewt_rate::select('ewt_rate')->get();
            return view('disbursement_show_selection', [
                'ewt_rate' => $ewt_rate,
                'principal' => $principal,
            ])->with('disbursement', $request->input('disbursement'));
        } elseif ($request->input('disbursement') == 'collection') {
            $customer = Customer::select('store_name', 'id')
                ->where('kind_of_business', '!=', 'VAN SELLING')
                ->get();

            return view('disbursement_show_selection', [
                'customer' => $customer,
            ])->with('disbursement', $request->input('disbursement'));
        } elseif ($request->input('disbursement') == 'others') {
            $transaction_entry = Chart_of_accounts::select('id', 'account_name')
                ->get();

            $transaction_cash_in_bank = Chart_of_accounts_details::select('id', 'account_name')
                ->where('account_name', 'like', '%CASH IN BANK%')
                ->get();

            return view('disbursement_show_selection', [
                'transaction_entry' => $transaction_entry,
                'transaction_cash_in_bank' => $transaction_cash_in_bank,
            ])->with('disbursement', $request->input('disbursement'));
        } else if ($request->input('disbursement') == 'unidentified_chart_of_account') {
            $transaction_cash_in_bank = Chart_of_accounts_details::select('id', 'account_name')
                ->where('account_name', 'like', '%CASH IN BANK%')
                ->get();

            return view('disbursement_show_selection', [
                'transaction_cash_in_bank' => $transaction_cash_in_bank,
            ])->with('disbursement', $request->input('disbursement'));
        }
    }

    public function disbursement_proceed(Request $request)
    {
        if ($request->input('disbursement') == 'payment to principal') {
            // $purchase_order_unpaid = Purchase_order::select('id', 'purchase_id')
            //     ->where('principal_id', $request->input('principal_id'))
            //     ->where('payment_term', 'cash with order')
            //     ->where('payment_status', null)
            //     ->orWhere('payment_status', 'partial')
            //     ->get();

            $get_bank = Chart_of_accounts::select('id')->where('account_name', 'CASH IN BANK')->first();

            $receive_purchase_order_unpaid = Received_purchase_order::select('id')
                ->where('principal_id', $request->input('principal_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            return view('disbursement_proceed', [
                // 'purchase_order_unpaid' => $purchase_order_unpaid,
                'get_bank' => $get_bank,
                'receive_purchase_order_unpaid' => $receive_purchase_order_unpaid,
                'ewt' => $request->input('ewt'),
            ])->with('disbursement', $request->input('disbursement'))
                ->with('principal_id', $request->input('principal_id'));
        } elseif ($request->input('disbursement') == 'collection') {
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment')
                ->where('customer_id', $request->input('customer_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            return view('disbursement_proceed', [
                'sales_invoice' => $sales_invoice,
            ])->with('disbursement', $request->input('disbursement'))
                ->with('date', $date)
                ->with('customer_id', $request->input('customer_id'));
        } elseif ($request->input('disbursement') == 'others') {
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');

            $transaction_entry = Chart_of_accounts_details::select('id', 'account_name')
                ->where('chart_of_accounts_id', $request->input("description"))
                ->get();

            $transaction_insert_entry = Chart_of_accounts_details::select('id', 'account_name')
                ->where('chart_of_accounts_id', '!=', $request->input('description'))
                ->get();

            $transaction_cash_in_bank = Chart_of_accounts_details::select('id', 'account_name')->find($request->input('cash_in_bank_id'));

            $description_explode = explode("|", $request->input('description'));
            $description = $description_explode[1];

            return view('disbursement_proceed', [
                'transaction_entry' => $transaction_entry,
                'transaction_insert_entry' => $transaction_insert_entry,
                'transaction_cash_in_bank' => $transaction_cash_in_bank,
            ])->with('disbursement', $request->input('disbursement'))
                ->with('description', $description)
                ->with('date', $date);
        } elseif ($request->input('disbursement') == 'unidentified_chart_of_account') {
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            //return $request->input();
            $transaction_cash_in_bank = Chart_of_accounts_details::select('id', 'account_name')->find($request->input('cash_in_bank_id'));


            return view('disbursement_proceed', [
                'transaction_cash_in_bank' => $transaction_cash_in_bank,
            ])->with('disbursement', $request->input('disbursement'))
                ->with('date', $date);
        }
    }

    public function disbursement_show_po_rr_payable(Request $request)
    {
        //return $request->input();
        $explode = explode('|', $request->input('po_rr_id'));
        $po_rr_data = $explode[0];

        $explode_po_rr_data = explode('-', $po_rr_data);
        $transaction = $explode_po_rr_data[0];
        $po_rr_id = $explode_po_rr_data[1];

        if ($transaction == "RR ") {
            $checker = Received_purchase_order::select('id', 'payment_status')
                ->where('id', $po_rr_id)
                ->first();



            if (count($checker->return_to_principal) != 0) {
                foreach ($checker->return_to_principal as $key => $return_data) {
                    $sum_return[] = $return_data->total_final_cost;
                }
            } else {
                $sum_return[] = 0;
            }

            if (count($checker->bo_allowance_adjustment) != 0) {
                foreach ($checker->bo_allowance_adjustment as $key_2 => $bo_data) {
                    $sum_bo_allowance[] = $bo_data->net_deduction;
                }
            } else {
                $sum_bo_allowance[] = 0;
            }

            if (count($checker->invoice_cost_adjustment) != 0) {
                foreach ($checker->invoice_cost_adjustment as $key_3 => $invoice_data) {
                    $sum_invoice_cost[] = $invoice_data->total_final_cost;
                }
            } else {
                $sum_invoice_cost[] = 0;
            }


            if ($checker->payment_status == 'partial') {
                $prev_payment = Disbursement::where('po_rr_id', $po_rr_id)
                    ->sum('amount');

                $receive_purchase_order_unpaid_amount = Received_jer::select('dr')
                    ->where('received_id', $po_rr_id)
                    ->first();
                $ewt_rate = $request->input('ewt') / 100;
                $amount_payable = $receive_purchase_order_unpaid_amount->dr - $prev_payment + array_sum($sum_return) + array_sum($sum_bo_allowance) + array_sum($sum_invoice_cost);

                $ewt_amount = $amount_payable * $ewt_rate;
            } else {
                $receive_purchase_order_unpaid_amount = Received_jer::select('dr')
                    ->where('received_id', $po_rr_id)
                    ->first();

                $ewt_rate = $request->input('ewt') / 100;

                $amount_payable = $receive_purchase_order_unpaid_amount->dr  + array_sum($sum_return) + array_sum($sum_bo_allowance) + array_sum($sum_invoice_cost);

                $ewt_amount = $amount_payable * $ewt_rate;
            }
        } elseif ($transaction == "PO ") {

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
            } else if ($checker->payment_status == null) {
                $receive_purchase_order_unpaid_amount = Purchase_order::select('total_final_cost')
                    ->where('id', $po_rr_id)
                    ->first();

                $amount_payable = $receive_purchase_order_unpaid_amount->total_final_cost;
            }
        } elseif ($transaction == 'others') {
            $ap_ledger = Ap_ledger::select('running_balance')->where('principal_id', $request->input('principal_id'))->latest()->first();
            $ewt_rate = $request->input('ewt') / 100;
            $amount_payable = $ap_ledger->running_balance;
            $ewt_amount = $amount_payable * $ewt_rate;
        }



        return view('disbursement_show_po_rr_payable')
            ->with('amount_payable', $amount_payable)
            ->with('ewt_amount', $ewt_amount);
    }

    public function disbursement_final_summary(Request $request)
    {
        // return $request->input();
        if ($request->input('disbursement') == 'payment to principal') {
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            //return $request->input();

            $explode_bank = explode('|', $request->input('bank'));
            $bank_id = $explode_bank[0];
            $bank_account_name = $explode_bank[1];

            if ($request->input('po_rr_id') == 'others-migration') {
                $po_rr_id = 'direct to ap payment';
                $po_rr = 'direct to ap payment';
            } else {
                $explode = explode('|', $request->input('po_rr_id'));
                $po_rr_id = $explode[0];
                $po_rr = $explode[1];
            }


            $principal_name = Sku_principal::select('principal')
                ->find($request->input('principal_id'));

            $get_ap = Chart_of_accounts_details::select('account_name', 'chart_of_accounts_id', 'id', 'account_number')
                ->where('principal_id', $request->input('principal_id'))
                ->where('account_name', 'ACCOUNTS PAYABLE - ' . $principal_name->principal)
                ->first();

            $get_bank = Chart_of_accounts_details::select('account_name', 'chart_of_accounts_id', 'id', 'account_number')->find($bank_id);

            $get_bir_due = Chart_of_accounts_details::select('account_name', 'chart_of_accounts_id', 'id', 'account_number')
                ->where('account_name', 'DUE TO BIR - CREDITABLE WITHHOLDING TAX')
                ->first();

            return view('disbursement_final_summary')
                ->with('bank', $request->input('bank'))
                ->with('bank_id', $bank_id)
                ->with('get_ap', $get_ap)
                ->with('get_bank', $get_bank)
                ->with('get_bir_due', $get_bir_due)
                ->with('bank_account_name', $bank_account_name)
                ->with('po_rr_id', $po_rr_id)
                ->with('po_rr', $po_rr)
                ->with('ewt', $request->input('ewt'))
                ->with('amount_payable', str_replace(',', '', $request->input('amount_payable')))
                ->with('ewt_amount', str_replace(',', '', $request->input('ewt_amount')))
                ->with('net_payable_amount', str_replace(',', '', $request->input('net_payable_amount')))
                ->with('particulars', $request->input('particulars'))
                ->with('amount_paid', str_replace(',', '', $request->input('amount_paid')))
                ->with('original_amount_payable', str_replace(',', '', $request->input('original_amount_payable')))
                ->with('cv_number', $request->input('cv_number'))
                ->with('check_deposit_slip', $request->input('check_deposit_slip'))
                ->with('date', $date)
                ->with('disbursement', $request->input('disbursement'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('purchase_id', $request->input('purchase_id'))
                ->with('principal_name', $principal_name);
        } elseif ($request->input('disbursement') == 'collection') {
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');

            foreach ($request->input('amount_collected') as $key => $value) {
                if ($request->input('outstanding_balance')[$key] < str_replace(',', '', $value)) {
                    return 'cannot proceed';
                }
            }

            $amount_collected = array_filter(str_replace(',', '', $request->input('amount_collected')));
            $sales_invoice = Sales_invoice::select('agent_id', 'customer_id', 'id', 'delivery_receipt', 'principal_id', 'total', 'total_payment')
                ->whereIn('id', array_keys($amount_collected))
                ->get();
            return view('disbursement_final_summary', [
                'amount_collected' => $amount_collected,
                'sales_invoice' => $sales_invoice,
            ])->with('customer_id', $request->input('customer_id'))
                ->with('bank', $request->input('bank'))
                ->with('date', $date)
                ->with('check_ref_cash', strtoupper($request->input('check_ref_cash')))
                ->with('disbursement', $request->input('disbursement'))
                ->with('official_receipt_no', strtoupper($request->input('official_receipt_no')))
                ->with('payment_date', $request->input('payment_date'))
                ->with('remarks', $request->input('remarks'));
        } elseif ($request->input('disbursement') == 'others') {

            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            // return $request->input();
            $transaction_entry = Chart_of_accounts_details::select('id', 'account_name', 'account_number', 'normal_balance', 'chart_of_accounts_id')
                ->whereIn('id', $request->input("id"))
                ->get();

            $new_account_name_checker = $request->input('new_account_name');
            if (isset($new_account_name_checker)) {
                $transaction_insert_entry = Chart_of_accounts_details::select('id', 'account_name', 'account_number', 'normal_balance', 'chart_of_accounts_id')
                    ->whereIn('id', $request->input('new_account_name'))
                    ->get();
            } else {
                $transaction_insert_entry = 0;
            }





            return view('disbursement_final_summary', [
                'transaction_insert_entry' => $transaction_insert_entry,
                'transaction_entry' => $transaction_entry,
            ])->with('disbursement', $request->input('disbursement'))
                ->with('payee', $request->input('payee'))
                ->with('description', $request->input('description'))
                ->with('date', $date)
                ->with('invoice_no_ref', $request->input('invoice_no_ref'))
                ->with('check_ref_cash', $request->input('check_ref_cash'))
                ->with('bank', $request->input('bank'))
                ->with('date_range', $request->input('date_range'))
                ->with('new_account_name', $request->input('new_account_name'))
                ->with('account_name', $request->input('account_name'))
                ->with('new_debit_record', $request->input('new_debit_record'))
                ->with('new_credit_record', $request->input('new_credit_record'))
                ->with('debit_record', $request->input('debit_record'))
                ->with('credit_record', $request->input('credit_record'));
        }
    }

    public function disbursement_saved(Request $request)
    {
        //dd($request->all());
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        //return $request->input();
        if ($request->input('disbursement') == 'payment to principal') {
            if ($request->input('po_rr_id') == 'direct to ap payment') {
                $transaction = 'others';
                $po_rr_id = 'direct to ap payment';
            } else {
                $explode = explode('-', $request->input('po_rr_id'));
                $transaction = $explode[0];
                $po_rr_id = $explode[1];
            }

            $new = new Disbursement([
                'user_id' => auth()->user()->id,
                'disbursement' => $request->input('disbursement'),
                'bank' => $request->input('bank'),
                'check_deposit_slip' => $request->input('check_deposit_slip'),
                'principal_id' => $request->input('principal_id'),
                'particulars' => $request->input('particulars'),
                'cv_number' => $request->input('cv_number'),
                'po_rr_id' => $po_rr_id,
                'transaction' => $transaction,
                'payable_amount' => str_replace(',', '', $request->input('payable_amount',)),
                'ewt_amount' => str_replace(',', '', $request->input('ewt_amount',)),
                'net_payable' => str_replace(',', '', $request->input('net_payable',)),
                'amount_paid' => str_replace(',', '', $request->input('amount_paid')),
            ]);

            $new->save();

            $new_jer = new Disbursement_jer([
                'disbursement_id' => $new->id,
                'principal_id' => $request->input('principal_id'),
                'accounts_payable' => $request->input('accounts_payable'),
                'cash_in_bank' => $request->input('cash_in_bank'),
                'withholding_tax' => $request->input('withholding_tax'),
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
            } elseif ($transaction == 'RR') {
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
                    'payment' =>  str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount'),
                    'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount'),
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
                    'payment' => str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount'),
                    'accounts_payable_end' => str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount') * -1,
                ]);

                $principal_ledger_saved->save();
            }

            $ap_ledger_last_transaction = Ap_ledger::select('running_balance')
                ->where('principal_id', $request->input('principal_id'))
                ->orderBy('id', 'desc')->take(1)->first();

            if ($ap_ledger_last_transaction) {
                $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - (str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount'));
            } else {
                $ap_ledger_running_balance = str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount');
            }

            $new_ap_ledger = new Ap_ledger([
                'principal_id' => $request->input('principal_id'),
                'user_id' => auth()->user()->id,
                'transaction_date' => $date,
                'description' => 'Payment to Principal',
                'debit_record' => str_replace(',', '', $request->input('amount_paid')) + $request->input('ewt_amount'),
                'credit_record' => 0,
                'running_balance' => $ap_ledger_running_balance,
                'transaction' => 'payment to principal',
                'reference' => 2,
                'remarks' => $request->input('particulars') . ', ' . $request->input('remarks'),
            ]);

            $new_ap_ledger->save();

            $get_ap = General_ledger::select('running_balance')
                ->where('account_name', $request->input('get_ap_account_name'))
                ->where('principal_id', $request->input('principal_id'))
                ->where('account_number', $request->input('get_ap_account_number'))
                ->orderBy('id', 'DESC')
                ->first();

            if ($get_ap) {
                $running_balance = $get_ap->running_balance - $request->input('accounts_payable');

                $new_general_ap_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_ap_account_name'),
                    'account_number' => $request->input('get_ap_account_number'),
                    'debit_record' => $request->input('accounts_payable'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_ap_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_ap_ledger->save();
            } else {
                $new_general_ap_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_ap_account_name'),
                    'account_number' => $request->input('get_ap_account_number'),
                    'debit_record' => $request->input('accounts_payable'),
                    'credit_record' => 0,
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_ap_general_account_number'),
                    'running_balance' => $request->input('accounts_payable'),
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_ap_ledger->save();
            }

            $get_bank = General_ledger::select('running_balance')
                ->where('account_name', $request->input('get_bank_account_name'))
                ->where('account_number', $request->input('get_bank_account_number'))
                ->orderBy('id', 'DESC')
                ->first();

            if ($get_bank) {
                $running_balance = $get_bank->running_balance - $request->input('cash_in_bank');

                $new_general_due_bir_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_bank_account_name'),
                    'account_number' => $request->input('get_bank_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('cash_in_bank'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_bank_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_due_bir_ledger->save();
            } else {
                $new_general_due_bir_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_bank_account_name'),
                    'account_number' => $request->input('get_bank_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('cash_in_bank'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_bank_general_account_number'),
                    'running_balance' => $request->input('cash_in_bank'),
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_due_bir_ledger->save();
            }

            $get_bir_due = General_ledger::select('running_balance')
                ->where('account_name', $request->input('get_bir_due_account_name'))
                ->where('account_number', $request->input('get_bir_due_account_number'))
                ->orderBy('id', 'DESC')
                ->first();

            if ($get_bir_due) {
                $running_balance = $get_bir_due->running_balance + $request->input('withholding_tax');

                $new_general_ap_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_bir_due_account_name'),
                    'account_number' => $request->input('get_bir_due_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('withholding_tax'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_bir_due_general_account_number'),
                    'running_balance' => $running_balance,
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_ap_ledger->save();
            } else {
                $new_general_ap_ledger = new General_ledger([
                    'principal_id' => $request->input('principal_id'),
                    'account_name' => $request->input('get_bir_due_account_name'),
                    'account_number' => $request->input('get_bir_due_account_number'),
                    'debit_record' => 0,
                    'credit_record' => $request->input('withholding_tax'),
                    'user_id' => auth()->user()->id,
                    'transaction_date' => $date,
                    'general_account_number' => $request->input('get_bir_due_general_account_number'),
                    'running_balance' => $request->input('withholding_tax'),
                    'transaction' => 'PAYMENT TO PRINCIPAL',
                ]);

                $new_general_ap_ledger->save();
            }
        } elseif ($request->input('disbursement') == 'collection') {
            return $request->input();
            $new = new Sales_invoice_collection_receipt([
                'user_id' => auth()->user()->id,
                'customer_id' => $request->input('customer_id'),
                'agent_id' => $request->input('agent_id'),
                'check_ref_cash' => $request->input('check_ref_cash'),
                'official_receipt' => $request->input('official_receipt_no'),
                'bank' => $request->input('bank'),
                'payment_date' => $request->input('payment_date'),
            ]);

            $new->save();

            $new_jer = new Sales_invoice_collection_jer([
                'sicrd_id' => $new->id,
                'debit_record' => $request->input('debit_record'),
                'credit_record' => $request->input('credit_record'),
            ]);

            $new_jer->save();



            foreach ($request->input('amount_collected') as $key => $value) {
                $new_details = new Sales_invoice_collection_receipt_details([
                    'sicrd_id' => $new->id,
                    'si_id' => $key,
                    'ar_balance' => $request->input('outstanding_balance')[$key],
                    'amount_collected' => $value,
                    'outstanding_balance' => $request->input('new_outstanding_balance')[$key],
                    'remarks' => $request->input('remarks')[$key],
                ]);

                $new_details->save();

                $sales_invoice_checker = Sales_invoice::select('total_payment', 'total', 'principal_id')->find($key);

                $total_payment = $sales_invoice_checker->total_payment + $value;

                if ($total_payment == $sales_invoice_checker->total) {
                    Sales_invoice::where('id', $key)
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'paid',
                        ]);
                } else {
                    Sales_invoice::where('id', $key)
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'partial',
                        ]);
                }

                $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id'))
                    ->where('principal_id', $sales_invoice_checker->principal_id)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($get_last_row_sales_invoice_accounts_receivable) {
                    $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance - $value;
                } else {
                    $sales_invoice_ar_running_balance = $value;
                }

                $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                    'user_id' => auth()->user()->id,
                    'principal_id' => $sales_invoice_checker->principal_id,
                    'customer_id' => $request->input('customer_id'),
                    'transaction' => 'collection receipt',
                    'all_id' => $new->id,
                    'debit_record' => 0,
                    'credit_record' => $value,
                    'running_balance' => $sales_invoice_ar_running_balance,
                ]);

                $new_sales_invoice_accounts_receivable->save();
            }
        } else if ($request->input('disbursement') == 'others') {
            $var = explode('-', $request->input('date_range'));
            $date_from = date('Y-m-d', strtotime($var[0]));
            $date_to = date('Y-m-d', strtotime($var[1]));

            $new_disbursement = new Disbursement_others([
                'payee' => $request->input('payee'),
                'transaction_date' => $request->input('date'),
                'invoice_number' => $request->input('invoice_no_ref'),
                'check_ref' => $request->input('check_ref_cash'),
                'description' => $request->input('description'),
                'bank' => $request->input('bank'),
                'transaction_date_from' => $date_from,
                'transaction_date_to' => $date_to,
                'user_id' => auth()->user()->id,
            ]);

            $new_disbursement->save();
            //return $request->input();
            for ($i = 0; $i < count($request->input('account_number')); $i++) {
                $get_chart_of_account = General_ledger::select('account_name', 'running_balance')
                    ->where('account_number', $request->input('account_number')[$i])
                    ->orderBy('id', 'desc')
                    ->first();

                if ($get_chart_of_account) {
                    if ($request->input('normal_balance')[$i] == 'debit') {
                        $amount = $request->input('debit_record')[$i] - $request->input('credit_record')[$i] + $get_chart_of_account->running_balance;
                        $new_general_ledger = new General_ledger([
                            'account_name' => $request->input('account_name')[$i],
                            'account_number' => $request->input('account_number')[$i],
                            'debit_record' => $request->input('debit_record')[$i],
                            'credit_record' => $request->input('credit_record')[$i],
                            'user_id' => auth()->user()->id,
                            'transaction_date' => $date,
                            'running_balance' => $amount,
                            'general_account_number' => $request->input('general_account_number')[$i],
                            'transaction' => 'DISBURSEMENT',
                        ]);

                        $new_general_ledger->save();
                    } else {
                        $amount = $request->input('credit_record')[$i] - $request->input('debit_record')[$i] + $get_chart_of_account->running_balance;

                        $new_general_ledger = new General_ledger([
                            'account_name' => $request->input('account_name')[$i],
                            'account_number' => $request->input('account_number')[$i],
                            'debit_record' => $request->input('debit_record')[$i],
                            'credit_record' => $request->input('credit_record')[$i],
                            'user_id' => auth()->user()->id,
                            'transaction_date' => $date,
                            'running_balance' => $amount,
                            'general_account_number' => $request->input('general_account_number')[$i],
                            'transaction' => 'DISBURSEMENT',
                        ]);

                        $new_general_ledger->save();
                    }
                } else {
                    if ($request->input('normal_balance')[$i] == 'debit') {
                        $amount = $request->input('debit_record')[$i] - $request->input('credit_record')[$i];
                        $new_general_ledger = new General_ledger([
                            'account_name' => $request->input('account_name')[$i],
                            'account_number' => $request->input('account_number')[$i],
                            'debit_record' => $request->input('debit_record')[$i],
                            'credit_record' => $request->input('credit_record')[$i],
                            'user_id' => auth()->user()->id,
                            'transaction_date' => $date,
                            'running_balance' => $amount,
                            'general_account_number' => $request->input('general_account_number')[$i],
                            'transaction' => 'DISBURSEMENT',
                        ]);

                        $new_general_ledger->save();
                    } else {
                        $amount = $request->input('credit_record')[$i] - $request->input('debit_record')[$i];

                        $new_general_ledger = new General_ledger([
                            'account_name' => $request->input('account_name')[$i],
                            'account_number' => $request->input('account_number')[$i],
                            'debit_record' => $request->input('debit_record')[$i],
                            'credit_record' => $request->input('credit_record')[$i],
                            'user_id' => auth()->user()->id,
                            'transaction_date' => $date,
                            'running_balance' => $amount,
                            'general_account_number' => $request->input('general_account_number')[$i],
                            'transaction' => 'DISBURSEMENT',
                        ]);

                        $new_general_ledger->save();
                    }
                }
            }
        }
    }
}
