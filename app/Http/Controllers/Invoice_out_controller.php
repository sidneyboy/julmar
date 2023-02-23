<?php

namespace App\Http\Controllers;
use App\User;
use App\Invoice_draft;
use Illuminate\Http\Request;

class Invoice_out_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $invoice_draft = Invoice_draft::where('status',null)->get();
            return view('invoice_out', [
                'user' => $user,
                'invoice_draft' => $invoice_draft,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'invoice_out',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }
}
