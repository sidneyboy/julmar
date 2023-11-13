<?php

namespace App\Http\Controllers;

use App\Ap_ledger;
use App\Customer;
use App\User;
use App\Sku_principal;
use App\Purchase_order;
use App\Principal_ledger;
use App\Disbursement;
use App\Disbursement_jer;
use App\Ewt_rate;
use App\Received_jer;
use App\Received_purchase_order;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_collection_jer;
use App\Sales_invoice_collection_receipt;
use App\Sales_invoice_collection_receipt_details;
use App\Sales_invoice_jer;
use App\Transaction_entry;
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
            return view('disbursement_show_selection')->with('disbursement', $request->input('disbursement'));
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

            $receive_purchase_order_unpaid = Received_purchase_order::select('id')
                ->where('principal_id', $request->input('principal_id'))
                ->where('payment_status', null)
                ->orWhere('payment_status', 'partial')
                ->get();

            return view('disbursement_proceed', [
                // 'purchase_order_unpaid' => $purchase_order_unpaid,
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

            $transaction_entry = Transaction_entry::where('description', $request->input('description'))
                ->get();

            return view('disbursement_proceed', [
                'transaction_entry' => $transaction_entry,
            ])->with('description', strtoupper($request->input('description')))
                ->with('disbursement', $request->input('disbursement'))
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

            return view('disbursement_final_summary')
                ->with('bank', $request->input('bank'))
                ->with('po_rr_id', $po_rr_id)
                ->with('po_rr', $po_rr)
                ->with('ewt', $request->input('ewt'))
                ->with('ewt_amount', str_replace(',', '', $request->input('ewt_amount')))
                ->with('net_payable_amount', str_replace(',', '', $request->input('net_payable_amount')))
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
        }
    }

    public function disbursement_saved(Request $request)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

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
                'amount' => $request->input('amount'),
                'amount_payable' => str_replace(',', '', $request->input('amount_payable')),
                'particulars' => $request->input('particulars'),
                'cv_number' => $request->input('cv_number'),
                'po_rr_id' => $po_rr_id,
                'transaction' => $transaction,
            ]);

            $new->save();

            // $new_jer = new Disbursement_jer([
            //     'disbursement_id' => $new->id,
            //     'principal_id' => $request->input('principal_id'),
            //     'debit_record' => $request->input('amount'),
            //     'credit_record' => $request->input('amount'),
            // ]);

            // $new_jer->save();

            // if ($transaction == 'PO') {
            //     if ($request->input('outstanding_balance') != 0) {
            //         Purchase_order::where('id', $po_rr_id)
            //             ->update(['payment_status' => 'partial']);
            //     } else {
            //         Purchase_order::where('id', $po_rr_id)
            //             ->update(['payment_status' => 'paid']);
            //     }
            // } elseif ($transaction == 'RR') {
            //     if ($request->input('outstanding_balance') != 0) {
            //         Received_purchase_order::where('id', $po_rr_id)
            //             ->update(['payment_status' => 'partial']);
            //     } else {
            //         Received_purchase_order::where('id', $po_rr_id)
            //             ->update(['payment_status' => 'paid']);
            //     }
            // }

            // $principal_ledger_latest = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();
            // if ($principal_ledger_latest) {
            //     $principal_ledger_accounts_payable_beginning = $principal_ledger_latest->accounts_payable_end;
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new->id,
            //         'transaction' => $request->input('disbursement'),
            //         'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            //         'received' => 0,
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' =>  $request->input('amount'),
            //         'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('amount'),
            //     ]);

            //     $principal_ledger_saved->save();
            // } else {
            //     $principal_ledger_saved = new Principal_ledger([
            //         'principal_id' => $request->input('principal_id'),
            //         'user_id' => auth()->user()->id,
            //         'date' => $date,
            //         'all_id' => $new->id,
            //         'transaction' => $request->input('disbursement'),
            //         'accounts_payable_beginning' => 0,
            //         'received' => 0,
            //         'returned' => 0,
            //         'adjustment' => 0,
            //         'payment' => $request->input('amount'),
            //         'accounts_payable_end' => $request->input('amount') * -1,
            //     ]);

            //     $principal_ledger_saved->save();
            // }


            // $ap_ledger_last_transaction = Ap_ledger::select('running_balance')
            //     ->where('principal_id', $request->input('principal_id'))
            //     ->orderBy('id', 'desc')->take(1)->first();

            // if ($ap_ledger_last_transaction) {
            //     $ap_ledger_running_balance = $ap_ledger_last_transaction->running_balance - $request->input('amount');
            // } else {
            //     $ap_ledger_running_balance = $request->input('amount');
            // }
            // $new_ap_ledger = new Ap_ledger([
            //     'principal_id' => $request->input('principal_id'),
            //     'user_id' => auth()->user()->id,
            //     'transaction_date' => $date,
            //     'description' => 'Payment to Principal',
            //     'debit_record' => $request->input('amount'),
            //     'credit_record' => 0,
            //     'running_balance' => $ap_ledger_running_balance,
            //     'transaction' => 'payment to principal',
            //     'reference' => $new->id,
            //     'remarks' => $request->input('particulars') . ', ' . $request->input('remarks'),
            // ]);

            // $new_ap_ledger->save();
        } elseif ($request->input('disbursement') == 'collection') {
            //return $request->input();
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
        }
    }
}
