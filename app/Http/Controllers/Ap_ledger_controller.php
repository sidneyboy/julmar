<?php

namespace App\Http\Controllers;
use App\User;
use App\Sku_principal;
use Illuminate\Http\Request;

class Ap_ledger_controller extends Controller
{
    public function index()
    {
        return 'wala';
        // if (Auth::check()) {
        //     $user = User::select('name', 'position')->find(Auth()->user()->id);
        //     $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
        //     $categories = Sku_category::select('id', 'category')->get();
        //     $sub_category = Sku_sub_category::select('id', 'sub_category')->get();
        //     return view('sku_add', [
        //         'user' => $user,
        //         'principals' => $principals,
        //         'categories' => $categories,
        //         'sub_category' => $sub_category,
        //         'main_tab' => 'manage_sku_main_tab',
        //         'sub_tab' => 'manage_sku_sub_tab',
        //         'active_tab' => 'sku_add',
        //     ]);
        // } else {
        //     return redirect('/')->with('error', 'Session Expired. Please Login');
        // }
    }
}
