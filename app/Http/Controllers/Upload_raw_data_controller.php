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
            if ($csv[$i][22] != 'Cost of sales') {
                if ($csv[$i][41] != 'Past Due') {
                    $barcode = Sku_add::select('barcode','id')->where('sku_code', $csv[$i][20])->where('sku_type', $csv[$i][46])->first();

                    $new  = new Invoice_raw([
                        'invoice_data' => $csv[$i][0],
                        'customer' => $csv[$i][8],
                        'delivery_receipt' => $csv[$i][2],
                        'sales_representative' => $csv[$i][17],
                        'sku_code' => $csv[$i][20],
                        'description' => $csv[$i][21],
                        'quantity' => $csv[$i][19],
                        'sku_type' => $csv[$i][46],
                        'principal' => $csv[$i][47],
                        'barcode' => $barcode->barcode,
                        'sku_id' => $barcode->id,
                    ]);

                    $new->save();
                }
            }
        }
    }
}
