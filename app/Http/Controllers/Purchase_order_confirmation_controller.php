<?php

namespace App\Http\Controllers;
use App\User;
use App\Purchase_order;
use Illuminate\Http\Request;

class Purchase_order_confirmation_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $purchase_order = Purchase_order::select('id','purchase_id')->orderBy('id','desc')->get();
            return view('purchase_order_confirmation', [
                'user' => $user,
                'purchase_order' => $purchase_order,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'purchase_order_confirmation',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function purchase_order_confirmation_proceed(Request $request)
    {
        $purchase_order = Purchase_order::find($request->input('purchase_id'));

        return view('purchase_order_confirmation_proceed',[
            'purchase_order' => $purchase_order,
        ]);
    }
}
