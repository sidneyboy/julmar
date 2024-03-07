<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Agent;
use App\Driver_helper;
use App\Sales_invoice;
use App\Sales_invoice_details;
use App\Truck;
use App\Logistics;
use App\Logistics_details;
use App\Logistics_invoices;
use App\Sales_invoice_status_logs;
use Carbon\Carbon;
use DB;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class Truck_load_controller extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            Cart::session(auth()->user()->id)->clear();
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')
                ->groupBy('location')
                ->get();
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
            ->where('control', 'printed')
            ->where('truck_load_status', null)
            ->get();

        $truck = Truck::select('id', 'plate_no')
            ->where('status', '!=', 'on going delivery')
            ->get();

        $location = Location::select('detailed_location')
            ->where('id', $request->input('location_id'))
            ->get();

        $driver = Driver_helper::select('id', 'full_name')
            ->get();

        return view('truck_load_generated_invoices', [
            'sales_invoice' => $sales_invoice,
            'truck' => $truck,
            'driver' => $driver,
            'location' => $location,
        ])->with('location_id', $request->input('location_id'));
    }

    public function truck_load_generated_invoices_data(Request $request)
    {
        $sales_invoice = Sales_invoice::select('id', 'customer_id', 'principal_id', 'agent_id', 'sku_type', 'delivery_receipt')->find($request->input('sales_invoice_id'));

        $explode = explode('|', $request->input('driver'));
        $driver_id = $explode[0];
        $driver = $explode[1];

        return view('truck_load_generated_invoices_data', [
            'sales_invoice' => $sales_invoice,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('driver_id', $driver_id)
            ->with('trucking_company', strtoupper($request->input('trucking_company')))
            ->with('driver', strtoupper($driver))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')));
    }

    public function truck_load_generated_final_summary_invoices_data(Request $request)
    {
        //return $request->input();
        $sales_invoice = Sales_invoice::select('id', 'customer_id', 'principal_id', 'agent_id', 'sku_type', 'delivery_receipt')->find($request->input('sales_invoice_id'));

        $cart_checker = \Cart::session(auth()->user()->id)->get($sales_invoice->id);
        if (!$cart_checker) {
            Cart::session(auth()->user()->id)->add(array(
                'id' => $sales_invoice->id,
                'name' => 'qweqweqweqwe',
                'price' => 0,
                'quantity' => $request->input('total_quantity'),
                'attributes' => array([
                    'kilograms' => $request->input('total_kg'),
                ]),
                'associatedModel' => $sales_invoice,
            ));
        }


        $cart = Cart::session(auth()->user()->id)->getContent();

        return view('truck_load_generated_final_summary_invoices_data', [
            'cart' => $cart,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('sales_invoice_id', $request->input('sales_invoice_id'))
            ->with('truck_id', $request->input('truck_id'))
            ->with('trucking_company', strtoupper($request->input('trucking_company')))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('driver_id', $request->input('driver_id'))
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
            // ->with('driver_id', $request->input('driver_id'))
            ->with('trucking_company', strtoupper($request->input('trucking_company')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')));
    }

    public function truck_load_generated_very_final_summary_invoices_data(Request $request)
    {
        //return $request->input();
        $outlet = Sales_invoice::select('principal_id', 'id', 'sku_type')
            ->whereIn('id', $request->input('final_sales_invoice_id'))
            ->groupBy('principal_id')
            ->get();

        $outlets = Sales_invoice::select('principal_id', 'id', 'sku_type')
            ->whereIn('id', $request->input('final_sales_invoice_id'))
            // ->groupBy('principal_id')
            ->get();

        foreach ($outlets as $key => $data_case) {
            $outlet_details_case = Sales_invoice_details::select('sku_type', DB::raw('sum(kilograms) as total_kg'), DB::raw('sum(quantity) as total_quantity_case'), DB::raw('sum(total_amount_per_sku) as total_amount_case'))
                ->where('principal_id', $data_case->principal_id)
                ->where('sales_invoice_id', $data_case->id)
                ->where('sku_type', 'CASE')
                ->first();

            if ($outlet_details_case->total_quantity_case != 0) {
                $total_quantity_per_case[$data_case->principal_id][] = $outlet_details_case->total_quantity_case;
                $total_amount_per_case[$data_case->principal_id][] = $outlet_details_case->total_amount_case;
                $total_kilogram_per_case[$data_case->principal_id][] = $outlet_details_case->total_kg;
                $sum_total_quantity_per_case[] = $outlet_details_case->total_quantity_case;
            } else {
                $total_quantity_per_case[$data_case->principal_id][] = 0;
                $total_amount_per_case[$data_case->principal_id][] = 0;
                $total_kilogram_per_case[$data_case->principal_id][] = 0;
                $sum_total_quantity_per_case[] = 0;
            }
        }


        foreach ($outlets as $key_2 => $data_butal) {
            $outlet_details_butal = Sales_invoice_details::select('sku_type', DB::raw('sum(kilograms) as total_kg'), DB::raw('sum(quantity) as total_quantity_butal'), DB::raw('sum(total_amount_per_sku) as total_amount_butal'))
                ->where('principal_id', $data_butal->principal_id)
                ->where('sales_invoice_id', $data_butal->id)
                ->where('sku_type', 'BUTAL')
                ->first();

            if ($outlet_details_butal->total_quantity_butal != 0) {
                $total_quantity_per_butal[$data_butal->principal_id][] = $outlet_details_butal->total_quantity_butal;
                $total_amount_per_butal[$data_butal->principal_id][] = $outlet_details_butal->total_amount_butal;
                $total_kilogram_per_butal[$data_butal->principal_id][] = $outlet_details_butal->total_kg;
            } else {
                $total_quantity_per_butal[$data_butal->principal_id][] = 0;
                $total_amount_per_butal[$data_butal->principal_id][] = 0;
                $total_kilogram_per_butal[$data_butal->principal_id][] = 0;
            }

            $outlet_details_sku_butal = sales_invoice_details::select('sku_id', 'quantity')
                ->where('sales_invoice_id', $data_butal->id)
                ->where('principal_id', $data_butal->principal_id)
                ->where('sku_type', 'BUTAL')
                ->get();

            if (count($outlet_details_sku_butal) != 0) {
                foreach ($outlet_details_sku_butal as $key_3 => $details_sku_butal) {
                    if ($details_sku_butal->quantity != 0) {
                        $conversion_butal[$data_butal->principal_id][] = $details_sku_butal->quantity / $details_sku_butal->sku->equivalent_butal_pcs;
                        $sum_total_conversion[] = $details_sku_butal->quantity / $details_sku_butal->sku->equivalent_butal_pcs;
                    } else {
                        $conversion_butal[$data_butal->principal_id][] = 0;
                        $sum_total_conversion[] = 0;
                    }
                }
            } else {
                $conversion_butal[$data_butal->principal_id][] = 0;
                $sum_total_conversion[] = 0;
            }
        }



        $cart = Cart::session(auth()->user()->id)->getContent();


        $number_of_customers = Sales_invoice::select('customer_id')
            ->whereIn('id', $request->input('final_sales_invoice_id'))
            ->groupBy('customer_id')
            ->get();

        $explode = explode('-', $request->input('truck_id'));
        $truck_primary_id = $explode[0];
        $plate_no = $explode[1];

        $driver_data = Driver_helper::select('contact_number')->find($request->input('driver_id'));

        return view('truck_load_generated_very_final_summary_invoices_data', [
            'outlet' => $outlet,
            'cart' => $cart,
            'number_of_customers' => $number_of_customers,
            'driver_data' => $driver_data,
            'sum_total_conversion' => $sum_total_conversion,
            'sum_total_quantity_per_case' => $sum_total_quantity_per_case,
            'conversion_butal' => $conversion_butal,
            'total_kilogram_per_butal' => $total_kilogram_per_butal,
            'total_kilogram_per_case' => $total_kilogram_per_case,
            'outlet_details_case' => $outlet_details_case,
            'total_quantity_per_butal' => $total_quantity_per_butal,
            'total_amount_per_butal' => $total_amount_per_butal,
            'total_quantity_per_case' => $total_quantity_per_case,
            'total_amount_per_case' => $total_amount_per_case,
            'truck_primary_id' => $truck_primary_id,
            'plate_no' => $plate_no,
        ])->with('location_id', $request->input('location_id'))
            ->with('detailed_location', strtoupper(str_replace(',', '', $request->input('detailed_location'))))
            ->with('final_sales_invoice_id', $request->input('final_sales_invoice_id'))
            ->with('driver', strtoupper($request->input('driver')))
            ->with('driver_id', $request->input('driver_id'))
            ->with('trucking_company', strtoupper($request->input('trucking_company')))
            ->with('contact_number', strtoupper($request->input('contact_number')))
            ->with('helper_1', strtoupper($request->input('helper_1')))
            ->with('helper_2', strtoupper($request->input('helper_2')))
            ->with('total_expense_per_delivery', str_replace(',', '', $request->input('total_expense_per_delivery')));
    }

    public function truck_load_save(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $date_now = date('Y-m-d');

        //return $request->input();
        if ($request->input('total_expense_per_delivery') == 0) {
            $new_logistics = new Logistics([
                'truck_id' => $request->input('truck_primary_id'),
                'driver' => $request->input('driver_id'),
                'location_id' => $request->input('location_id'),
                'contact_number' => $request->input('contact_number'),
                'helper_1' => $request->input('helper_1'),
                'helper_2' => $request->input('helper_2'),
                'total_outlet' => $request->input('total_outlet'),
                'user_id' => auth()->user()->id,
                'trucking_company' => $request->input('trucking_company'),
                'number_of_invoices' => $request->input('number_of_invoices'),
            ]);

            $new_logistics->save();
        } else {
            $new_logistics = new Logistics([
                'truck_id' => $request->input('truck_primary_id'),
                'driver' => $request->input('driver_id'),
                'location_id' => $request->input('location_id'),
                'contact_number' => $request->input('contact_number'),
                'helper_1' => $request->input('helper_1'),
                'helper_2' => $request->input('helper_2'),
                'total_outlet' => $request->input('total_outlet'),
                'user_id' => auth()->user()->id,
                'trucking_company' => $request->input('trucking_company'),
                'number_of_invoices' => $request->input('number_of_invoices'),
                'total_expense' => $request->input('total_expense_per_delivery'),
                'total_expense_updated_by' => auth()->user()->id,
            ]);

            $new_logistics->save();
        }

        foreach ($request->input('principal_id') as $key => $data) {
            $new_logistics_details = new Logistics_details([
                'logistics_id' => $new_logistics->id,
                'principal_id' => $data,
                'case' => $request->input('case')[$data],
                'butal' => $request->input('butal')[$data],
                'conversion' => $request->input('conversion')[$data],
                'amount' => $request->input('amount')[$data],
                'percentage' => $request->input('percentage')[$data],
                'equivalent' => $request->input('equivalent')[$data],
                'weight' => $request->input('weight')[$data],
            ]);

            $new_logistics_details->save();

            $logistics_details_id[$data] = $new_logistics_details->id;
        }

        $sales_invoice = Sales_invoice::select('sku_type', 'id')
            ->whereIn('id', $request->input('sales_invoice_id'))
            ->get();

        foreach ($sales_invoice as $key => $value) {
            $data_invoice_details = Sales_invoice_details::select('principal_id', DB::raw('sum(kilograms) as total_kg'), DB::raw('sum(quantity) as total_quantity'), DB::raw('sum(total_amount_per_sku) as total_amount'))
                ->where('sales_invoice_id', $value->id)
                ->first();

            $total_quantity[$value->sku_type] = $data_invoice_details->total_quantity;
            $total_amount[$value->sku_type] = $data_invoice_details->total_amount;
            $total_kg[$value->sku_type] = $data_invoice_details->total_kg;

            Sales_invoice::where('id', $value->id)
                ->update(['truck_load_status' => 'loadsheet']);

            if ($value->sku_type == 'CASE') {
                $new_logistics_invoices = new Logistics_invoices([
                    'logistics_id' => $new_logistics->id,
                    'sales_invoice_id' => $value->id,
                    'principal_id' => $data_invoice_details->principal_id,
                    'case' => $total_quantity[$value->sku_type],
                    'butal' => 0,
                    'conversion' => 0,
                    'amount' => $total_amount[$value->sku_type],
                    'percentage' => 0,
                    'equivalent' => 0,
                    'weight' => $total_kg[$value->sku_type],
                    'logistics_details_id' => $logistics_details_id[$data_invoice_details->principal_id]
                ]);

                $new_logistics_invoices->save();
            } else {
                $sales_invoice_details = Sales_invoice_details::select('sku_id', 'quantity')->where('sales_invoice_id', $value->id)
                    ->get();

                foreach ($sales_invoice_details as $key_2 => $data) {
                    $conversion[] = $data->quantity / $data->sku->equivalent_butal_pcs;
                }

                $new_logistics_invoices = new Logistics_invoices([
                    'logistics_id' => $new_logistics->id,
                    'sales_invoice_id' => $value->id,
                    'principal_id' => $data_invoice_details->principal_id,
                    'case' => 0,
                    'butal' =>  $total_quantity[$value->sku_type],
                    'conversion' => array_sum($conversion),
                    'amount' => $total_amount[$value->sku_type],
                    'percentage' => 0,
                    'equivalent' => 0,
                    'weight' => $total_kg[$value->sku_type],
                    'logistics_details_id' => $logistics_details_id[$data_invoice_details->principal_id]
                ]);

                $new_logistics_invoices->save();
            }

            $sales_invoice_logs = Sales_invoice_status_logs::select('id', 'posted')->where('sales_invoice_id', $value->id)
                ->orderBy('id', 'desc')
                ->first();
            $diff = now()->diffInDays(Carbon::parse($sales_invoice_logs->posted));

            Sales_invoice_status_logs::where('id', $sales_invoice_logs->id)
                ->update([
                    'updated' => $date_now,
                    'no_of_days' => $diff
                ]);

            $new_sales_invoice_status_logs_save = new Sales_invoice_status_logs([
                'sales_invoice_id' => $value->id,
                'posted' => $date_now,
                'updated' => '',
                'status' => 'Loadsheet',
                'user_id' => auth()->user()->id,
            ]);

            $new_sales_invoice_status_logs_save->save();
        }
        Cart::session(auth()->user()->id)->clear();
    }
}
