<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use App\Van_selling_printed;
use App\Van_selling_printed_details;
use App\Sku_principal;
use App\Location;
use App\Customer;
use App\Customer_principal_code;
use App\Van_selling_upload_ledger;
use App\Van_selling_ar_ledger;
use DB;
use Illuminate\Http\Request;

class Van_selling_reinvoice_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            
            return view('van_selling_reinvoice', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_reinvoice',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_reinvoice_generate_dr(Request $request)
    {
        //return $request->input();
        $van_selling = Van_selling_printed::select('id', 'delivery_receipt', 'customer_id', 'date', 'total_amount')->where('remarks', 'printed')->orWhere('remarks', 'exported')->orWhere('remarks', 'CANCELLED')->whereBetween('date', [$request->input('from'), $request->input('to')])->get();


        return view('van_selling_reinvoice_generate_dr_page', [
            'van_selling' => $van_selling,
        ]);
    }

    public function van_selling_reinvoice_generate_dr_details(Request $request)
    {
        $van_selling = Van_selling_printed::find($request->input('van_selling_id'));
        $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $van_selling->customer_id)->where('principal_id', $van_selling->principal_id)->first();
        return view('van_selling_reinvoice_generate_dr_details_page', [
            'van_selling' => $van_selling,
        ])->with('customer_principal_code', $customer_principal_code)
            ->with('customer_id', $van_selling->customer_id);
    }

    public function van_selling_reinvoice_print(Request $request)
    {

        $access_key_filter = User::select('secret_key', 'position')->where('secret_key', $request->input('access_key'))->first();

        if ($access_key_filter->position == 'System_admin' or $access_key_filter->position == 'Audit_head' or $access_key_filter->position == 'Operations_manager') {

            $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
            $van_selling = Van_selling_printed::find($request->input('van_selling_id'));
            $customer_principal_code = Customer_principal_code::select('store_code')->where('customer_id', $van_selling->customer_id)->where('principal_id', $van_selling->principal_id)->first();

            return view('van_selling_reinvoice_print_page', [
                'van_selling' => $van_selling,
            ])->with('customer_principal_code', $customer_principal_code)
                ->with('employee_name', $employee_name);
        } else {
            return view('van_selling_reinvoice_print_page_error');
        }
    }

    public function van_selling_print_save(Request $request)
    {
        Van_selling_printed::where('id', $request->input('van_selling_id'))
            ->update(['remarks' => 'printed']);

        return 'saved';
    }

    public function van_selling_reinvoice_cancel(Request $request)
    {
        //return $request->input();
        $access_key_filter = User::select('secret_key', 'position')->where('secret_key', $request->input('access_key'))->first();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        if ($access_key_filter->position == 'System_admin' or $access_key_filter->position == 'Audit_head' or $access_key_filter->position == 'Operations_manager') {

            $van_selling = Van_selling_printed::find($request->input('van_selling_id'));

            $van_search = Van_selling_ar_ledger::select('should_be', 'over_short', 'running_balance')->where('customer_id', $van_selling->customer_id)->latest()->first();

            $running_balance = $van_search->running_balance - $van_selling->total_amount;
            $van_selling_ledger_save = new Van_selling_ar_ledger([
                'customer_id' => $request->input('customer_id'),
                'van_selling_print_id' => $van_selling->id,
                'van_selling_pcm_id' => NULL,
                'van_selling_payment_id' => NULL,
                'adjustments' => $van_selling->total_amount * -1,
                'sku_price_adjustments' => 0,
                'cm_amount' => 0,
                'price_update' => 0,
                'actual_stocks_on_hand' => 0,
                'charge_payment' => 0,
                'amount' => 0,
                'collection' => 0,
                'over_short' => $van_search->over_short,
                'running_balance' => $running_balance,
                'should_be' => 0,
                'principal_id' => 0,
                'user_id' => auth()->user()->id,
                'date' => $date,
                'remarks' => $request->input('remarks'),
            ]);
            $van_selling_ledger_save->save();

            Van_selling_printed::where('id', $request->input('van_selling_id'))
                ->update([
                    'remarks' => 'CANCELLED',
                    'date_paid_or_cancelled' => $date,
                ]);

            foreach ($van_selling->van_selling_printed_details as $key => $details) {
                $customer_id = $van_selling->customer_id;
                $sku_code = $details->sku->sku_code;
                $van_selling_ledger_result = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                $total = $details->quantity * $details->price;

                $van_selling_upload_ledger = new Van_selling_upload_ledger([
                    'customer_id' => $customer_id,
                    'principal' => $van_selling_ledger_result[0]->principal,
                    'sku_code' => $van_selling_ledger_result[0]->sku_code,
                    'description' => $van_selling_ledger_result[0]->description,
                    'unit_of_measurement' => $van_selling_ledger_result[0]->unit_of_measurement,
                    'sku_type' => $van_selling_ledger_result[0]->sku_type,
                    'butal_equivalent' => $van_selling_ledger_result[0]->butal_equivalent,
                    'reference' => 'CANCELLED DR',
                    'beg' => $van_selling_ledger_result[0]->beg,
                    'van_load' => 0,
                    'sales' => 0,
                    'adjustments' => 0,
                    'inventory_adjustments' => $details->quantity * -1,
                    'clearing' => 0,
                    'end' => $van_selling_ledger_result[0]->end - $details->quantity,
                    'unit_price' => $details->price,
                    'total' => $total,
                    'running_balance' => $van_selling_ledger_result[0]->running_balance + $total,
                    'date' => $date,
                    'remarks' => 'CANCELLED TRANSACTION',
                ]);

                $van_selling_upload_ledger->save();
            }
            return 'saved';
        } else {
            return 'error';
        }
    }
}
