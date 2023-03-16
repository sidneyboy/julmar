<?php

namespace App\Http\Controllers;

use App\User;
use App\Disbursement;
use DB;
use Illuminate\Http\Request;

class Disbursement_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('disbursement_report', [
                'user' => $user,
                'main_tab' => '',
                'sub_tab' => '',
                'active_tab' => 'disbursement_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function disbursement_report_show_data(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $disbursement = Disbursement::whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('disbursement_report_show_data',[
            'disbursement' => $disbursement,
        ]);
    }
}
