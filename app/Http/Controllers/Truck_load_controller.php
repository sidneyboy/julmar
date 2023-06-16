<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Agent;
use App\Sales_invoice;
use App\Sales_invoice_details;
use App\Truck;
use DB;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_load_controller extends Controller
{
    public function index()
    {
        Cart::session(auth()->user()->id)->clear();
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            return view('truck_load', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_load',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_load_proceed(Request $request)
    {
        $agent = Agent::where('location_id', $request->input('location_id'))
            ->get();

        return view('truck_load_proceed', [
            'agent' => $agent,
        ])->with('location_id', $request->input('location_id'));
    }

    public function truck_load_generated_invoices(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'delivery_receipt', 'agent_id')
            ->whereIn('agent_id', $request->input('agent_id'))
            ->get();

        $truck = Truck::select('id', 'plate_no')
            ->where('status', '!=', 'on going delivery')
            ->get();

        return view('truck_load_generated_invoices', [
            'sales_invoice' => $sales_invoice,
            'truck' => $truck,
        ])->with('location_id', $request->input('location_id'));
    }

    public function truck_load_generated_invoices_data(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'customer_id', 'principal_id', 'agent_id', 'sku_type')->find($request->input('sales_invoice_id'));

        return view('truck_load_generated_invoices_data', [
            'sales_invoice' => $sales_invoice,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')));


        // $outlet = Sales_invoice::select('principal_id')
        //     ->whereIn('id', $request->input('sales_invoice_id'))
        //     ->groupBy('principal_id')
        //     ->get();

        // foreach ($outlet as $key => $outlet_data) {
        //     $outlet_details_case[$outlet_data->principal_id] = Sales_invoice_details::select('sku_type', DB::raw('sum(quantity) as total'), DB::raw('sum(total_amount_per_sku) as total_amount'))
        //         ->where('principal_id', $outlet_data->principal_id)
        //         ->where('sku_type', 'CASE')
        //         ->get();

        //     $outlet_details_butal[$outlet_data->principal_id] = Sales_invoice_details::select('sku_type', DB::raw('sum(quantity) as total'), DB::raw('sum(total_amount_per_sku) as total_amount'))
        //         ->where('principal_id', $outlet_data->principal_id)
        //         ->where('sku_type', 'BUTAL')
        //         ->get();
        // }

        // $explode = explode('-', $request->input('truck_id'));
        // $truck_id = $explode[0];
        // $plate_no = $explode[1];

        // return view('truck_load_generated_invoices_data', [
        //     'outlet' => $outlet,
        //     'outlet_details_case' => $outlet_details_case,
        //     'outlet_details_butal' => $outlet_details_butal,
        //     'truck_id' => $truck_id,
        //     'plate_no' => $plate_no,
        // ])->with('location_id', $request->input('location_id'))
        // ->with('detailed_location', strtoupper(str_replace(',','',$request->input('detailed_location'))))
        // ->with('sales_invoice_id', $request->input('sales_invoice_id'))
        // ->with('truck_id', $request->input('truck_id'))
        // ->with('driver', strtoupper($request->input('driver')))
        // ->with('contact_number', strtoupper($request->input('contact_number')))
        // ->with('helper_1', strtoupper($request->input('helper_1')))
        // ->with('helper_2', strtoupper($request->input('helper_2')));
    }

    public function truck_load_generated_final_summary_invoices_data(Request $request)
    {
        //return $request->input();
        $sales_invoice = Sales_invoice::select('id', 'customer_id', 'principal_id', 'agent_id', 'sku_type', 'delivery_receipt')->find($request->input('sales_invoice_id'));

        // return $sales_invoice->id;
        Cart::session(auth()->user()->id)->add(array(
            'id' => $sales_invoice->id,
            'name' => 'qweqweqweqwe',
            'price' => 0,
            'quantity' => $request->input('total_quantity'),
            'associatedModel' => $sales_invoice,
        ));


        $cart = Cart::session(auth()->user()->id)->getContent();

        return view('truck_load_generated_final_summary_invoices_data', [
            'cart' => $cart,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')));
    }

    public function truck_load_generated_final_summary_invoices_remove_data(Request $request)
    {
        //return $request->input();
        \Cart::session(auth()->user()->id)->remove($request->input('sales_invoice_id'));

        $cart = Cart::session(auth()->user()->id)->getContent();

        return view('truck_load_generated_final_summary_invoices_data', [
            'cart' => $cart,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')));
    }

    public function truck_load_generated_very_final_summary_invoices_data(Request $request)
    {
        //return $request->input();

        $outlet = Sales_invoice::select('principal_id')
            ->whereIn('id', $request->input('final_sales_invoice_id'))
            ->groupBy('principal_id')
            ->get();

        $number_of_customers = Sales_invoice::select('customer_id')
            ->whereIn('id', $request->input('final_sales_invoice_id'))
            ->groupBy('customer_id')
            ->get();

        foreach ($outlet as $key => $outlet_data) {
            $outlet_details_case[$outlet_data->principal_id] = Sales_invoice_details::select('sku_id', 'sku_type', DB::raw('sum(quantity) as total'), DB::raw('sum(total_amount_per_sku) as total_amount'))
                ->where('principal_id', $outlet_data->principal_id)
                ->where('sku_type', 'CASE')
                ->get();

            $total_sum_case_for_percentage[] =  $outlet_details_case[$outlet_data->principal_id][0]->total;

            $outlet_details_butal[$outlet_data->principal_id] = Sales_invoice_details::select('sku_type', DB::raw('sum(quantity) as total'), DB::raw('sum(total_amount_per_sku) as total_amount'))
                ->where('principal_id', $outlet_data->principal_id)
                ->where('sku_type', 'BUTAL')
                ->get();

            $outlet_details_sku_butal = sales_invoice_details::select('sku_id', 'quantity')
                ->where('principal_id', $outlet_data->principal_id)
                ->where('sku_type', 'BUTAL')
                ->get();

            foreach ($outlet_details_sku_butal as $key => $details_sku_butal) {
                $outlet_details_sku_butal_data[$outlet_data->principal_id][] = $details_sku_butal->quantity / $details_sku_butal->sku->equivalent_butal_pcs;
            }

            $total_sum_conversion[] = array_sum($outlet_details_sku_butal_data[$outlet_data->principal_id]);
        }

        $explode = explode('-', $request->input('truck_id'));
        $truck_id = $explode[0];
        $plate_no = $explode[1];

        return view('truck_load_generated_very_final_summary_invoices_data', [
            'outlet' => $outlet,
            'outlet_details_case' => $outlet_details_case,
            'outlet_details_butal' => $outlet_details_butal,
            'number_of_customers' => $number_of_customers,
            'total_sum_case_for_percentage' => $total_sum_case_for_percentage,
            'total_sum_conversion' => $total_sum_conversion,
            'truck_id' => $truck_id,
            'plate_no' => $plate_no,
            'outlet_details_sku_butal_data' => $outlet_details_sku_butal_data,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('final_sales_invoice_id', $request->input('final_sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')))
            ->with('total_expense_per_delivery',$request->input('total_expense_per_delivery'));
    }
}
