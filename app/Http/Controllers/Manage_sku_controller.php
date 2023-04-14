<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Sku_category;
use App\Sku_sub_category;
use App\Sku_add;
use App\Sku_price_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Manage_sku_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $categories = Sku_category::select('id', 'category')->get();
            $sub_category = Sku_sub_category::select('id', 'sub_category')->get();
            return view('sku_add', [
                'user' => $user,
                'principals' => $principals,
                'categories' => $categories,
                'sub_category' => $sub_category,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_add',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sku_show_main_category(Request $request)
    {
        $principal_select_main_category = Sku_principal::find($request->input('principal_id'));

        return view('sku_show_main_category', [
            'principal_select_main_category' => $principal_select_main_category,
        ]);
    }

    public function sku_show_details(Request $request)
    {
        $principal = Sku_principal::select('id', 'principal')->find($request->input('principal_id'));
        $main_category = Sku_category::select('id', 'category')->find($request->input('main_category_id'));
        $sub_category = Sku_sub_category::select('id', 'sub_category')->where('main_category_id', $request->input('main_category_id'))->get();
        return view('sku_show_details', [
            'principal' => $principal,
            'sub_category' => $sub_category,
            'main_category' => $main_category,
        ])->with('barcode', $request->input('barcode'))
            ->with('description', $request->input('description'))
            ->with('main_category_id', $request->input('main_category_id'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('sku_code', $request->input('sku_code'))
            ->with('sku_type', $request->input('sku_type'));
    }

    public function sku_add_process(Request $request)
    {
        //return $request->input();
        if ($request->input('sku_type') == 'Case') {
           // return 'asdasd';
            $new_1 = new sku_add([
                'sku_code' => $request->input('sku_code_case'),
                'description' => $request->input('description_case'),
                'category_id' => $request->input('main_category_id'),
                'principal_id' => $request->input('principal_id'),
                'sub_category_id' => $request->input('sub_category_id_case'),
                'unit_of_measurement' => $request->input('uom_case'),
                'sku_type' => 'CASE',
                // 'equivalent_sku_entryNo' => ,
                'equivalent_butal_pcs' => 1,
                'barcode' => $request->input('barcode_case'),
                // 'weight' => $request->input('weight_case'),
            ]);

            $new_1->save();

            $sku_price_details_1 = new Sku_price_details([
                'sku_id' => $new_1->id,
                'unit_cost' => 0,
                'price_1' => 0,
                'price_2' => 0,
                'price_3' => 0,
                'price_4' => 0,
                'price_5' => 0,
            ]);
            $sku_price_details_1->save();


            $new_2 = new sku_add([
                'sku_code' => $request->input('sku_code_butal'),
                'description' => $request->input('description_butal'),
                'category_id' => $request->input('main_category_id'),
                'principal_id' => $request->input('principal_id'),
                'sub_category_id' => $request->input('sub_category_id_butal'),
                'unit_of_measurement' => $request->input('uom_butal'),
                'sku_type' => 'BUTAL',
                'equivalent_sku_entryNo' => $new_1->id,
                'equivalent_butal_pcs' => $request->input('butal_equivalent'),
                'barcode' => $request->input('barcode_butal'),
            ]);

            $new_2->save();

            $sku_price_details_2 = new Sku_price_details([
                'sku_id' => $new_2->id,
                'unit_cost' => 0,
                'price_1' => 0,
                'price_2' => 0,
                'price_3' => 0,
                'price_4' => 0,
                'price_5' => 0,
            ]);
            $sku_price_details_2->save();


            Sku_add::where('id', $new_1->id)
                ->update(['equivalent_sku_entryNo' => $new_2->id]);
        } else {
            $new_2 = new sku_add([
                'sku_code' => $request->input('sku_code_butal'),
                'description' => $request->input('description_butal'),
                'category_id' => $request->input('main_category_id'),
                'principal_id' => $request->input('principal_id'),
                'sub_category_id' => $request->input('sub_category_id_butal'),
                'unit_of_measurement' => $request->input('uom_butal'),
                'sku_type' => 'Butal',
                // 'equivalent_sku_entryNo' => $new_1->id,
                // 'equivalent_butal_pcs' => $request->input('butal_equivalent'),
                'barcode' => $request->input('barcode_butal'),
                // 'weight' => $request->input('weight_butal'),
            ]);

            $new_2->save();

            $sku_price_details_2 = new Sku_price_details([
                'sku_id' => $new_2->id,
                'unit_cost' => 0,
                'price_1' => 0,
                'price_2' => 0,
                'price_3' => 0,
                'price_4' => 0,
                'price_5' => 0,
            ]);
            $sku_price_details_2->save();
        }

    }
}
