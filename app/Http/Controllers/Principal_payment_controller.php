<?php

namespace App\Http\Controllers;
use App\Sku_principal;
use App\Principal_ledger;
use App\Principal_payment;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Principal_payment_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal_data = Sku_principal::select('id','principal')->where('principal','!=','none')->get();
            return view('principal_payment', [
                'user' => $user,
                'principal_data' => $principal_data,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'principal_payment',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function principal_payment_generate_accounts_payable(Request $request)
    {

        
        $principal_ledger = Principal_ledger::where('principal_id', $request->input('principal'))->orderBy('id', 'DESC')->limit(1)->first();
        if ($principal_ledger) {
            return number_format($principal_ledger->accounts_payable_end, 2, ".", ",");
        }else{
            return 0;
        }
    }

    public function principal_payment_generate_final_summary(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        //return  $request->input();
        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();

        $amount = str_replace(',', '', $request->input('amount'));
        $current_accounts_payable_final = str_replace(',', '', $request->input('current_accounts_payable_final'));
        $principal = Sku_principal::select('principal')->where('id', $request->input('principal'))->first();
        return view('principal_payment_generate_final_summary')
            ->with('amount', $amount)
            ->with('principal', $principal)
            ->with('date', $date)
            ->with('employee_name', $employee_name)
            ->with('principal_id', $request->input('principal'))
            ->with('current_accounts_payable_final', $current_accounts_payable_final)
            ->with('cheque_number', $request->input('cheque_number'))
            ->with('disbursement_number', $request->input('disbursement_number'));
    }

    public function princpal_payment_save(Request $request)
    {
        //return $request->input();

        $principal_payment_save = new Principal_payment([
            'principal_id' => $request->input('principal_id'),
            'current_accounts_payable_final' => $request->input('current_accounts_payable_final'),
            'user_id' => auth()->user()->id,
            'cheque_number' => $request->input('cheque_number'),
            'disbursement_number' => $request->input('disbursement_number'),
            'payment' => $request->input('amount'),
        ]);

        $principal_payment_save->save();
       

        $principal_ledger = Principal_ledger::where('principal_id', $request->input('principal_id'))->orderBy('id', 'DESC')->limit(1)->first();

        $principal_ledger_accounts_payable_beginning = $principal_ledger->accounts_payable_end;
        $principal_ledger_saved = new Principal_ledger([
            'principal_id' => $request->input('principal_id'),
            'date' => $request->input('date'),
            'all_id' => $principal_payment_save->id,
            'transaction' => 'payment',
            'accounts_payable_beginning' => $principal_ledger_accounts_payable_beginning,
            'received' => 0,
            'returned' => 0,
            'adjustment' => 0,
            'payment' => $request->input('amount'),
            'accounts_payable_end' => $principal_ledger_accounts_payable_beginning - $request->input('amount'),
        ]);

        $principal_ledger_saved->save();

        return 'saved';
    }
}
