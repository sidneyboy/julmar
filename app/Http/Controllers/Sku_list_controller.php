<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Sku_category;
use App\Sku_add;
use App\Sku_price_details;

use DB;
use Illuminate\Http\Request;

class Sku_list_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('sku_list', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_list',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sku_list_show_data(Request $request)
    {
        //return $request->input();

        $sku = Sku_add::where('sku_code',$request->input('search'))
                        ->orWhere('description', 'LIKE', '%'.$request->input('search').'%')
                        ->orWhere('sku_type',$request->input('search'))
                        ->get();

        return view('sku_list_show_data',[
            'sku' => $sku,
        ]);
    }

    public function sku_update_data(Request $request)
    {

        if ($request->input('principal_name') == 'EPI') {
            $sku_update = Sku_add::find($request->input('sku_id'));
            $sku_update->sku_code = $request->input('sku_code');
            $sku_update->description = $request->input('description');
            $sku_update->category_id = $request->input('category_id');
            $sku_update->principal_id = $request->input('principal_id');
            $sku_update->unit_of_measurement = $request->input('unit_of_measurement');
            $sku_update->sku_type = $request->input('sku_type');
            $sku_update->save();


            return redirect('sku_list')->with('success','Successfully Updated Sku Details');
        } else {
            $sku_update = Sku_add::find($request->input('sku_id'));
            $sku_update->sku_code = $request->input('sku_code');
            $sku_update->description = $request->input('description');
            $sku_update->category_id = $request->input('category_id');
            $sku_update->principal_id = $request->input('principal_id');
            $sku_update->unit_of_measurement = $request->input('unit_of_measurement');
            $sku_update->sku_type = $request->input('sku_type');
            $sku_update->equivalent_sku_entryNo = $request->input('equivalent_sku_entryNo');
            $sku_update->save();


            return redirect('sku_list')->with('success','Successfully Updated Sku Details');
        }
    }


    public function sku_list_update_price(Request $request)
    {

        foreach ($request->input('checkboxEntry') as $key => $data) {
            $sku_price[] = Sku_price_details::select('sku_id', 'price_1', 'price_2', 'price_3')
                ->where('sku_id', $data)
                ->get();
        }

        return view('sku_list_update_price', [
            'sku_price' => $sku_price
        ]);
    }

    public function sku_list_update_price_save(Request $request)
    {
        $price_1 = $request->input('price_1');
        $price_2 = $request->input('price_2');
        $price_3 = $request->input('price_3');
        foreach ($request->input('checkboxEntry') as $key => $data) {
            $sku_price = Sku_price_details::find($data);
            $sku_price->price_1 = $price_1[$data];
            $sku_price->price_2 = $price_2[$data];
            $sku_price->price_3 = $price_3[$data];
            $sku_price->save();
        }
    }

    public function fetch_data(Request $request)
    {

        if ($request->ajax()) {

            if ($request->input('search_method') == 'principal') {
                $search_principal_id = Sku_principal::select('id', 'principal')->where('principal', $request->input('principal_name'))->first();
                $select_sku_category = Sku_category::select('id', 'category')->get();
                $select_sku_principal = Sku_principal::select('id', 'principal')->get();
                $select_sku_equivalent = Sku_add::select('id', 'sku_code', 'description', 'sku_type')
                    ->where('principal_id', $search_principal_id->id)
                    ->get();

                $sku_data = Sku_add::where('principal_id', $request->input('second_parameter'))->paginate(15);
                $data_counter = count($sku_data);
                foreach ($sku_data as $key => $value) {
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$value->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    if ($ledger_results != NULL) {
                        $remaining_quantity[] = $ledger_results[0]->running_balance;
                    } else {
                        $remaining_quantity[] = 0;
                    }
                }

                return view('sku_list_show_data', [
                    'sku_data' => $sku_data,
                    'remaining_quantity' => $remaining_quantity
                ])->with('second_parameter',  $request->input('second_parameter'))
                    ->with('data_counter', $data_counter)
                    ->with('search_method', $request->input('search_method'))
                    ->with('search_principal_id', $search_principal_id)
                    ->with('select_sku_category', $select_sku_category)
                    ->with('select_sku_principal', $select_sku_principal)
                    ->with('principal_name', $request->input('principal_name'))
                    ->with('select_sku_equivalent', $select_sku_equivalent)
                    ->render();
            } else if ($request->input('search_method') == 'category') {
                $sku_data = Sku_add::where('category_id', $request->input('second_parameter'))->paginate(15);
                $data_counter = count($sku_data);
                foreach ($sku_data as $key => $value) {
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$value->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    if ($ledger_results != NULL) {
                        $remaining_quantity[] = $ledger_results[0]->running_balance;
                    } else {
                        $remaining_quantity[] = 0;
                    }
                }

                return view('sku_list_show_data', [
                    'sku_data' => $sku_data,
                    'remaining_quantity' => $remaining_quantity
                ])->with('second_parameter',  $request->input('second_parameter'))
                    ->with('search_method', $request->input('search_method'))
                    ->with('data_counter', $data_counter)
                    ->render();
            } else if ($request->input('search_method') == 'uom') {
                $sku_data = Sku_add::where('unit_of_measurement', $request->input('second_parameter'))->paginate(15);
                $data_counter = count($sku_data);
                foreach ($sku_data as $key => $value) {
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$value->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    if ($ledger_results != NULL) {
                        $remaining_quantity[] = $ledger_results[0]->running_balance;
                    } else {
                        $remaining_quantity[] = 0;
                    }
                }

                return view('sku_list_show_data', [
                    'sku_data' => $sku_data,
                    'remaining_quantity' => $remaining_quantity
                ])->with('second_parameter',  $request->input('second_parameter'))
                    ->with('data_counter', $data_counter)
                    ->with('search_method', $request->input('search_method'))
                    ->render();
            } else if ($request->input('search_method') == 'sku_type') {
                $sku_data = Sku_add::where('sku_type', $request->input('second_parameter'))->paginate(15);
                $data_counter = count($sku_data);
                foreach ($sku_data as $key => $value) {
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$value->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    if ($ledger_results != NULL) {
                        $remaining_quantity[] = $ledger_results[0]->running_balance;
                    } else {
                        $remaining_quantity[] = 0;
                    }
                }

                return view('sku_list_show_data', [
                    'sku_data' => $sku_data,
                    'remaining_quantity' => $remaining_quantity
                ])->with('second_parameter',  $request->input('second_parameter'))
                    ->with('search_method', $request->input('search_method'))
                    ->with('data_counter', $data_counter)
                    ->render();
            } else if ($request->input('search_method') == 'remarks') {
                $sku_data = Sku_add::where('remarks', $request->input('second_parameter'))->paginate(15);
                $data_counter = count($sku_data);
                foreach ($sku_data as $key => $value) {
                    $ledger_results = DB::select(DB::raw("SELECT * FROM (SELECT * FROM Sku_ledgers WHERE sku_id = '$value->id' ORDER BY id DESC LIMIT 1)Var1 ORDER BY id ASC"));

                    if ($ledger_results != NULL) {
                        $remaining_quantity[] = $ledger_results[0]->running_balance;
                    } else {
                        $remaining_quantity[] = 0;
                    }
                }

                return view('sku_list_show_data', [
                    'sku_data' => $sku_data,
                    'remaining_quantity' => $remaining_quantity
                ])->with('second_parameter',  $request->input('second_parameter'))
                    ->with('data_counter', $data_counter)
                    ->with('search_method', $request->input('search_method'))
                    ->render();
            }
        }
    }
}
