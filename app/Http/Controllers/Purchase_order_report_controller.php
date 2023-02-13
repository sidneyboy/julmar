<?php

namespace App\Http\Controllers;
use Exception;
use App\Sku_add;
use App\Sku_principal;
use Session;
use Response;
use App\Purchase_order;
use App\Purchase_order_details;
use App\User;
use Illuminate\Http\Request;

class Purchase_order_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            return view('purchase_order_report', [
                'user' => $user,
                'main_tab' => 'receiving_and_purchases_main_tab',
                'sub_tab' => 'receiving_and_purchases_sub_tab',
                'active_tab' => 'purchase_order_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function purchase_order_report_show_list(Request $request)
    {
        $var = explode('-', $request->input('date'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));


        $purchase_order_data = Purchase_order::whereBetween('date', [$date_from, $date_to])->get();
        $counter = count($purchase_order_data);
        return view('purchase_order_report_show_list', [
            'purchase_order_data' => $purchase_order_data,
            'counter' => $counter
        ]);
    }
    public function purchase_order_report_show_details(Request $request, $id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('m-d-Y');

        $explode_data = explode('=', $id);
        $purchase_order_id = $explode_data[0];
        $principal_name = $explode_data[1];
        $principal_contact_number = $explode_data[2];
        $purchase_order_payment_term = $explode_data[3];
        $purchase_order_delivery_term = $explode_data[4];
        $purchase_id = $explode_data[5];
        $user_name = $explode_data[6];
        $sales_order_number = $explode_data[7];


        $prepared_by = User::select('name')->where('id', auth()->user()->id)->first();
        $purchase_order_details_data = Purchase_order_details::where('purchase_order_id', $purchase_order_id)->get();
        foreach ($purchase_order_details_data as $key => $value) {
            $quantity_array[] = $value->quantity;
        }
        return view('purchase_order_report_show_details', [
            'purchase_order_details_data' => $purchase_order_details_data
        ])->with('date', $date)
            ->with('principal_name', $principal_name)
            ->with('principal_contact_number', $principal_contact_number)
            ->with('delivery_term', $purchase_order_delivery_term)
            ->with('payment_term', $purchase_order_payment_term)
            ->with('purchase_order_id', $purchase_order_id)
            ->with('purchase_id', $purchase_id)
            ->with('quantity_array', array_sum($quantity_array))
            ->with('user_name', $user_name)
            ->with('prepared_by', $prepared_by->name)
            ->with('sales_order_number', $sales_order_number);
    }

    public function upload_confirmation_image(Request $request)
    {
        if ($request->input('remarks') == 'Incomplete') {

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $image_name);
            $upload_image = Purchase_order::find($request->input('purchase_id'));
            $upload_image->po_confirmation_image = $image_name;
            $upload_image->remarks = 'Incomplete';
            $upload_image->save();

            if ($upload_image) {
                Session::flash('success');
                return redirect('purchase_order_report');
            } else {
                Session::flash('error');
                return redirect('purchase_order_report');
            }
        } else {

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $image_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $image_name);
            $upload_image = Purchase_order::find($request->input('purchase_id'));
            $upload_image->po_confirmation_image = $image_name;
            $upload_image->save();

            if ($upload_image) {
                Session::flash('success');
                return redirect('purchase_order_report');
            } else {
                Session::flash('error');
                return redirect('purchase_order_report');
            }
        }
    }
}
