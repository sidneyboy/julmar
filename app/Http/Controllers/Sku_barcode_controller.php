<?php

namespace App\Http\Controllers;
use App\User;
use App\Sku_add;
use App\Sku_principal;
use Illuminate\Http\Request;

class Sku_barcode_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principals = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            return view('sku_barcode', [
                'user' => $user,
                'principals' => $principals,
                'main_tab' => 'manage_sku_main_tab',
                'sub_tab' => 'manage_sku_sub_tab',
                'active_tab' => 'sku_barcode',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function sku_barcode_show_sku(Request $request)
    {
        $sku = Sku_add::select('sku_code','description')->where('principal_id',$request->input('principal_id'))->where('sku_type','Case')->get();

        return view('sku_barcode_show_sku',[
            'sku' => $sku,
        ]);
    }

    public function sku_barcode_save(Request $request)
    {
        $sku = Sku_add::select('id','sku_type')
                    ->where('sku_code',$request->input('sku_code'))
                    ->where('sku_type',$request->input('sku_type'))
                    ->get();

        foreach ($sku as $key => $data) {
            Sku_add::where('id', $data->id)
                ->update(['barcode' => $request->input('barcode')]);
        }

        return redirect('sku_barcode')->with('success','Successfully Update SKU Barcode');
    }
}
