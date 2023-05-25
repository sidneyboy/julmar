<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer_upload;
use App\Customer;
use App\Location;
use App\Sku_principal;
use App\Customer_principal_price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Customer_upload_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('customer_upload', [
                'user' => $user,
                'main_tab' => 'manage_customer_main_tab',
                'sub_tab' => 'manage_customer_sub_tab',
                'active_tab' => 'customer_upload',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function customer_upload_process(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $csv = array();
        $count_all_data = $_FILES["agent_csv_file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }
        //return $csv;
        $counter = count($csv);


        if ($csv[0][0] == 'New Customer') {
            $check_customer_upload = Customer_upload::where('export_code', $csv[0][1])->first();
            if ($check_customer_upload) {
                return 'existing_file';
                //return redirect('customer_upload')->with('error', 'Existing File');
            } else {
                $customer_upload = new Customer_upload([
                    'export_code' => $csv[0][1],
                ]);

                $customer_upload->save();

                for ($i = 2; $i < $counter; $i++) {
                    if ($csv[$i][0] == 'Principal') {
                        $check = Customer_principal_price::where('principal_id', $csv[$i][2])->where('customer_id', $csv[$i][1])->first();

                        if ($check) {
                            Customer_principal_price::where('customer_id', $csv[$i][1])
                                ->where('principal_id', $csv[$i][2])
                                ->update([
                                    'customer_id' => $csv[$i][1],
                                    'principal_id' => $csv[$i][2],
                                    'price_level' => $csv[$i][3],
                                    'user_id' => auth()->user()->id,
                                ]);
                        } else {
                            $customer_principal_price = new Customer_principal_price([
                                'customer_id' => $csv[$i][1],
                                'principal_id' => $csv[$i][2],
                                'price_level' => $csv[$i][3],
                                'user_id' => auth()->user()->id,
                            ]);

                            $customer_principal_price->save();
                        }
                    } else {
                        // echo $csv[$i][9];
                        Customer::where('id', $csv[$i][9])
                            ->update([
                                'store_name' => $csv[$i][1],
                                'location_id' => $csv[$i][4],
                                'detailed_location' => $csv[$i][6],
                                'contact_person' => $csv[$i][2],
                                'contact_number' => $csv[$i][3],
                                'kind_of_business' => $csv[$i][0],
                                'mode_of_transaction' => $csv[$i][10],
                                'status' => 'Pending Approval',
                                'longitude' => $csv[$i][7],
                                'latitude' => $csv[$i][8],
                            ]);
                    }
                }

                return 'saved';
                //return redirect('customer_upload')->with('success', 'Successfully Uploaded');
            }
        } else {
           // return redirect('customer_upload')->with('error', 'Incorrect File');
            return 'incorrect_file';
        }
    }

    public function customer_export()
    {
        $location = Location::get();
        $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
        return view('customer_export', [
            'mainTab' => '',
            'subTab'  => '',
            'activeTab' => '',
            'dashboard' => '',
            'principal_tab' => '',
            'return_to_principal_active_tab'  => '',
            'principal_sub_tab'  => '',
            'adjustment_tab' => '',
            'adjustment_sub_tab'  => '',
            'principal_active_tab'  => '',
            'personnel_tab' => '',
            'personnel_sub_tab'  => '',
            'personnel_active_tab'  => '',
            'transfer_tab' => '',
            'transfer_sub_tab'  => '',
            'transfer_active_tab'  => '',
            'transfer_to_branch_tab' => '',
            'transfer_to_branch_sub_tab'  => '',
            'transfer_to_branch_active_tab'  => '',
            'sales_order_tab' => 'sales_order_tab',
            'sales_order_tab_sub_tab'  => 'sales_order_tab_sub_tab',
            'sales_order_tab_active_tab'  => 'customer_export',
            'accounting' => '',
            'accounting_sub_tab'  => '',
            'accounting_active_tab'  => '',
            'van_selling_tab' => '',
            'van_selling_sub_tab'  => '',
            'van_selling_active_tab'  => '',
            'employee_name' => $employee_name,
            'location' => $location,
            'logistics_tab' => '',
            'logistics_sub_tab'  => '',
            'logistics_active_tab' => '',
        ]);
    }

    public function customer_agent_export(Request $request)
    {
        $customer_data = Customer::where('location_id', $request->input('location_id'))
            ->where('kind_of_business', '!=', 'VAN SELLING')
            ->get();

        $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'None')->get();

        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        return view('customer_agent_export', [
            'customer_data' => $customer_data,
            'principal' => $principal,
            'date' => $date,
        ]);
    }
}
