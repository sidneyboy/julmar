<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Purchase_order;
use App\Principal_ledger;
use App\Disbursement;
use Illuminate\Http\Request;

class Disbursement_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
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
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function disbursement_show_selection(Request $request)
    {
        if ($request->input('disbursement') == 'payment to principal') {
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();

            return view('disbursement_show_selection',[
                'principal' => $principal,
            ])->with('disbursement',$request->input('disbursement'));
        }
    }

    public function disbursement_proceed(Request $request)
    {
        $purchase_order = Purchase_order::select('id', 'purchase_id')->where('principal_id', $request->input('principal_id'))->where('status', '!=', 'paid')->orderBy('id', 'desc')->get();
        return view('disbursement_proceed', [
            'purchase_order' => $purchase_order,
        ])->with('disbursement', $request->input('disbursement'))
            ->with('principal_id', $request->input('principal_id'));
    }

    public function disbursement_final_summary(Request $request)
    {
        $purchase_order = Purchase_order::select('id', 'total_final_cost', 'total_less_other_discount', 'net_payable', 'principal_id', 'purchase_id')->find($request->input('purchase_id'));
        return view('disbursement_final_summary', [
            'purchase_order' => $purchase_order,
        ])->with('amount', str_replace(',', '', $request->input('amount')))
            ->with('bank', $request->input('bank'))
            ->with('check_deposit_slip', $request->input('check_deposit_slip'))
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
            'purchase_order_id' => $request->input('purchase_order_id'),
            'user_id' => auth()->user()->id,
            'disbursement' => $request->input('disbursement'),
            'bank' => $request->input('bank'),
            'check_deposit_slip' => $request->input('check_deposit_slip'),
            'principal_id' => $request->input('principal_id'),
            'amount' => $request->input('amount'),
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

        $file = $request->file('file');
        $file_name = 'file-' . time() . '.' . $file->getClientOriginalExtension();
        $path_file = $file->storeAs('public', $file_name);

        Purchase_order::where('id', $request->input('purchase_order_id'))
            ->update([
                'po_confirmation_image' => $file_name,
                'status' => 'paid',
            ]);

        return 'saved';
    }
}
