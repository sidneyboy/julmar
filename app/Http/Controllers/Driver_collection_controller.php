<?php

namespace App\Http\Controllers;

use App\Chart_of_accounts_details;
use App\General_ledger;
use App\Logistics;
use App\Logistics_upload;
use App\Sales_invoice;
use App\Sales_invoice_accounts_receivable;
use App\Sales_invoice_collection_jer;
use App\Sales_invoice_collection_receipt;
use App\Sales_invoice_collection_receipt_details;
use App\Sales_invoice_status_logs;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Driver_collection_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position', 'principal_id')->find(Auth()->user()->id);

            return view('driver_collection', [
                'user' => $user,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'driver_collection',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function driver_collection_search_per_generate(Request $request)
    {
        if ($request->input('search_per') == 'driver') {
            $logistics_upload = Logistics_upload::select('logistics_id', 'date')
                ->where('status', null)
                ->GROUPBY('logistics_id')
                ->get();
            return view('driver_collection_search_per_generate', [
                'logistics_upload' => $logistics_upload,
            ])->with('search_per', $request->input('search_per'));
        } else if ($request->input('search_per') == 'invoice') {

            // $logistics_upload = Logistics_upload::select('date', 'sales_invoice_id')
            //     ->where('status', null)
            //     ->get();
            return view('driver_collection_search_per_generate', [
                // 'logistics_upload' => $logistics_upload,
            ])->with('search_per', $request->input('search_per'));
        }
    }

    public function driver_collection_proceed(Request $request)
    {
        //return $request->input();
        if ($request->input('search_per') == 'driver') {
            $logistics_upload = Logistics_upload::select('id', 'logistics_id', 'delivered_date', 'sales_invoice_id')
                ->where('logistics_id', $request->input('logistics_id'))
                ->get();

            return view('driver_collection_proceed', [
                'logistics_upload' => $logistics_upload,
            ])->with('search_per', $request->input('search_per'));
        } else if ($request->input('search_per') == 'invoice') {
            $sales_invoice = Sales_invoice::select('id')->where('delivery_receipt', 'like', '%' . $request->input('delivery_receipt') . '%')->first();

            $logistics_upload = Logistics_upload::select('id', 'logistics_id', 'delivered_date', 'sales_invoice_id')
                ->where('sales_invoice_id', $sales_invoice->id)
                ->get();

            return view('driver_collection_proceed', [
                'logistics_upload' => $logistics_upload,
            ])->with('search_per', $request->input('search_per'));
        }
    }

    public function driver_collection_final_summary(Request $request)
    {
        //return $request->input();
        if ($request->input('search_per') == 'driver') {
            $logistics_upload = Logistics_upload::select('id', 'logistics_id', 'delivered_date', 'sales_invoice_id')
                ->whereIn('id', $request->input('logistics_upload_id'))
                ->get();

            return view('driver_collection_final_summary', [
                'logistics_upload' => $logistics_upload,
                'payment' => $request->input('payment'),
            ])->with('search_per', $request->input('search_per'));
        } else if ($request->input('search_per') == 'invoice') {
            $logistics_upload = Logistics_upload::select('id', 'logistics_id', 'delivered_date', 'sales_invoice_id')
                ->where('id', $request->input('logistics_upload_id'))
                ->get();

            return view('driver_collection_final_summary', [
                'logistics_upload' => $logistics_upload,
                'payment' => $request->input('payment'),
            ])->with('search_per', $request->input('search_per'));
        }
    }

    public function driver_collection_final_save(Request $request)
    {

        $curdate = DB::select('SELECT CURDATE()');
        if ($request->input('search_per') == 'driver') {
            foreach ($request->input('logistics_id') as $key => $logistics_id) {
                Logistics_upload::where('id', $logistics_id)
                    ->update(['status' => 'completed']);

                $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $request->input('sales_invoice_id')[$logistics_id])
                    ->orderBy('id', 'desc')
                    ->first();
                $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

                Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                    ->update([
                        'updated' => $curdate[0]->{'CURDATE()'},
                        'no_of_days' => $diff
                    ]);

                $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                    'sales_invoice_id' => $request->input('sales_invoice_id')[$logistics_id],
                    'posted' => $curdate[0]->{'CURDATE()'},
                    'updated' => '',
                    'status' => 'Paid',
                    'user_id' => auth()->user()->id,
                ]);

                $new_sales_invoice_status_logs_save->save();

                $new = new Sales_invoice_collection_receipt([
                    'user_id' => auth()->user()->id,
                    'customer_id' => $request->input('customer_id')[$logistics_id],
                    'agent_id' => $request->input('agent_id')[$logistics_id],
                    'check_ref_cash' => "N/A",
                    'official_receipt' => "ASK MAAM VAN",
                    'bank' => "N/A",
                    'payment_date' => $curdate[0]->{'CURDATE()'},
                ]);

                $new->save();

                $new_jer = new Sales_invoice_collection_jer([
                    'sicrd_id' => $new->id,
                    'payment' => $request->input('payment')[$logistics_id],
                    'payment' => $request->input('payment')[$logistics_id],
                ]);

                $new_jer->save();
                //---------------------------------------
                $sales_invoice_checker = Sales_invoice::select('total_payment', 'total', 'principal_id', 'customer_id')->find($request->input('sales_invoice_id')[$logistics_id]);

                $total_payment = $sales_invoice_checker->total_payment + $request->input('payment')[$logistics_id];

                if ($total_payment >= $sales_invoice_checker->total) {
                    Sales_invoice::where('id', $request->input('sales_invoice_id')[$logistics_id])
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'paid',
                        ]);

                    $sales_invoice_collection_checker = Sales_invoice_collection_receipt_details::select('outstanding_balance')->where('si_id', $request->input('sales_invoice_id')[$logistics_id])->orderBy('id', 'desc')->first();



                    if ($sales_invoice_collection_checker) {
                        $outstanding_balance = $sales_invoice_collection_checker->outstanding_balance - $request->input('payment')[$logistics_id];
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => $new->id,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('outstanding_balance')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => $outstanding_balance,
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    } else {
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => $new->id,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('total_amount')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => round($request->input('total_amount')[$logistics_id], 2) - $request->input('payment')[$logistics_id],
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    }

                    $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id')[$logistics_id])
                        ->where('principal_id', $sales_invoice_checker->principal_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($get_last_row_sales_invoice_accounts_receivable) {
                        $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance -  $request->input('payment')[$logistics_id];
                    } else {
                        $sales_invoice_ar_running_balance =  $request->input('payment')[$logistics_id];
                    }

                    $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                        'user_id' => auth()->user()->id,
                        'principal_id' => $sales_invoice_checker->principal_id,
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                        'transaction' => 'collection receipt',
                        'all_id' => $new->id,
                        'debit_record' => 0,
                        'credit_record' =>  $request->input('payment')[$logistics_id],
                        'running_balance' => $sales_invoice_ar_running_balance,
                    ]);

                    $new_sales_invoice_accounts_receivable->save();
                } else {
                    Sales_invoice::where('id', $request->input('sales_invoice_id')[$logistics_id])
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'partial',
                        ]);

                    $sales_invoice_collection_checker = Sales_invoice_collection_receipt_details::select('outstanding_balance')->where('si_id', $request->input('sales_invoice_id')[$logistics_id])->orderBy('id', 'desc')->first();



                    if ($sales_invoice_collection_checker) {
                        $outstanding_balance = $sales_invoice_collection_checker->outstanding_balance - $request->input('payment')[$logistics_id];
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => $new->id,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => $sales_invoice_collection_checker->outstanding_balance,
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => $outstanding_balance,
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    } else {
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => $new->id,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('total_amount')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' =>  round($request->input('total_amount')[$logistics_id], 2) - $request->input('payment')[$logistics_id],
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    }

                    $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id')[$logistics_id])
                        ->where('principal_id', $sales_invoice_checker->principal_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($get_last_row_sales_invoice_accounts_receivable) {
                        $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance -  $request->input('payment')[$logistics_id];
                    } else {
                        $sales_invoice_ar_running_balance =  $request->input('payment')[$logistics_id];
                    }

                    $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                        'user_id' => auth()->user()->id,
                        'principal_id' => $sales_invoice_checker->principal_id,
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                        'transaction' => 'collection receipt',
                        'all_id' => $new->id,
                        'debit_record' => 0,
                        'credit_record' =>  $request->input('payment')[$logistics_id],
                        'running_balance' => $sales_invoice_ar_running_balance,
                    ]);

                    $new_sales_invoice_accounts_receivable->save();
                }
                $get_customer_ar_data = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
                    ->where('customer_id', $request->input('customer_id')[$logistics_id])
                    ->first();

                $get_customer_ar = General_ledger::select('running_balance')
                    ->where('account_name', $get_customer_ar_data->account_name)
                    ->where('customer_id', $request->input('customer_id')[$logistics_id])
                    ->where('account_number', $get_customer_ar_data->account_number)
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($get_customer_ar) {
                    $running_balance = $get_customer_ar->running_balance - $request->input('payment')[$logistics_id];

                    $new_general_ledger = new General_ledger([
                        'account_name' => $get_customer_ar_data->account_name,
                        'account_number' => $get_customer_ar_data->account_number,
                        'debit_record' => 0,
                        'credit_record' => $request->input('payment')[$logistics_id],
                        'user_id' => auth()->user()->id,
                        'transaction_date' => $curdate[0]->{'CURDATE()'},
                        'general_account_number' => $get_customer_ar_data->chart_of_accounts->account_number,
                        'running_balance' => $running_balance,
                        'transaction' => 'DRIVER COLLECTION',
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                    ]);

                    $new_general_ledger->save();
                } else {
                    $new_general_ledger = new General_ledger([
                        'account_name' => $get_customer_ar_data->account_name,
                        'account_number' => $get_customer_ar_data->account_number,
                        'debit_record' => 0,
                        'credit_record' => $request->input('payment')[$logistics_id],
                        'user_id' => auth()->user()->id,
                        'transaction_date' => $curdate[0]->{'CURDATE()'},
                        'general_account_number' => $get_customer_ar_data->chart_of_accounts->account_number,
                        'running_balance' => $request->input('payment')[$logistics_id],
                        'transaction' => 'DRIVER COLLECTION',
                        'customer_id' => $request->input('customer_id'),
                    ]);

                    $new_general_ledger->save();
                }
            }
        } else {
            foreach ($request->input('logistics_id') as $key => $logistics_id) {
                Logistics_upload::where('id', $logistics_id)
                    ->update(['status' => 'completed']);

                $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $request->input('sales_invoice_id')[$logistics_id])
                    ->orderBy('id', 'desc')
                    ->first();
                $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

                Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                    ->update([
                        'updated' => $curdate[0]->{'CURDATE()'},
                        'no_of_days' => $diff
                    ]);

                $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                    'sales_invoice_id' => $request->input('sales_invoice_id')[$logistics_id],
                    'posted' => $curdate[0]->{'CURDATE()'},
                    'updated' => '',
                    'status' => 'Paid',
                    'user_id' => auth()->user()->id,
                ]);

                    $new_sales_invoice_status_logs_save->save();

                    $new = new Sales_invoice_collection_receipt([
                        'user_id' => auth()->user()->id,
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                        'agent_id' => $request->input('agent_id')[$logistics_id],
                        'check_ref_cash' => "N/A",
                        'official_receipt' => "ASK MAAM VAN",
                        'bank' => "N/A",
                        'payment_date' => $curdate[0]->{'CURDATE()'},
                    ]);

                    $new->save();

                    $new_jer = new Sales_invoice_collection_jer([
                        'sicrd_id' => $new->id,
                        'payment' => $request->input('payment')[$logistics_id],
                        'payment' => $request->input('payment')[$logistics_id],
                    ]);

                    $new_jer->save();
                //---------------------------------------

                //return $request->input();

                $sales_invoice_checker = Sales_invoice::select('total_payment', 'total', 'principal_id', 'customer_id')->find($request->input('sales_invoice_id')[$logistics_id]);

                $total_payment = $sales_invoice_checker->total_payment + $request->input('payment')[$logistics_id];

                if ($total_payment >= $sales_invoice_checker->total) {
                    Sales_invoice::where('id', $request->input('sales_invoice_id')[$logistics_id])
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'paid',
                        ]);

                    $sales_invoice_collection_checker = Sales_invoice_collection_receipt_details::select('outstanding_balance')->where('si_id', $request->input('sales_invoice_id')[$logistics_id])->orderBy('id', 'desc')->first();

                    if ($sales_invoice_collection_checker) {
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => 1,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('outstanding_balance')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => $sales_invoice_collection_checker->outstanding_balance - $request->input('payment')[$logistics_id],
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    } else {
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => 1,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('total_amount')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => round($request->input('total_amount')[$logistics_id], 2) - $request->input('payment')[$logistics_id],
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    }

                    $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id')[$logistics_id])
                        ->where('principal_id', $sales_invoice_checker->principal_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($get_last_row_sales_invoice_accounts_receivable) {
                        $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance -  $request->input('payment')[$logistics_id];
                    } else {
                        $sales_invoice_ar_running_balance =  $request->input('payment')[$logistics_id];
                    }

                    $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                        'user_id' => auth()->user()->id,
                        'principal_id' => $sales_invoice_checker->principal_id,
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                        'transaction' => 'collection receipt',
                        'all_id' => 1,
                        'debit_record' => 0,
                        'credit_record' =>  $request->input('payment')[$logistics_id],
                        'running_balance' => $sales_invoice_ar_running_balance,
                    ]);

                    $new_sales_invoice_accounts_receivable->save();
                } else {
                    Sales_invoice::where('id', $request->input('sales_invoice_id')[$logistics_id])
                        ->update([
                            'total_payment' => $total_payment,
                            'payment_status' => 'partial',
                        ]);

                    $sales_invoice_collection_checker = Sales_invoice_collection_receipt_details::select('outstanding_balance')->where('si_id', $request->input('sales_invoice_id')[$logistics_id])->orderBy('id', 'desc')->first();

                    if ($sales_invoice_collection_checker) {
                        $sales_invoice_outstanding_balance = $sales_invoice_collection_checker->outstanding_balance - $request->input('payment')[$logistics_id];
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => 1,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => $sales_invoice_collection_checker->outstanding_balance,
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => $sales_invoice_outstanding_balance,
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    } else {
                        $new_details = new Sales_invoice_collection_receipt_details([
                            'sicrd_id' => 1,
                            'si_id' => $request->input('sales_invoice_id')[$logistics_id],
                            'ar_balance' => round($request->input('total_amount')[$logistics_id], 2),
                            'amount_collected' => $request->input('payment')[$logistics_id],
                            'outstanding_balance' => round($request->input('total_amount')[$logistics_id], 2) - $request->input('payment')[$logistics_id],
                            'remarks' => '',
                            'status' => 'paid',
                        ]);

                        $new_details->save();
                    }

                    $get_last_row_sales_invoice_accounts_receivable = Sales_invoice_accounts_receivable::where('customer_id', $request->input('customer_id')[$logistics_id])
                        ->where('principal_id', $sales_invoice_checker->principal_id)
                        ->orderBy('id', 'desc')
                        ->first();

                    if ($get_last_row_sales_invoice_accounts_receivable) {
                        $sales_invoice_ar_running_balance = $get_last_row_sales_invoice_accounts_receivable->running_balance -  $request->input('payment')[$logistics_id];
                    } else {
                        $sales_invoice_ar_running_balance =  $request->input('payment')[$logistics_id];
                    }

                    $new_sales_invoice_accounts_receivable = new Sales_invoice_accounts_receivable([
                        'user_id' => auth()->user()->id,
                        'principal_id' => $sales_invoice_checker->principal_id,
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                        'transaction' => 'collection receipt',
                        'all_id' => 1,
                        'debit_record' => 0,
                        'credit_record' =>  $request->input('payment')[$logistics_id],
                        'running_balance' => $sales_invoice_ar_running_balance,
                    ]);

                    $new_sales_invoice_accounts_receivable->save();
                }
                $get_customer_ar_data = Chart_of_accounts_details::select('account_name', 'account_number', 'chart_of_accounts_id')
                    ->where('customer_id', $request->input('customer_id')[$logistics_id])
                    ->first();

                $get_customer_ar = General_ledger::select('running_balance')
                    ->where('account_name', $get_customer_ar_data->account_name)
                    ->where('customer_id', $request->input('customer_id')[$logistics_id])
                    ->where('account_number', $get_customer_ar_data->account_number)
                    ->orderBy('id', 'DESC')
                    ->first();

                if ($get_customer_ar) {
                    $running_balance = $get_customer_ar->running_balance - $request->input('payment')[$logistics_id];

                    $new_general_ledger = new General_ledger([
                        'account_name' => $get_customer_ar_data->account_name,
                        'account_number' => $get_customer_ar_data->account_number,
                        'debit_record' => 0,
                        'credit_record' => $request->input('payment')[$logistics_id],
                        'user_id' => auth()->user()->id,
                        'transaction_date' => $curdate[0]->{'CURDATE()'},
                        'general_account_number' => $get_customer_ar_data->chart_of_accounts->account_number,
                        'running_balance' => $running_balance,
                        'transaction' => 'DRIVER COLLECTION',
                        'customer_id' => $request->input('customer_id')[$logistics_id],
                    ]);

                    $new_general_ledger->save();
                } else {
                    $new_general_ledger = new General_ledger([
                        'account_name' => $get_customer_ar_data->account_name,
                        'account_number' => $get_customer_ar_data->account_number,
                        'debit_record' => 0,
                        'credit_record' => $request->input('payment')[$logistics_id],
                        'user_id' => auth()->user()->id,
                        'transaction_date' => $curdate[0]->{'CURDATE()'},
                        'general_account_number' => $get_customer_ar_data->chart_of_accounts->account_number,
                        'running_balance' => $request->input('payment')[$logistics_id],
                        'transaction' => 'DRIVER COLLECTION',
                        'customer_id' => $request->input('customer_id'),
                    ]);

                    $new_general_ledger->save();
                }
            }
        }
    }
}
