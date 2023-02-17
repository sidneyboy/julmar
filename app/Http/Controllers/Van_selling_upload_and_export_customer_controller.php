<?php

namespace App\Http\Controllers;

use App\User;
use App\Van_selling_customer;
use App\Location;
use Illuminate\Http\Request;

class Van_selling_upload_and_export_customer_controller extends Controller
{
    public function vs_upload_and_export_customer()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            return view('vs_upload_and_export_customer', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'vs_upload_and_export_customer',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function vs_upload_and_export_proceed(Request $request)
    {
        if ($request->input('to_do') == 'Extract Customer') {
            $location = Location::find($request->input('location_id'));
            $van_selling_customer = Van_selling_customer::where('location_id', $request->input('location_id'))->get();
            return view('vs_upload_and_export_proceed_to_extraction', [
                'van_selling_customer' => $van_selling_customer,
                'location' => $location,
            ]);
        } else {
            return view('vs_upload_and_export_proceed');
        }
    }

    public function vs_upload_and_export_proceed_upload(Request $request)
    {
        $csv = array();
        $count_all_data = $_FILES["customer_csv_file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }
        //return $csv[0][12];
        $counter = count($csv);

        if (isset($csv[0][12])) {
            if ($csv[0][12] != "VAN_SELLING_CUSTOMER_CSV_FILE") {
                return redirect('vs_upload_and_export_customer')->with('error', 'Incorrect File');
            } else {
                for ($i = 1; $i < $counter; $i++) {
                    $new = new Van_selling_customer([
                        'location_id' => $csv[$i][1],
                        'store_name' => $csv[$i][3],
                        'store_type' => $csv[$i][4],
                        'barangay' => $csv[$i][5],
                        'address' => $csv[$i][6],
                        'contact_person' => $csv[$i][7],
                        'contact_number' => $csv[$i][8],
                        'latitude' => $csv[$i][9],
                        'longitude' => $csv[$i][10],
                    ]);

                    $new->save();
                }

                return redirect('vs_upload_and_export_customer')->with('success', 'Van Selling Customer Data Saved');
            }
        } else {
            return redirect('vs_upload_and_export_customer')->with('error', 'Incorrect File');
        }
    }
}
