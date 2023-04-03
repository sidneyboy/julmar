<?php

namespace App\Http\Controllers;

use App\User;
use App\Invoice_raw;
use App\Sku_add;
use Illuminate\Http\Request;

class Upload_raw_data_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('upload_raw_data', [
                'user' => $user,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'upload_raw_data',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function upload_raw_data_saved(Request $request)
    {
        $csv = array();
        $count_all_data = $_FILES["file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }

        //return $csv;
        $counter = count($csv);

        for ($i = 1; $i < $counter; $i++) {
            if ($csv[$i][3] != 'Cost of sales') {
                $barcode = Sku_add::select('barcode', 'id')->where('sku_code', $csv[$i][9])->where('sku_type', $csv[$i][11])->first();


                if (str_contains($csv[$i][3], 'DISCOUNT')) {
                } else {
                    if ($csv[$i][8] != '') {
                        $csv_unit_price = str_replace(',', '', $csv[$i][5]) . '<br />';
                        $unit_price = floatval($csv_unit_price) / $csv[$i][8];
                        if ($barcode) {
                            $new  = new Invoice_raw([
                                'date' => $csv[$i][0],
                                'invoice_data' => $csv[$i][2],
                                'customer' => $csv[$i][6],
                                'delivery_receipt' => $csv[$i][2],
                                'sales_representative' => $csv[$i][7],
                                'sku_code' => $csv[$i][9],
                                'description' => $csv[$i][10],
                                'quantity' => $csv[$i][8],
                                'sku_type' => $csv[$i][11],
                                'principal' => $csv[$i][12],
                                'barcode' => $barcode->barcode,
                                'sku_id' => $barcode->id,
                                'unit_price' => $unit_price,
                            ]);

                            $new->save();
                        } else {
                            echo 'wala <br />';
                        }
                    }
                }
            }
        }
    }
}
