<?php

namespace App\Http\Controllers;

use App\User;
use App\Vs_inventory_ledger;
use App\Van_selling_upload;
use App\Vs_sales;
use DB;
use Illuminate\Http\Request;

class Van_selling_import_data_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('van_selling_import_data', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_import_data',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_import_data_save(Request $request)
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
        if ($csv[0][3] == 'VAN SELLING EXPORT') {
            $van_selling_upload = Van_selling_upload::select('van_selling_export_code')->where('van_selling_export_code', $csv[1][3])->first();
            if ($van_selling_upload) {
                return 'Existing File';
            } else {
                $van_selling_upload_save = new Van_selling_upload([
                    'van_selling_export_code' => $csv[1][3],
                    'date' => $date,
                    'customer_id' => $csv[1][1],
                    'date_range' => $csv[1][6],
                ]);

                $van_selling_upload_save->save();
                $van_selling_upload_save_last_id = $van_selling_upload_save->id;


                $counter = count($csv);
                //return $csv;

                for ($i = 4; $i < $counter; $i++) {
                    $customer_id = $csv[1][1];
                    $sku_code = $csv[$i][3];
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Vs_inventory_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    $new_vs_inventory_ledger = new Vs_inventory_ledger([
                        'user_id' => auth()->user()->id,
                        'customer_id' => $customer_id,
                        'principal_id' => $ledger_results[0]->principal_id,
                        'transaction' => 'sales',
                        'sku_id' => $ledger_results[0]->sku_id,
                        'beginning_inventory' => $ledger_results[0]->ending_inventory,
                        'quantity' => ($csv[$i][5]) * -1,
                        'ending_inventory' => $ledger_results[0]->ending_inventory - $csv[$i][5],
                        'unit_price' => $csv[$i][6],
                        'all_id' => $csv[$i][2],
                        'sku_code' => $sku_code,
                    ]);

                    $new_vs_inventory_ledger->save();

                    $new_vs_sales = new Vs_sales([
                        'user_id' => auth()->user()->id,
                        'customer_id' => $customer_id,
                        'principal_id' => $ledger_results[0]->principal_id,
                        'customer_store_name' => $csv[$i][1],
                        'reference' => $csv[$i][2],
                        'sku_id' => $ledger_results[0]->sku_id,
                        'quantity' => $csv[$i][5],
                        'unit_price' => $csv[$i][6],
                        'area' => $csv[$i][8],
                        // 'location' => $csv[$i][9],
                        'date_sold' => $csv[$i][0],
                    ]);

                    $new_vs_sales->save();
                }
            }
        } else {
            return 'Existing File';
        }

        // return redirect('van_selling_import_data')->with('success', 'Data Saved');
    }
}
