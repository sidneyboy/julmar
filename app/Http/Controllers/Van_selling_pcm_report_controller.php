<?php

namespace App\Http\Controllers;
use App\Customer;
use App\User;
use App\Van_selling_upload_ledger;
use App\Van_selling_pcm;
use App\Van_selling_pcm_details;
use Illuminate\Http\Request;

class Van_selling_pcm_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_pcm_report', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_pcm_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_pcm_report_generate_data(Request $request)
    {
        $data_range = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($data_range[0]));
        $date_to = date('Y-m-d', strtotime($data_range[1]));

        $van_selling_pcm = Van_selling_pcm::whereBetween('date', [$date_from, $date_to])
            ->where('customer_id', $request->input())
            ->get();

        return view('van_selling_pcm_report_generate_data', [
            'van_selling_pcm' => $van_selling_pcm,
        ]);
    }
}
