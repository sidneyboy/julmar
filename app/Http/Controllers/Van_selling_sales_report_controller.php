<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Customer;
use App\Location;
use App\Van_selling_upload_ledger;
use App\Van_selling_sales;
use DB;
use Illuminate\Http\Request;

class Van_selling_sales_report_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $sales_agent = Customer::select('store_name', 'id')->where('kind_of_business', 'VAN SELLING')->get();
            return view('van_selling_sales_report', [
                'user' => $user,
                'sales_agent' => $sales_agent,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_sales_report',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_sales_report_search_for(Request $request)
    {

        //return $request->input();
        if ($request->input('search_for') == 'search_per_principal') {
            $principal = Sku_principal::select('principal')->where('principal', '!=', 'None')->get();
            return view('van_selling_sales_report_search_for_page', [
                'principal' => $principal,
            ])->with('search_for', $request->input('search_for'));
        } elseif ($request->input('search_for') == 'search_per_account') {
            //return $request->input();
            $var = explode('-', $request->input('reservation'));
            $date_from = date('Y-m-d', strtotime($var[0]));
            $date_to = date('Y-m-d', strtotime($var[1]));

            $explode_sales_agent = explode(',', $request->input('customer_id'));
            $customer_id = $explode_sales_agent[0];
            $store_name = $explode_sales_agent[1];

            $principal = Sku_principal::select('principal')->where('principal', '!=', 'None')->get();

            $van_selling_upload_ledger = Van_selling_sales::select('store_name')->where('sales', '!=', '0')->where('customer_id', $customer_id)->whereBetween('date', [$date_from, $date_to])->groupBy('store_name')->get();

            return view('van_selling_sales_report_search_for_page', [
                'van_selling_upload_ledger' => $van_selling_upload_ledger,
                'principal' => $principal,
            ])->with('search_for', $request->input('search_for'));
        } else {
            $principal = Sku_principal::select('principal')->where('principal', '!=', 'None')->get();
            $location = Location::get();
            return view('van_selling_sales_report_search_for_page', [
                'location' => $location,
                'principal' => $principal,
            ])->with('search_for', $request->input('search_for'));
        }
    }

    public function van_selling_sales_report_generate(Request $request)
    {
        //return $request->input();
        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));

        $explode_sales_agent = explode(',', $request->input('customer_id'));
        $customer_id = $explode_sales_agent[0];
        $store_name = $explode_sales_agent[1];

        if ($request->input('customer_id') == 'over_all , over_all') {
            if ($request->input('search_for') == 'search_per_location') {
                if ($request->input('principal') == 'all_principal') {
                    $van_selling_sales = Van_selling_sales::where('location', 'like', '%' . $request->input('location') . '%')
                        ->where('sales', '!=', '0')
                        ->whereBetween('date', [$date_from, $date_to])
                        ->orderBy('reference')
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                } else {
                    $van_selling_sales = Van_selling_sales::where('location', 'like', '%' . $request->input('location') . '%')
                        ->where('principal', $request->input('principal'))
                        ->where('sales', '!=', '0')
                        ->whereBetween('date', [$date_from, $date_to])
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                }
            } else {

                $van_selling_sales = Van_selling_sales::where('principal', $request->input('principal'))
                    ->where('sales', '!=', '0')
                    ->whereBetween('date', [$date_from, $date_to])
                    ->get();

                return view('van_selling_sales_report_generate_per_principal_page', [
                    'van_selling_sales' => $van_selling_sales,
                ])->with('date_from', $date_from)
                    ->with('store_name', $store_name)
                    ->with('date_to', $date_to);
            }
        } else {
            if ($request->input('search_for') == 'search_per_principal') {
                if ($request->input('principal') == 'all_principal') {
                    $van_selling_sales = Van_selling_sales::where('sales', '!=', '0')
                        ->where('customer_id', $customer_id)
                        ->whereBetween('date', [$date_from, $date_to])
                        ->orderBy('reference')
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                } else {
                    $van_selling_sales = Van_selling_sales::where('principal', $request->input('principal'))
                        ->where('sales', '!=', '0')
                        ->where('customer_id', $customer_id)
                        ->whereBetween('date', [$date_from, $date_to])
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                }
            } elseif ($request->input('search_for') == 'search_per_location') {
                if ($request->input('principal') == 'all_principal') {
                    $van_selling_sales = Van_selling_sales::where('location', 'like', '%' . $request->input('location') . '%')
                        ->where('customer_id', $customer_id)
                        ->where('sales', '!=', '0')
                        ->whereBetween('date', [$date_from, $date_to])
                        ->orderBy('reference')
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                } else {
                    $van_selling_sales = Van_selling_sales::where('principal', $request->input('principal'))
                        ->where('location', 'like', '%' . $request->input('location') . '%')
                        ->where('customer_id', $customer_id)
                        ->where('sales', '!=', '0')
                        ->whereBetween('date', [$date_from, $date_to])
                        ->get();

                    return view('van_selling_sales_report_generate_per_principal_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('store_name', $store_name)
                        ->with('date_to', $date_to);
                }
            } else {

                if ($request->input('principal') == 'all_principal') {
                    $van_selling_sales = DB::table('Van_selling_sales')
                        ->select(
                            'customer_id',
                            'store_name',
                            'vs_upload_id',
                            'principal',
                            'sku_code',
                            'description',
                            'unit_of_measurement',
                            'sku_type',
                            'butal_equivalent',
                            'reference',
                            'sales',
                            'unit_price',
                            'total',
                            'date',
                            'date_sold',
                            'location',
                            DB::raw('SUM(sales) as total_sales')
                        )
                        ->whereBetween('date', [$date_from, $date_to])
                        ->where('customer_id', $customer_id)
                        ->where('store_name', $request->input('account'))
                        ->groupBy('sku_code')
                        ->orderBy('principal')
                        ->get();

                    return view('van_selling_sales_report_generate_per_account_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('date_to', $date_to)
                        ->with('store_name', $store_name);
                } else {
                    $van_selling_sales = DB::table('Van_selling_sales')
                        ->select(
                            'customer_id',
                            'store_name',
                            'vs_upload_id',
                            'principal',
                            'sku_code',
                            'description',
                            'unit_of_measurement',
                            'sku_type',
                            'butal_equivalent',
                            'reference',
                            'sales',
                            'unit_price',
                            'total',
                            'date',
                            'date_sold',
                            'location',
                            DB::raw('SUM(sales) as total_sales')
                        )
                        ->whereBetween('date', [$date_from, $date_to])
                        ->where('customer_id', $customer_id)
                        ->where('store_name', $request->input('account'))
                        ->where('principal', $request->input('principal'))
                        ->groupBy('sku_code')
                        ->orderBy('principal')
                        ->get();

                    return view('van_selling_sales_report_generate_per_account_page', [
                        'van_selling_sales' => $van_selling_sales,
                    ])->with('date_from', $date_from)
                        ->with('date_to', $date_to)
                        ->with('store_name', $store_name);
                }
            }
        }
    }

    public function van_selling_sales_report_generate_itemized_sales($data)
    {
        $explode = explode('{}', $data);
        $sku_code = $explode[0];
        $customer_id = $explode[1];
        $date_from = $explode[2];
        $date_to = $explode[3];
        $account = $explode[4];

        $van_selling_sales = Van_selling_sales::whereBetween('date', [$date_from, $date_to])
            ->where('sku_code', $sku_code)
            ->where('customer_id', $customer_id)
            ->where('store_name', $account)
            ->get();

        return view('van_selling_sales_report_generate_itemized_sales', [
            'van_selling_sales' => $van_selling_sales
        ]);
    }
}
