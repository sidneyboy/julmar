<?php

namespace App\Http\Controllers;

use App\Received_purchase_order;
use App\Received_purchase_order_details;
use App\Personnel_description;
use App\Personnel_add;
use App\Sku_ledger;
use DB;
use App\Return_to_principal;
use App\Return_to_principal_details;
use App\Return_to_principal_jer;
use App\User;
use App\Principal_discount;
use App\Principal_ledger;
use Illuminate\Http\Request;

class Return_to_principal_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $received_id = Received_purchase_order::select('id', 'principal_id', 'purchase_order_id', 'dr_si')->orderBy('id', 'desc')->get();
            return view('return_to_principal', [
                'user' => $user,
                'received_id' => $received_id,
                'main_tab' => 'manage_adjustments_main_tab',
                'sub_tab' => 'manage_adjustments_sub_tab',
                'active_tab' => 'return_to_principal',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function return_show_inputs(Request $request)
    {
        $variable_explode = explode('=', $request->input('received_id'));
        $received_id = $variable_explode[0];
        $principal_id = $variable_explode[1];

        $received = Received_purchase_order_details::where('received_id', $received_id)->get();
        return view('return_to_principal_show_inputs', [
            'received' => $received,
        ])->with('principal_id', $principal_id)
            ->with('received_id', $received_id);
    }

    public function return_to_principal_summary(Request $request)
    {
        // return $request->input();

        if (is_null($request->input('personnel'))) {
            return 'no personnel';
        } elseif (is_null($request->input('remarks'))) {
            return 'no remarks';
        } else {
            foreach ($request->input('checkbox_entry') as $key => $data) {
                if ($request->input('quantity')[$data] == 0 or '') {
                    return 'no_quantity';
                    break;
                }
            }

            $received_purchase_order = Received_purchase_order::find($request->input('received_id'));


            return view('return_to_principal_summary', [
                'received_purchase_order' => $received_purchase_order,
            ])->with('quantity', $request->input('quantity'))
                ->with('unit_cost', $request->input('unit_cost'))
                ->with('code', $request->input('code'))
                ->with('description', $request->input('description'))
                ->with('checkbox_entry', $request->input('checkbox_entry'))
                ->with('principal_id', $request->input('principal_id'))
                ->with('received_id', $request->input('received_id'))
                ->with('sku_type', $request->input('sku_type'))
                ->with('discount_id', $request->input('discount_id'))
                ->with('personnel', $request->input('personnel'))
                ->with('discount_type', $request->input('discount_type'));
        }
    }

    public function return_to_principal_save(Request $request)
    {
        //return $request->input();

        $return_to_principal_save = new Return_to_principal([
            'principal_id' => $request->input('return_principal_id'),
            'received_id' => $request->input('received_id'),
            'personnel' => $request->input('personnel'),
            'discount_id' => $request->input('discount_id'),
            'user_id' => auth()->user()->id,
            'remarks' => $request->input('remarks'),
            'total_amount_return' => $request->input('total_amount_return'),
            'return_vatable_purchase' => $request->input('return_vatable_purchase'),
            'return_less_discount' => $request->input('return_less_discount'),
            'return_net_discount' => $request->input('return_net_discount'),
            'return_vat_amount' => $request->input('return_vat_amount'),
            'return_net_of_deduction' => $request->input('return_net_of_deduction'),
            'date' => $date,
        ]);

        $return_to_principal_save->save();
    }
}
