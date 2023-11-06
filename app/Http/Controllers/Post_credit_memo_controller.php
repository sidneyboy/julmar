<?php

namespace App\Http\Controllers;

use App\Bad_order;
use App\Return_good_stock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Post_credit_memo_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $return_good_stock = Return_good_stock::select('pcm_number', 'id')
                ->where('status', 'verified')
                ->get();

            $bad_order = Bad_order::select('pcm_number', 'id')
                ->where('status', 'verified')
                ->get();

            return view('post_credit_memo', [
                'user' => $user,
                'return_good_stock' => $return_good_stock,
                'bad_order' => $bad_order,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'post_credit_memo',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function credit_memo_proceed(Request $request)
    {
        $explode = explode('-', $request->input('cm_id'));
        $transaction = $explode[0];
        $cm_id = $explode[1];

        if ($transaction == 'RGS') {
            $cm_data = Return_good_stock::find($cm_id);
        } elseif ($transaction == 'BO') {
            $cm_data = Bad_order::find($cm_id);
        }

        return view('credit_memo_proceed', [
            'cm_data' => $cm_data,
        ])->with('transaction',$transaction);
    }
}
