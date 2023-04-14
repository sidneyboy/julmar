<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_add;
use App\Sku_principal;
use App\Sku_ledger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Sku_extract_inventory_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::where('principal', '!=', 'none')->get();
            return view('sku_extract_inventory', [
                'user' => $user,
                'principal' => $principal,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_extract_inventory',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function extract_sku_inventory_generate_data(Request $request)
    {
        // return $request->input();
        $sku = Sku_add::where('principal_id',$request->input('principal'))->get();
        return view('extract_sku_inventory_generate_data', [
            'sku' => $sku,
        ])->with('extract_for', $request->input('extract_for'));
    }

    public function extract_sku_inventory_generate_export_data(Request $request)
    {
        return $request->input();
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $time = date('His');
        $sku = Sku_add::findMany($request->input('sku'));
        return view('extract_sku_inventory_generate_export_data', [
            'sku' => $sku
        ])->with('date', $date)
            ->with('time', $time);
    }
}
