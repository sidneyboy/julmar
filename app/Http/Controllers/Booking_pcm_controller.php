<?php

namespace App\Http\Controllers;

use App\User;
use App\Agent;
use App\Customer;
use App\Sku_principal;
use App\Sku_add;
use App\Return_good_stock;
use App\Return_good_stock_details;
use App\Bad_order;
use App\Bad_order_details;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Booking_pcm_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            \Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            // $agent = Agent::select('id', 'full_name')->get();
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $customer = Customer::select('id', 'store_name')->where('kind_of_business', '!=', 'VAN SELLING')->get();
            return view('booking_pcm', [
                'user' => $user,
                // 'agent' => $agent,
                'customer' => $customer,
                'principal' => $principal,
                'main_tab' => 'manage_booking_main_tab',
                'sub_tab' => 'manage_booking_sub_tab',
                'active_tab' => 'booking_pcm',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function booking_pcm_proceed(Request $request)
    {
        $sku = Sku_add::select('id', 'description', 'sku_type', 'sku_code')
            ->where('sku_type', $request->input('sku_type'))
            ->where('principal_id', $request->input('principal_id'))
            ->get();

        return view('booking_pcm_proceed', [
            'sku' => $sku
        ])->with('pcm_type', $request->input('pcm_type'))
            ->with('sku_type', $request->input('sku_type'))
            ->with('principal_id', $request->input('principal_id'))
            ->with('agent_id', $request->input('agent_id'))
            ->with('customer_id', $request->input('customer_id'));
    }

    public function booking_pcm_proceed_final_summary(Request $request)
    {
        //return $request->input();
        $sku = Sku_add::select('id', 'description', 'sku_code')->find($request->input('sku_id'));
        $checker = Cart::session(auth()->user()->id)->getContent($sku->id);

        if ($checker) {
            \Cart::session(auth()->user()->id)->remove($sku->id);

            \Cart::session(auth()->user()->id)->add(array(
                'id' => $sku->id,
                'name' => $sku->description,
                'price' => $request->input('unit_price'),
                'quantity' => $request->input('quantity'),
                'attributes' => array(),
                'associatedModel' => $sku,
            ));
        } else {
            \Cart::session(auth()->user()->id)->add(array(
                'id' => $sku->id,
                'name' => $sku->description,
                'price' => $request->input('unit_price'),
                'quantity' => $request->input('quantity'),
                'attributes' => array(),
                'associatedModel' => $sku,
            ));
        }


        $cart =  \Cart::session(auth()->user()->id)->getContent();

        return view('booking_pcm_proceed_final_summary', [
            'cart' => $cart,
            'principal_id' => $request->input('principal_id'),
            'sku_type' => $request->input('sku_type'),
            'agent_id' => $request->input('agent_id'),
            'customer_id' => $request->input('customer_id'),
            'pcm_type' => $request->input('pcm_type'),
        ]);
    }

    public function booking_pcm_save(Request $request)
    {
        //return $request->input();
        $cart =  \Cart::session(auth()->user()->id)->getContent();
        if ($request->input('pcm_type') == 'RGS') {
            $new_rgs = new Return_good_stock([
                'delivery_receipt' => $request->input('delivery_receipt'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'total_amount' => $request->input('total_amount'),
                'pcm_number' => $request->input('pcm_number'),
                'agent_id' => $request->input('agent_id'),
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_rgs->save();

            foreach ($cart as $key => $data) {
                $new_rgs_details = new Return_good_stock_details([
                    'return_good_stock_id' => $new_rgs->id,
                    'sku_id' => $data->id,
                    'quantity' => $data->quantity,
                    'unit_price' => $data->price,
                ]);

                $new_rgs_details->save();
            }
        }else{
            $new_bo = new Bad_order([
                'delivery_receipt' => $request->input('delivery_receipt'),
                'user_id' => auth()->user()->id,
                'principal_id' => $request->input('principal_id'),
                'sku_type' => $request->input('sku_type'),
                'total_amount' => $request->input('total_amount'),
                'pcm_number' => $request->input('pcm_number'),
                'agent_id' => $request->input('agent_id'),
                'customer_id' => $request->input('customer_id'),
            ]);

            $new_bo->save();

            foreach ($cart as $key => $data) {
                $new_bo_details = new Bad_order_details([
                    'bad_order_id' => $new_bo->id,
                    'sku_id' => $data->id,
                    'quantity' => $data->quantity,
                    'unit_price' => $data->price,
                ]);

                $new_bo_details->save();
            }
        }
    }
}
