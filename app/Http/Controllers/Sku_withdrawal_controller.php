<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Sku_add;
use App\Sku_ledger;
use App\Agent;
use App\Sku_price_details;
use DB;
use Cart;
use Illuminate\Http\Request;

class Sku_withdrawal_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            $principal = Sku_principal::select('id', 'contact_number', 'principal')->where('principal', '!=', 'none')->get();
           

            return view('sku_withdrawal', [
                'user' => $user,
                'principal' => $principal,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'sku_withdrawal',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sku_withdrawal_proceed(Request $request)
    {
        $sku = Sku_add::where('principal_id', $request->input('principal_id'))
            ->where('sku_type', $request->input('sku_type'))
            ->get();

        return view('sku_withdrawal_proceed', [
            'sku' => $sku,
        ])->with('principal_id', $request->input('principal_id'))
            ->with('sku_type', $request->input('sku_type'))
            ->with('price_level', $request->input('price_level'));
    }

    public function sku_withdrawal_final_summary(Request $request)
    {
        //return $request->input();
        $sku_add = Sku_add::find($request->input('sku_id'));
        $sku_price_details = Sku_price_details::where('sku_id', $request->input('sku_id'))->first();
        if ($request->input('price_level') == 'price_1') {
            $price = $sku_price_details->price_1;
        } else if ($request->input('price_level') == 'price_2') {
            $price = $sku_price_details->price_2;
        } else if ($request->input('price_level') == 'price_3') {
            $price = $sku_price_details->price_3;
        } else if ($request->input('price_level') == 'price_4') {
            $price = $sku_price_details->price_4;
        } else if ($request->input('price_level') == 'price_5') {
            $price = $sku_price_details->price_5;
        }

        $cart_checker = \Cart::session(auth()->user()->id)->get($sku_add->id);
        if ($cart_checker) {
            \Cart::session(auth()->user()->id)->remove($sku_add->id);

            \Cart::session(auth()->user()->id)->add(array(
                'id' => $sku_add->id,
                'name' => $sku_add->description,
                'price' => $price,
                'quantity' => $request->input('quantity'),
                'attributes' => array(),
                'associatedModel' => $sku_add,
            ));
        } else {
            \Cart::session(auth()->user()->id)->add(array(
                'id' => $sku_add->id,
                'name' => $sku_add->description,
                'price' => $price,
                'quantity' => $request->input('quantity'),
                'attributes' => array(),
                'associatedModel' => $sku_add,
            ));
        }

        $cart = Cart::session(auth()->user()->id)->getContent();
        $agent = Agent::select('id','full_name')->get();
        return view('sku_withdrawal_final_summary', [
            'cart' => $cart,
            'agent' => $agent,
            'principal_id' => $request->input('principal_id'),
            'price_level' => $request->input('price_level'),
            'sku_type' => $request->input('sku_type'),
        ]);
    }

    public function sku_withdrawal_very_final_summary(Request $request)
    {
        // return $request->input();

        foreach ($request->input('price') as $key => $data) {
            \Cart::session(auth()->user()->id)->update($key,[
                'price' => $data,
            ]);
        }

        $cart = Cart::session(auth()->user()->id)->getContent();
       
        return view('sku_withdrawal_very_final_summary',[
            'cart' => $cart,
            'principal_id' => $request->input('principal_id'),
            'price_level' => $request->input('price_level'),
            'sku_type' => $request->input('sku_type'),
            'agent' => $request->input('agent'),
        ]);
    }

    public function sku_withdrawal_save(Request $request)
    {
        $cart = Cart::session(auth()->user()->id)->getContent();

        foreach ($cart as $key => $data) {
            $sku_id = $data->id;

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));
            $count_ledger_row = count($ledger_results);

            if ($count_ledger_row > 0) {
                $running_balance = $ledger_results[0]->running_balance - $data->quantity;
                $total = $data->quantity * $data->price;
                $running_amount = $ledger_results[0]->running_amount - $total;
                $new_sku_ledger = new Sku_ledger([
                    'sku_id' => $data->id,
                    'quantity' => $data->quantity*-1,
                    'running_balance' => $running_balance,
                    'user_id' => auth()->user()->id,
                    'transaction_type' => 'out from warehouse',
                    'all_id' => $request->input('delivery_receipt'),
                    'principal_id' => $ledger_results[0]->principal_id,
                    'sku_type' => $ledger_results[0]->sku_type,
                    'amount' => $data->price,
                    'running_amount' => $running_amount,
                ]);

                $new_sku_ledger->save();
            } else {
                return 'ledger_error';
            }
        }
    }
}
