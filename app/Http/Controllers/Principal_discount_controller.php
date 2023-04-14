<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Principal_discount;
use App\Principal_discount_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Principal_discount_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('principal_discount', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'principal_discount',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function principal_discount_show_input(Request $request)
    {
        return view('principal_discount_show_input')
            ->with('number_of_discounts', $request->input('number_of_discounts'))
            ->with('principal_id', $request->input('principal_id'));
    }

    public function principal_discount_save(Request $request)
    {
        //return $request->input();
        $sum_array = [];
        $total_bo_allowance_discount = str_replace(',', '', $request->input('bo_allowance_discount'));


        $principal_discount_save = new Principal_discount([
            'user_id'    => auth()->user()->id,
            'principal_id' => $request->get('principal_id'),
            'cash_with_order_discount' => str_replace(',','',$request->input('cash_with_order_discount')),
        ]);
        $principal_discount_save->save();
        $principal_discount_save_last_id = $principal_discount_save->id;

        for ($i = 0; $i < $request->input('number_of_discounts'); $i++) {
            $discount_rate = str_replace(',', '', $request->input('discount_rate')[$i]);
            $sum_array[] = $discount_rate;
            $principal_discount_details_save = new Principal_discount_details([
                'principal_discount_id'    => $principal_discount_save_last_id,
                'discount_name' => $request->get('discount_name')[$i],
                'discount_rate' => $discount_rate,
            ]);
            $principal_discount_details_save->save();
        }

        $principal_discount_update = Principal_discount::find($principal_discount_save_last_id);
        $principal_discount_update->total_discount = array_sum($sum_array);
        $principal_discount_update->total_bo_allowance_discount = $total_bo_allowance_discount;
        $principal_discount_update->save();

        $principal_discount_details_bo_save = new Principal_discount_details([
            'principal_discount_id'    => $principal_discount_save_last_id,
            'discount_name' => 'BO',
            'discount_rate' => $total_bo_allowance_discount,
        ]);
        $principal_discount_details_bo_save->save();

        $principal_discount_details_cwo_save = new Principal_discount_details([
            'principal_discount_id'    => $principal_discount_save_last_id,
            'discount_name' => 'CWO',
            'discount_rate' => str_replace(',','',$request->input('cash_with_order_discount')),
        ]);
        $principal_discount_details_cwo_save->save();


        return 'saved';
    }
}
