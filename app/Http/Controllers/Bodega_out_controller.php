<?php

namespace App\Http\Controllers;
use App\Sku_add;
use DB;
use App\Sku_ledgers;
use App\Sku_price_details;
use App\Sku_principal;
use App\Bodega_out;
use App\Bodega_out_details;
use App\Sku_ledger;
use App\User;
use Illuminate\Http\Request;

class Bodega_out_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')
                ->where('principal', '!=', 'none')
                ->where('principal', '!=', 'EPI')
                ->get();
            return view('bodega_out', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'bodega_out',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function bodega_out_show_input(Request $request)
    {

        if (is_null($request->input('principal')) or is_null($request->input('uom'))) {
            return 'no_input';
        } else {
            $sku_add = Sku_add::select('id', 'description', 'sku_code', 'category_id', 'sku_type')
                ->where('sku_type', $request->input('uom'))
                ->where('principal_id', $request->input('principal'))
                ->get();

            return view('bodega_out_input', [
                'sku_add' => $sku_add,
            ])->with('uom', $request->input('uom'))
                ->with('principal_id', $request->input('principal'));
        }
    }

    public function show_equivalent(Request $request)
    {

        $equivalent_butal_pcs = Sku_add::select('equivalent_butal_pcs')->find($request->input('sku'));

        return $equivalent_butal_pcs->equivalent_butal_pcs;
    }

    public function bodega_out_summary(Request $request)
    {


        $sku_add = Sku_add::find($request->input('sku'));
        $id = $request->input('sku');

        if ($sku_add->equivalent_sku_entryNo == 0 or '') {
            if ($request->input('sku_type') == 'Case') {
                return 'There is no equivalent butal for this SKU';
            } else {
                return 'There is no equivalent case for this SKU';
            }
        } else {
            $equivalents = Sku_add::find($sku_add->equivalent_sku_entryNo);
            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));



            $sku_price = Sku_price_details::where('sku_id', $id)->latest()->first();
            $count_ledger_counter = count($ledger_results);

            return view('bodega_out_final_summary')
                ->with('convert', $request->input('convert'))
                ->with('uom', $request->input('uom'))
                ->with('ledger_results', $ledger_results)
                ->with('sku_add', $sku_add)
                ->with('equivalents', $equivalents)
                ->with('sku_price', $sku_price)
                ->with('count_ledger_counter', $count_ledger_counter);
        }
    }

    public function bodega_out_saved(Request $request)
    {

        //return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');

        $variable_explode = explode('=', $request->input('principal_id'));
        $principal_id = $variable_explode[0];

        if ($request->input('uom') == 'Case') {
            $sku_id_case = $request->input('sku_id');
            $sku_id_butal = $request->input('equivalent_sku_id');

            $bodega_out_save = new Bodega_out([
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'remarks' => 'Case to Butal',
                'date' => $date
            ]);

            $bodega_out_save->save();
            $bodega_out_id = $bodega_out_save->id;

            $bodega_out_details_save = new Bodega_out_details([
                'bodega_out_id' => $bodega_out_id,
                'sku_id' => $sku_id_case,
                'quantity' => $request->input('convert'),
                'fuc_prices' => $request->input('fuc_prices'),
                'transfer_to_sku_id' => $request->input('equivalent_sku_id'),
                'transfer_quantity' => $request->input('transfered_quantity'),
            ]);

            $bodega_out_details_save->save();




            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_case' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


            //case
            $quantity_case = $request->input('convert') * -1;
            $running_balance_case =  $ledger_results[0]->running_balance - $request->input('convert');
            $last_final_unit_cost_case = $request->input('last_final_unit_cost_case');
            $total_cost_case = $last_final_unit_cost_case * $quantity_case;
            $running_total_cost_case = $ledger_results[0]->running_total_cost + $total_cost_case;
            if ($running_balance_case <= 0) {
                $final_unit_cost_case = $ledger_results[0]->final_unit_cost;
            } else {
                $final_unit_cost_case = $running_total_cost_case / $running_balance_case;
            }


            $ledger_add_case = new Sku_ledger([
                'sku_id' => $sku_id_case,
                'category_id' => $request->input('category_id'),
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'in_out_adjustments' => 'Case to Butal',
                'rr_dr' => $bodega_out_id,
                'sales_order_number' => '',
                'principal_invoice' => '',
                'quantity' => $quantity_case,
                'running_balance' => $running_balance_case,
                'unit_cost' => $last_final_unit_cost_case,
                'total_cost' => $total_cost_case,
                'adjustments' => 0,
                'running_total_cost' => $running_total_cost_case,
                'final_unit_cost' => $final_unit_cost_case,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add_case->save();



            $ledger_results_butal = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_butal' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            if ($ledger_results_butal) {


                $quantity_butal = $request->input('transfered_quantity');
                $running_balance_butal = $quantity_butal + $ledger_results_butal[0]->running_balance;
                $last_final_unit_cost_butal = $request->input('last_final_unit_cost_butal');
                $total_cost_butal = $last_final_unit_cost_butal * $quantity_butal;
                $running_total_cost_butal = $ledger_results_butal[0]->running_total_cost + $total_cost_butal;
                $final_unit_cost_butal = $running_total_cost_butal / $running_balance_butal;

                $ledger_add_butal = new Sku_ledger([
                    'sku_id' => $sku_id_butal,
                    'category_id' => $request->input('category_id'),
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'in_out_adjustments' => 'Butal to Case',
                    'rr_dr' => $bodega_out_id,
                    'sales_order_number' => '',
                    'principal_invoice' => '',
                    'quantity' => $quantity_butal,
                    'running_balance' => $running_balance_butal,
                    'unit_cost' => $last_final_unit_cost_butal,
                    'total_cost' => $total_cost_butal,
                    'adjustments' => 0,
                    'running_total_cost' => $running_total_cost_butal,
                    'final_unit_cost' => $final_unit_cost_butal,
                    'transaction_date' => $date,
                    'user_id' => auth()->user()->id
                ]);

                $ledger_add_butal->save();
            } else {



                $quantity_butal = $request->input('transfered_quantity');
                $running_balance_butal = $quantity_butal;
                $last_final_unit_cost_butal = $request->input('last_final_unit_cost_butal');
                $total_cost_butal = $last_final_unit_cost_butal * $quantity_butal;
                $running_total_cost_butal = $total_cost_butal;
                $final_unit_cost_butal = $running_total_cost_butal / $running_balance_butal;

                $ledger_add_butal = new Sku_ledger([
                    'sku_id' => $sku_id_butal,
                    'category_id' => $request->input('category_id'),
                    'principal_id' => $request->input('principal_id'),
                    'sku_type' => $request->input('sku_type'),
                    'in_out_adjustments' => 'Butal to Case',
                    'rr_dr' => $bodega_out_id,
                    'sales_order_number' => '',
                    'principal_invoice' => '',
                    'quantity' => $quantity_butal,
                    'running_balance' => $running_balance_butal,
                    'unit_cost' => $last_final_unit_cost_butal,
                    'total_cost' => $total_cost_butal,
                    'adjustments' => 0,
                    'running_total_cost' => $running_total_cost_butal,
                    'final_unit_cost' => $final_unit_cost_butal,
                    'transaction_date' => $date,
                    'user_id' => auth()->user()->id
                ]);

                $ledger_add_butal->save();
            }


            $sku_price = new Sku_price_details([
                'sku_id' => $sku_id_butal,
                'price_1' => $request->input('price_1_butal'),
                'price_2' => $request->input('price_2_butal'),
                'price_3' => $request->input('price_3_butal'),
            ]);

            $sku_price->save();





            if ($sku_price) {
                return 'Saved';
            } else {
                return 'Error';
            }
        } else {



            $sku_id_butal = $request->input('sku_id');
            $sku_id_case = $request->input('equivalent_sku_id');

            $bodega_out_save = new Bodega_out([
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'remarks' => 'Butal to Case',
                'date' => $date
            ]);

            $bodega_out_save->save();
            $bodega_out_id = $bodega_out_save->id;

            $bodega_out_details_save = new Bodega_out_details([
                'bodega_out_id' => $bodega_out_id,
                'sku_id' => $sku_id_butal,
                'quantity' => $request->input('quantity'),
                'fuc_prices' => $request->input('fuc_prices'),
                'transfer_to_sku_id' => $sku_id_case,
                'transfer_quantity' => $request->input('convert'),
            ]);

            $bodega_out_details_save->save();

            $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_butal' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));


            //case
            $quantity_butal = ($request->input('convert') * $request->input('quantity')) * -1;
            $running_balance_butal =  $ledger_results[0]->running_balance - $request->input('convert') * $request->input('quantity');
            $last_final_unit_cost_butal = $request->input('last_final_unit_cost_butal');
            $total_cost_butal = $last_final_unit_cost_butal * $quantity_butal;
            $running_total_cost_butal = $ledger_results[0]->running_total_cost + $total_cost_butal;

            if ($running_balance_butal > 0) {
                $final_unit_cost_butal = $running_total_cost_butal / $running_balance_butal;
            } else {
                $final_unit_cost_butal =  $ledger_results[0]->final_unit_cost;
            }


            $ledger_add_butal = new Sku_ledger([
                'sku_id' => $sku_id_butal,
                'category_id' => $request->input('category_id'),
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'in_out_adjustments' => 'Butal to Case',
                'rr_dr' => $bodega_out_id,
                'sales_order_number' => '',
                'principal_invoice' => '',
                'quantity' => $quantity_butal,
                'running_balance' => $running_balance_butal,
                'unit_cost' => $last_final_unit_cost_butal,
                'total_cost' => $total_cost_butal,
                'adjustments' => 0,
                'running_total_cost' => $running_total_cost_butal,
                'final_unit_cost' => $final_unit_cost_butal,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add_butal->save();

            $ledger_results_case = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$sku_id_case' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

            $quantity_case = $request->input('convert');
            $running_balance_case = $quantity_case + $ledger_results_case[0]->running_balance;
            $last_final_unit_cost_case = $request->input('last_final_unit_cost_case');
            $total_cost_case = $last_final_unit_cost_case * $quantity_case;
            $running_total_cost_case = $ledger_results_case[0]->running_total_cost + $total_cost_case;
            $final_unit_cost_case = $running_total_cost_case / $running_balance_case;

            $ledger_add_case = new Sku_ledger([
                'sku_id' => $sku_id_case,
                'category_id' => $request->input('category_id'),
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'rr_dr' => $bodega_out_id,
                'sales_order_number' => '',
                'principal_invoice' => '',
                'quantity' => $quantity_case,
                'running_balance' => $running_balance_case,
                'unit_cost' => $last_final_unit_cost_case,
                'total_cost' => $total_cost_case,
                'adjustments' => 0,
                'running_total_cost' => $running_total_cost_case,
                'final_unit_cost' => $final_unit_cost_case,
                'transaction_date' => $date,
                'user_id' => auth()->user()->id
            ]);

            $ledger_add_case->save();
        }
    }
}
