<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_os_data;
use App\Customer;
use Illuminate\Http\Request;

class Van_selling_os_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            return view('van_selling_import_os', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_import_os',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function vs_import_os_process(Request $request)
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
            if ($csv[0][2] != "OUT OF STOCK") {
                return redirect('van_selling_import_os')->with('error', 'Incorrect File');
            } else {
                for ($i = 2; $i < $counter; $i++) {
                    $checker = Van_selling_os_data::select('id')->where('os_code', $csv[$i][13])->where('sku_code', $csv[$i][2])->first();
                    if ($checker) {
                        Van_selling_os_data::where('id', $checker->id)
                            ->update([
                                'served_quantity' => $csv[$i][8],
                                'served_unit_price' => $csv[$i][9],
                                'served_sub_total' => $csv[$i][10],
                                'served_date' => $csv[$i][11],
                            ]);
                    } else {

                        $new = new Van_selling_os_data([
                            'customer_id' => $csv[0][1],
                            'store_name' => $csv[$i][0],
                            'sku_code' => $csv[$i][2],
                            'description' => $csv[$i][3],
                            'quantity' => $csv[$i][4],
                            'os_unit_price' => $csv[$i][5],
                            'os_sub_total' => $csv[$i][6],
                            'os_date' => $csv[$i][7],
                            'served_quantity' => $csv[$i][8],
                            'served_unit_price' => $csv[$i][9],
                            'served_sub_total' => $csv[$i][10],
                            'served_date' => $csv[$i][11],
                            'principal' => $csv[$i][12],
                            'os_code' => $csv[$i][13],
                        ]);

                        $new->save();
                    }
                }

                return redirect('van_selling_import_os')->with('success', 'Van Selling OS Data Saved');
            }
        } else {
            return redirect('van_selling_import_os')->with('error', 'Incorrect File');
        }
    }

    public function van_selling_os_report()
    {
        if (isset(auth()->user()->id)) {
            $customer = Customer::where('kind_of_business', 'VAN SELLING')->get();
            $user = User::select('id', 'name')->where('id', auth()->user()->id)->first();

            return view('van_selling_os_report', [
                'user' => $user,
                'customer' => $customer,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_os_report',
            ]);
        } else {
            return redirect('/');
        }
    }

    public function van_selling_os_report_generate_data(Request $request)
    {
        $data_range = explode('-', $request->input('date_range'));
        $date_from = date('m/d/Y', strtotime($data_range[0]));
        $date_to = date('m/d/Y', strtotime($data_range[1]));

        $van_selling_os_report = Van_selling_os_data::where('customer_id', $request->input('customer'))
            ->whereBetween('os_date', [$date_from, $date_to])
            ->get();

        return view('van_selling_os_report_generate_data', [
            'van_selling_os_report' => $van_selling_os_report,
        ]);
    }
}
