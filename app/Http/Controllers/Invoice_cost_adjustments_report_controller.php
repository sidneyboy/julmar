<?php

namespace App\Http\Controllers;

use App\Sku_principal;
use App\Invoice_cost_adjustments;
use App\Invoice_cost_adjustment_details;
use App\Principal_discount;
use App\User;
use DB;
use Illuminate\Http\Request;

class Invoice_cost_adjustments_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('invoice_cost_adjustments_report', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'invoice_cost_adjustments_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function invoice_cost_adjustments_report_show_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $variable_explode = explode('=', $request->input('principal'));
        $principal_id = $variable_explode[0];
        $principal_name = $variable_explode[1];

        $invoice_cost_adjustment = Invoice_cost_adjustments::where('principal_id', $principal_id)->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])->get();

        return view('invoice_cost_adjustments_report_list', [
            'invoice_cost_adjustment' => $invoice_cost_adjustment
        ])->with('principal_id', $principal_id)
            ->with('principal_name', $principal_name);
    }

    public function invoice_cost_adjustments_show_details($id)
    {

        $invoice_cost_adjustment = Invoice_cost_adjustments::find($id);

        return view('invoice_cost_adjustments_show_details',[
            'invoice_cost_adjustment' => $invoice_cost_adjustment
        ]);
    }
}
