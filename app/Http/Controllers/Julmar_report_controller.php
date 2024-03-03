<?php

namespace App\Http\Controllers;

use App\Bo_allowance_adjustments_details;
use App\Invoice_cost_adjustments;
use App\Return_to_principal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Julmar_report_controller extends Controller
{
    public function return_to_principal_report_generate($id, $report_type)
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $return_to_principal = Return_to_principal::select('id', 'received_id')->find($id);
            return view('return_to_principal_report_generate', [
                'user' => $user,
                'return_to_principal' => $return_to_principal,
                'main_tab' => '',
                'sub_tab' => '',
                'active_tab' => '',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bo_allowance_adjustments_report_generate($id)
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $bo_adjustments_details = Bo_allowance_adjustments_details::where('bo_allowance_id', $id)->get();
            return view('bo_allowance_adjustments_report_generate', [
                'user' => $user,
                'bo_adjustments_details' => $bo_adjustments_details,
                'main_tab' => '',
                'sub_tab' => '',
                'active_tab' => '',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_cost_adjustments_report_generate($id)
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $invoice_cost_adjustment = Invoice_cost_adjustments::find($id);
            return view('invoice_cost_adjustments_report_generate', [
                'user' => $user,
                'invoice_cost_adjustment' => $invoice_cost_adjustment,
                'main_tab' => '',
                'sub_tab' => '',
                'active_tab' => '',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }
}
