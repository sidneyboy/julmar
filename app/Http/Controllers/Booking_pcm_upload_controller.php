<?php

namespace App\Http\Controllers;

use App\User;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Bad_order;
use App\Bad_order_details;
use App\Sku_price_history;
use App\Customer_principal_price;
use App\Sku_price_details;
use Carbon\Carbon;
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
        // date_default_timezone_set('Asia/Manila');
        //$date = date('Y-m-d');

        $csv = array();
        $count_all_data = $_FILES["file"]["tmp_name"];
        if (($handle = fopen($count_all_data, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csv[] = $data;
            }
        }

        
        $counter = count($csv);

        $explode = explode('-', $csv[0][5]);
        $transaction = $explode[1];

        if ($transaction == "RGS") {
            $checker = Return_good_stock::where('pcm_number', $csv[0][5])->count();
            if ($checker == 0) {
                for ($i = 3; $i < count($csv); $i++) {
                    $id[$i][0] = $csv[$i][0];
                    $code[$i][1] = $csv[$i][1];
                    $description[$i][2] = $csv[$i][2];
                    $sku_type[$i][3] = $csv[$i][3];
                    $quantity[$i][4] = $csv[$i][4];
                }

                return view('booking_pcm_upload_process_page', [
                    'csv' => $csv,
                    'id' => $id,
                    'code' => $code,
                    'description' => $description,
                    'sku_type' => $sku_type,
                    'quantity' => $quantity,
                    'transaction' => $transaction,
                ]);
            } else {
                return 'Existing Data';
            }
        } elseif ($transaction == "BO") {
            $checker = Bad_order::where('pcm_number', $csv[0][5])->count();
            if ($checker == 0) {
                for ($i = 3; $i < count($csv); $i++) {
                    $id[$i][0] = $csv[$i][0];
                    $code[$i][1] = $csv[$i][1];
                    $description[$i][2] = $csv[$i][2];
                    $sku_type[$i][3] = $csv[$i][3];
                    $quantity[$i][4] = $csv[$i][4];
                }

                return view('booking_pcm_upload_process_page', [
                    'csv' => $csv,
                    'id' => $id,
                    'code' => $code,
                    'description' => $description,
                    'sku_type' => $sku_type,
                    'quantity' => $quantity,
                    'transaction' => $transaction,
                ]);
            } else {
                return 'Existing Data';
            }
        }else{
            return 'Incorrect File';
        }
    }

    public function booking_pcm_upload_final_process(Request $request)
    {
        //return $request->input();
        if ($request->input('transaction') == 'RGS') {
            $checker = Return_good_stock::where('pcm_number', $request->input('pcm_number'))->count();
            if ($checker == 0) {
                $new_rgs = new Return_good_stock([
                    'delivery_receipt' => $request->input('delivery_receipt'),
                    'user_id' => auth()->user()->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'total_amount' => 0,
                    'pcm_number' => $request->input('pcm_number'),
                    'customer_id' => $request->input('customer_id'),
                    'agent_id' => $request->input('agent_id'),
                ]);

                $new_rgs->save();
                foreach ($request->input('quantity') as $key => $data_quantity) {
                    $new_details = new Return_good_stock_details([
                        'return_good_stock_id' => $new_rgs->id,
                        'sku_id' => $key,
                        'quantity' => $data_quantity,
                        'unit_price' => 0,
                        'user_id' => auth()->user()->id,
                    ]);

                    $new_details->save();
                }

                // $customer_price_level = Customer_principal_price::select('price_level')
                //     ->where('customer_id', $request->input('customer_id'))
                //     ->where('principal_id', $request->input('principal_id'))
                //     ->first();



                // foreach ($request->input('quantity') as $key => $data_quantity) {
                //     $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as unit_price')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                //         ->where('sku_id', $key)
                //         ->orderBy('id', 'desc')
                //         ->first();

                //     if ($price_history) {
                //         $new_details = new Return_good_stock_details([
                //             'return_good_stock_id' => $new_rgs->id,
                //             'sku_id' => $key,
                //             'quantity' => $data_quantity,
                //             'unit_price' => $price_history->unit_price,
                //             'user_id' => auth()->user()->id,
                //         ]);

                //         $new_details->save();
                //     } else {
                //         $price_details = Sku_price_details::select($customer_price_level->price_level . ' as unit_price')
                //             ->where('sku_id', $key)
                //             ->first();

                //         $new_details = new Return_good_stock_details([
                //             'return_good_stock_id' => $new_rgs->id,
                //             'sku_id' => $key,
                //             'quantity' => $data_quantity,
                //             'unit_price' => $price_details->unit_price,
                //             'user_id' => auth()->user()->id,
                //         ]);

                //         $new_details->save();
                //     }
                // }
            } else {
                return 'Existing Data';
            }
        } elseif ($request->input('transaction') == 'BO') {

            $checker = Bad_order::where('pcm_number',  $request->input('pcm_number'))->count();
            if ($checker == 0) {
                $new_bo = new Bad_order([
                    'user_id' => auth()->user()->id,
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'total_amount' => 0,
                    'pcm_number' => $request->input('pcm_number'),
                    'customer_id' => $request->input('customer_id'),
                    'agent_id' => $request->input('agent_id'),
                ]);

                $new_bo->save();

                foreach ($request->input('quantity') as $key => $data_quantity) {

                    $new_details = new Bad_order_details([
                        'bad_order_id' => $new_bo->id,
                        'sku_id' => $key,
                        'quantity' => $data_quantity,
                        'unit_price' => 0,
                        'user_id' => auth()->user()->id,
                    ]);

                    $new_details->save();
                }

                // $customer_price_level = Customer_principal_price::select('price_level')
                //     ->where('customer_id', $request->input('customer_id'))
                //     ->where('principal_id', $request->input('principal_id'))
                //     ->first();

                // foreach ($request->input('quantity') as $key => $data_quantity) {
                //     $price_history = Sku_price_history::select('id', $customer_price_level->price_level . ' as price_level')->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)
                //         ->where('sku_id', $key)
                //         ->orderBy('id', 'desc')
                //         ->first();

                //     if ($price_history) {
                //         $new_details = new Bad_order_details([
                //             'bad_order_id' => $new_bo->id,
                //             'sku_id' => $key,
                //             'quantity' => $data_quantity,
                //             'unit_price' => $price_history->price_level,
                //             'user_id' => auth()->user()->id,
                //         ]);

                //         $new_details->save();
                //     } else {
                //         $price_details = Sku_price_details::select($customer_price_level->price_level . ' as price_level')
                //             ->where('sku_id', $key)
                //             ->first();

                //         $new_details = new Bad_order_details([
                //             'bad_order_id' => $new_bo->id,
                //             'sku_id' => $key,
                //             'quantity' => $data_quantity,
                //             'unit_price' => $price_details->price_level,
                //             'user_id' => auth()->user()->id,
                //         ]);

                //         $new_details->save();
                //     }
                // }
            } else {
                return 'Existing Data';
            }
        }
    }
}
