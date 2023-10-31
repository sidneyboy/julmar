<?php

namespace App\Http\Controllers;

use App\User;
use App\Logistics;
use App\Logistics_details;
use App\Logistics_invoices;
use App\Sales_invoice;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_load_list_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $logistics = Logistics::select(
                'id',
                'location_id',
                'trucking_company',
                'truck_id',
                'user_id',
                'contact_number',
                'helper_1',
                'helper_2',
                'driver',
                'total_outlet',
                'number_of_invoices',
                'loading_date',
                'loading_date_updated_by',
                'departure_date',
                'departure_date_updated_by',
                'arrival_date',
                'arrival_date_updated_by',
                'sg_departure_noted_by',
                'sg_arrival_noted_by',
                'fuel_given_amount',
                'fuel_given_updated_by',
                'remarks',
                'total_expense',
                'total_expense_updated_by',
            )->where('status', null)->orderBy('id', 'desc')->get();
            return view('truck_load_list', [
                'user' => $user,
                'logistics' => $logistics,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_load_list',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_logistics_details_show(Request $request)
    {
        $logistics_details = Logistics_invoices::select('sales_invoice_id', 'id')
            ->where('logistics_id', $request->input('logistic_id'))
            ->where('delivered_date', null)
            ->get();

        return view('truck_logistics_details_show', [
            'logistics_details' => $logistics_details,
        ])->with('logistics_id', $request->input('logistic_id'));
    }

    public function truck_load_list_update_data(Request $request)
    {
        if ($request->input('logistics_details_data') == 'loading_date') {
            if ($request->input('date_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => $request->input('date_value'),
                        'loading_date_updated_by' => auth()->user()->id,
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'departure_date') {
            if ($request->input('date_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => $request->input('date_value'),
                        'departure_date_updated_by' => auth()->user()->id,
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'arrival_date') {
            if ($request->input('date_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => $request->input('date_value'),
                        'arrival_date_updated_by' => auth()->user()->id,
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'sg_departure_noted_by') {
            if ($request->input('string_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => strtoupper($request->input('string_value')),

                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'sg_arrival_noted_by') {
            if ($request->input('string_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => strtoupper($request->input('string_value')),

                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'remarks') {
            if ($request->input('string_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => strtoupper($request->input('string_value')),
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'fuel_given_amount') {
            if ($request->input('integer_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => $request->input('integer_value'),
                        'fuel_given_updated_by' => auth()->user()->id,
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        } else if ($request->input('logistics_details_data') == 'total_expense') {
            if ($request->input('integer_value') != null) {
                Logistics::where('id', $request->input('logistics_id'))
                    ->update([
                        $request->input('logistics_details_data') => $request->input('integer_value'),
                        'total_expense_updated_by' => auth()->user()->id,
                    ]);
                return redirect('truck_load_list')->with('success', 'Logistics Data Updated!');
            } else {
                return redirect('truck_load_list')->with('error', 'Cannot proceed. No value');
            }
        }
    }

    public function truck_load_list_update_delivery_status(Request $request)
    {
        $delivery_array = $request->input('delivery_date');
        if (isset($delivery_array)) {
            foreach ($request->input('delivery_date') as $key => $data) {
                Logistics_invoices::where('id', $key)
                    ->update(['delivered_date' => $data]);

                Sales_invoice::where('id', $request->input('sales_invoice_id')[$key])
                    ->update([
                        'delivered_date' => $data,
                        'delivery_status' => 'delivered',
                        'truck_load_status' => 'delivery success',
                    ]);
            }
        }


        if ($request->input('mark_as_status') != null) {
            Logistics::where('id', $request->input('logistics_id'))
                ->update(['status' => $request->input('mark_as_status')]);
        }
    }

    public function truck_load_lost_update_loading_date(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'loading_date' => $request->input('loading_date'),
                'loading_date_updated_by' => auth()->user()->id,
            ]);

        return redirect('truck_load_list')->with('success', 'Loading Date Updated Successfully');
    }

    public function truck_load_lost_update_departure_date(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'departure_date' => $request->input('departure_date'),
                'departure_date_updated_by' => auth()->user()->id,
            ]);

        return redirect('truck_load_list')->with('success', 'Departure Date Updated Successfully');
    }

    public function truck_load_lost_update_arrival_date(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'arrival_date' => $request->input('arrival_date'),
                'arrival_date_updated_by' => auth()->user()->id,
            ]);

        return redirect('truck_load_list')->with('success', 'Arrival Date Updated Successfully');
    }

    public function truck_load_lost_update_sg_departure_noted_by(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'sg_departure_noted_by' => $request->input('sg_departure_noted_by'),
            ]);

        return redirect('truck_load_list')->with('success', 'SG Noted By Updated Successfully');
    }

    public function truck_load_lost_update_sg_arrival_noted_by(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'sg_arrival_noted_by' => $request->input('sg_arrival_noted_by'),
            ]);

        return redirect('truck_load_list')->with('success', 'SG Noted By Updated Successfully');
    }

    public function truck_load_lost_update_fuel_given(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'fuel_given_amount' => $request->input('fuel_given_amount'),
            ]);

        return redirect('truck_load_list')->with('success', 'Fuel Given Amount Updated Successfully');
    }

    public function truck_load_lost_update_remarks(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'remarks' => $request->input('remarks'),
            ]);

        return redirect('truck_load_list')->with('success', 'Remarks Updated Successfully');
    }

    public function truck_load_lost_update_total_expense(Request $request)
    {
        Logistics::where('id', $request->input('id'))
            ->update([
                'total_expense' => $request->input('total_expense'),
                'total_expense_updated_by' => auth()->user()->id,
            ]);

        $logistics_details = Logistics_details::where('logistics_id', $request->input('id'))
            ->get();

        foreach ($logistics_details as $key => $value) {
            $equivalent = $request->input('total_expense') * $value->percentage;

            Logistics_details::where('id', $request->input('id'))
                ->update([
                    'equivalent' => $equivalent,
                ]);
        }

        return redirect('truck_load_list')->with('success', 'Total Expense Updated Successfully');
    }

    public function truck_load_list_print($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $logistics = Logistics::find($id);

        return view('truck_load_list_print', [
            'logistics' => $logistics,
            'date' => $date,
        ]);
    }

    public function truck_load_list_driver_print($id)
    {
        date_default_timezone_set('Asia/Manila');
        $date = date('Y-m-d');
        $logistics = Logistics::find($id);

        foreach ($logistics->logistics_details as $key => $value) {
            // echo $value->principal_id;
            $user = User::where('principal_id', $value->principal_id)->first();
            $custodian[$value->principal_id] = $user->name;
        }

        return view('truck_load_list_driver_print', [
            'logistics' => $logistics,
            'custodian' => $custodian,
            'date' => $date,
        ]);
    }
}
