<?php

namespace App\Http\Controllers;
use App\Receiving_draft;
use App\Receiving_draft_main;
use App\User;
use App\Sku_add;
use App\Sku_principal;
use App\Purchase_order;
use Illuminate\Http\Request;

class Receiving_draft_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            date_default_timezone_set('Asia/Manila');
            $date = date('Ymd');
            $time = date('his');
            $session_id = $date."".$time;
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::select('id','principal')->where('principal','!=','none')->get();
            return view('receiving_draft', [
                'user' => $user,
                'principal' => $principal,
                'session_id' => $session_id,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'receiving_draft',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function receiving_draft_proceed(Request $request)
    {
        $purchase_order = Purchase_order::select('id','purchase_id')->where('remarks','!=','Received')->get();
        $sku = Sku_add::select('id','principal_id')->where('barcode',$request->input('barcode'))->where('sku_type','case')->first();

       if ($sku->principal_id == $request->input('principal_id')) {
           $check_draft = Receiving_draft::where('sku_id',$sku->id)->where('session_id',$request->input('session_id'))->count();
           if ($check_draft == 0) {
                $new_draft = new Receiving_draft([
                    'sku_id' => $sku->id,
                    'session_id' => $request->input('session_id'),
                    'user_id' => auth()->user()->id,
                ]);

                $new_draft->save();

                $receiving_draft = Receiving_draft::select('id','sku_id','user_id','session_id')->where('session_id',$request->input('session_id'))->get();

                return view('receiving_draft_proceed',[
                    'receiving_draft' => $receiving_draft,
                    'purchase_order' => $purchase_order,
                ])->with('session_id',$request->input('session_id'));
           }else{
             return 'existing';
           }
       }else{
        return 'wrong_sku';
       }
    }

    public function receiving_draft_final_saved(Request $request)
    {
        $new = new Receiving_draft_main([
            'purchase_order_id' => $request->input('purchase_id'),
            'session_id' => $request->input('session_id'),
            'user_id' => auth()->user()->id,
        ]);

        $new->save();

        foreach ($request->input('quantity_received') as $key => $value) {
           Receiving_draft::where('id', $key)
            ->where('session_id', $request->input('session_id'))
            ->update([
                'quantity' => $request->input('quantity_received')[$key],
                'remarks' => $request->input('remarks')[$key],
            ]);
        }

        return 'saved';
    }
}
