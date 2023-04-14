<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use App\Transfer_to_bran;
use App\Transfer_to_bran_details;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Transfer_to_branch_report_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal','!=','None')->get();
            return view('transfer_to_branch_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'transfer_sku_to_branch_main_tab',
                'sub_tab' => 'transfer_sku_to_branch_sub_tab',
                'active_tab' => 'transfer_to_branch_report',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Pl/');
        }
    }

    public function transfer_to_branch_show_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        //return $request->input();

        $transfer_to_bran = Transfer_to_bran::where('principal_id', $request->input('principal'))->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('transfer_to_branch_show_list', [
            'transfer_to_bran' => $transfer_to_bran
        ]);
    }

    public function transfer_to_branch_show_details($id)
    {
        $variable_explode = explode('=', $id);
        $id = $variable_explode[0];
        $principal_name = $variable_explode[1];


        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $user = User::select('name')->where('id', auth()->user()->id)->first();
        $transfer_to_bran_details = transfer_to_bran_details::where('transfer_id', $id)->get();

        return view('transfer_to_branch_show_details', [
            'transfer_to_bran_details' => $transfer_to_bran_details
        ])->with('principal_name', $principal_name)
            ->with('prepared_by', $user)
            ->with('date', $date)
            ->with('id', $id);
    }
}
