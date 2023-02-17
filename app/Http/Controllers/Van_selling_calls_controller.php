<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_calls;
use App\Customer;
use Illuminate\Http\Request;

class Van_selling_calls_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('van_selling_import_calls', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_import_calls',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function vs_import_calls_process(Request $request)
    {
        $csv = array();
        $count_all_data = $_FILES["os_csv_file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }
        //return $csv;
        $counter = count($csv);

        if (isset($csv[0][2])) {
            if ($csv[0][2] != "CALLS REPORT") {
                return redirect('van_selling_import_calls')->with('error', 'Incorrect File');
            } else {
                for ($i = 2; $i < $counter; $i++) {
                    if ($csv[$i][0] != 'SUMMARY' and $csv[$i][0] != 'PRODUCTIVE CALLS' and $csv[$i][0] != 'UNPRODUCTIVE CALLS' and $csv[$i][0] != 'TOTAL CALLS') {
                        $new = new Van_selling_calls([
                            'customer_id' => $csv[0][1],
                            'store_name' => $csv[$i][0],
                            'address' => $csv[$i][1],
                            'date' => $csv[$i][2],
                            'remarks' => $csv[$i][3],
                        ]);

                        $new->save();
                    }
                }

                return redirect('van_selling_import_calls')->with('success', 'Van Selling Calls Data Saved');
            }
        } else {
            return redirect('van_selling_import_calls')->with('error', 'Incorrect File');
        }
    }

    public function van_selling_calls_report()
    {
        if (isset(auth()->user()->id)) {
            $customer = Customer::where('kind_of_business', 'VAN SELLING')->get();
            $user = User::select('id', 'name')->where('id', auth()->user()->id)->first();
           

            return view('van_selling_calls_report', [
                'customer' => $customer,
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_calls_report',
            ]);
        } else {
            return redirect('/');
        }
    }

    public function van_selling_calls_report_generate_data(Request $request)
    {
        $data_range = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($data_range[0]));
        $date_to = date('Y-m-d', strtotime($data_range[1]));

        $calls = Van_selling_calls::where('customer_id', $request->input('customer'))
            ->whereBetween('date', [$date_from, $date_to])
            ->get();

        $productive = Van_selling_calls::select('id')
            ->where('remarks', 'PRODUCTIVE')
            ->where('customer_id', $request->input('customer'))
            ->whereBetween('date', [$date_from, $date_to])
            ->count();

        $unproductive = Van_selling_calls::select('id')
            ->where('remarks', 'UNPRODUCTIVE')
            ->where('customer_id', $request->input('customer'))
            ->whereBetween('date', [$date_from, $date_to])
            ->count();

        return view('van_selling_calls_report_generate_data', [
            'calls' => $calls,
            'productive' => $productive,
            'unproductive' => $unproductive,
        ]);
    }
}
