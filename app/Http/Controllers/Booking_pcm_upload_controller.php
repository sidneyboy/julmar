<?php

namespace App\Http\Controllers;

use App\User;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Bad_order;
use App\Bad_order_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Booking_pcm_upload_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('booking_pcm_upload', [
                'user' => $user,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'booking_pcm_upload',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function booking_pcm_upload_process(Request $request)
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
        $explode = explode('-', $csv[0][5]);
        $transaction = $explode[1];

        if ($transaction == "RGS") {
            $checker = Return_good_stock::where('pcm_number', $csv[0][5])->first();
            if ($checker) {
                $new_rgs = new Return_good_stock([
                    'delivery_receipt' => "Previous RGS",
                    'user_id' => auth()->user()->id,
                    'principal_id' => $csv[1][2],
                    'sku_type' => $csv[1][4],
                    'total_amount' => 0,
                    'pcm_number' => $csv[0][5],
                    'customer_id' => $csv[0][1],
                    'agent_id' => $csv[1][3],
                ]);

                $new_rgs->save();
                for ($i = 3; $i < $counter; $i++) {
                    if ($csv[$i][0] != 'Total') {
                        $new_details = new Return_good_stock_details([
                            'return_good_stock_id' => $new_rgs->id,
                            'sku_id' => $csv[$i][0],
                            'quantity' => $csv[$i][3],
                            'unit_price' => $csv[$i][4],
                            'user_id' => auth()->user()->id,
                        ]);

                        $new_details->save();
                    } else {
                        Return_good_stock::where('id', $new_rgs->id)
                            ->update([
                                'total_amount' => $csv[$i][5],
                            ]);
                    }
                }
            } else {
                return 'Existing Data';
            }
        } else {
            $checker = Return_good_stock::where('pcm_number', $csv[0][5])->first();
            if ($checker) {
                $new_bo = new Bad_order([
                    'user_id' => auth()->user()->id,
                    'principal_id' => $csv[1][2],
                    'sku_type' => $csv[1][4],
                    'total_amount' => 0,
                    'pcm_number' => $csv[0][5],
                    'customer_id' => $csv[0][1],
                    'agent_id' => $csv[1][3],
                ]);

                $new_bo->save();

                for ($i = 3; $i < $counter; $i++) {
                    if ($csv[$i][0] != 'Total') {
                        $new_details = new Bad_order_details([
                            'bad_order_id' => $new_bo->id,
                            'sku_id' => $csv[$i][0],
                            'quantity' => $csv[$i][3],
                            'unit_price' => $csv[$i][4],
                            'user_id' => auth()->user()->id,
                        ]);

                        $new_details->save();
                    } else {
                        Bad_order::where('id', $new_bo->id)
                            ->update([
                                'total_amount' => $csv[$i][5],
                            ]);
                    }
                }
            } else {
                return 'Existing Data';
            }
        }
    }
}
