<?php

namespace App\Http\Controllers;
use App\User;
use App\Van_selling_upload_ledger;
use App\Van_selling_upload;
use App\Van_selling_sales;
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
                return redirect('van_selling_import_data')->with('success', 'Existing File');
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

                for ($i = 4; $i < $counter; $i++) {
                    $customer_id = $csv[1][1];
                    $sku_code = $csv[$i][3];
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Van_selling_upload_ledgers WHERE sku_code = '$sku_code' AND customer_id = '$customer_id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    $running_balance = $ledger_results[0]->running_balance - ($csv[$i][5] * $csv[$i][6]);
                    $beg = $ledger_results[0]->end;
                    $end = $beg - $csv[$i][5];


                    $van_selling_sales = new Van_selling_sales([
                        'customer_id' => $csv[1][1],
                        'store_name' => $csv[$i][1],
                        'vs_upload_id' => $van_selling_upload_save_last_id,
                        'principal' => $ledger_results[0]->principal,
                        'sku_code' => $csv[$i][3],
                        'description' => $ledger_results[0]->description,
                        'unit_of_measurement' => $ledger_results[0]->unit_of_measurement,
                        'sku_type' => $ledger_results[0]->sku_type,
                        'butal_equivalent' => $ledger_results[0]->butal_equivalent,
                        'reference' => $csv[$i][2],
                        'sales' => $csv[$i][5],
                        'unit_price' => $csv[$i][6],
                        'total' => $csv[$i][5] * $csv[$i][6],
                        'date' => $date,
                        'date_sold' => $csv[$i][0],
                        'location' => $csv[$i][8],
                    ]);

                    $van_selling_sales->save();

                    $van_selling_upload_ledger = new Van_selling_upload_ledger([
                        'customer_id' => $csv[1][1],
                        'vs_upload_id' => $van_selling_upload_save_last_id,
                        'principal' => $ledger_results[0]->principal,
                        'sku_code' => $csv[$i][3],
                        'description' => $ledger_results[0]->description,
                        'unit_of_measurement' => $ledger_results[0]->unit_of_measurement,
                        'sku_type' => $ledger_results[0]->sku_type,
                        'butal_equivalent' => $ledger_results[0]->butal_equivalent,
                        'reference' => $csv[$i][1],
                        'beg' => $beg,
                        'van_load' => 0,
                        'sales' => $csv[$i][5],
                        'end' => $end,
                        'unit_price' => $csv[$i][6],
                        'total' => $csv[$i][5] * $csv[$i][6],
                        'running_balance' => $running_balance,
                        'date' => $date,
                        'remarks' => $csv[$i][0],
                    ]);

                    $van_selling_upload_ledger->save();
                }
            }
        } else {
            return redirect('van_selling_import_data')->with('success', 'Existing File');
        }

        return redirect('van_selling_import_data')->with('success', 'Data Saved');
    }
}
