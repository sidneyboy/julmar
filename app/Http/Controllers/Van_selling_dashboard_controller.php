<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Vs_sales;
use App\Customer;
use Carbon\Carbon;
use DB;
use DateTime;
use Illuminate\Http\Request;

class Van_selling_dashboard_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);

            date_default_timezone_set('Asia/Manila');

            $employee_name = User::select('id', 'name')->where('id', auth()->user()->id)->first();
            $customer = Customer::select('id', 'store_name', 'location_id')->where('kind_of_business', 'VAN SELLING')->get();
            $principal = Sku_principal::select('principal')->where('principal', '!=', 'NONE')->get();

            $year = date('Y');
            $month = date('m');
            $month_label_for_agent_performance = date('F');
            $daysCount = Carbon::createFromDate($year, $month, 1)->daysInMonth;

            $monthly_sales = Vs_sales::select(
                DB::raw('year(created_at) as year'),
                DB::raw('month(created_at) as month'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->where(DB::raw('date(created_at)'), '>=', $year . "-01-01")
                ->groupBy('year')
                ->groupBy('month')
                ->get()
                ->toArray();

            foreach ($monthly_sales as $monthly_sales_result) {
                $dateObj   = DateTime::createFromFormat('!m', $monthly_sales_result['month']);
                $monthName = $dateObj->format('F'); // March
                $month_label[] = $monthName;
                $monthly_total_sales[] = round($monthly_sales_result['total_sales'], 2);
            }

            $monthly_principal_sales = Vs_sales::select(
                DB::raw('principal_id'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->where(DB::raw('date(created_at)'), '>=', $year . "-01-01")
                ->groupBy('principal_id')
                ->get()
                ->toArray();

            foreach ($monthly_principal_sales as $monthly_principal_sales_result) {
                $monthly_principal_sales_result_principal[] = $monthly_principal_sales_result['principal_id'];
                $monthly_principal_sales_result_sales[] = round($monthly_principal_sales_result['total_sales'], 2);
            }


            $monthly_agent_sales = Vs_sales::select(
                DB::raw('customer_id'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('customer_id')
                ->get()
                ->toArray();

            if ($monthly_agent_sales) {
                foreach ($monthly_agent_sales as $monthly_agent_sales_result) {
                    $agent_data = Customer::select('store_name')->find($monthly_agent_sales_result['customer_id']);
                    $monthly_agent_sales_result_name[] = $agent_data->store_name;
                    $monthly_agent_sales_result_sales[] = round($monthly_agent_sales_result['total_sales'], 2);
                }
            } else {
                $monthly_agent_sales_result_name[] = '';
                $monthly_agent_sales_result_sales[] = '';
            }


            $principal_monthly_sales = Vs_sales::select(
                DB::raw('principal_id'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('principal_id')
                ->get()
                ->toArray();


            if ($principal_monthly_sales) {
                foreach ($principal_monthly_sales as $principal_monthly_sales_result) {
                    $principal_monthly_sales_result_principal[] = $principal_monthly_sales_result['principal_id'];
                    $principal_monthly_sales_result_sales[] = round($principal_monthly_sales_result['total_sales'], 2);
                }
            } else {
                $principal_monthly_sales_result_principal[] = '';
                $principal_monthly_sales_result_sales[] = '';
            }

            $top_10_sku_sales = Vs_sales::select(
                DB::raw('sku_code'),
                DB::raw('sum(quantity) as total_quantity'),
                DB::raw('description'),
                DB::raw('principal_id'),
                DB::raw('unit_price'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('sku_code')
                ->orderBy('total_sales', 'DESC')
                ->take(10)
                ->get()
                ->toArray();

            $top_10_agent_sales = Vs_sales::select(
                DB::raw('customer_id'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('customer_id')
                ->orderBy('total_sales', 'DESC')
                ->take(10)
                ->get()
                ->toArray();

            if ($top_10_agent_sales) {
                foreach ($top_10_agent_sales as $agent) {
                    $top_10_agent_data[] = Customer::select('store_name')->find($agent['customer_id']);
                }
            } else {
                $top_10_agent_data[] = 0;
            }





            $top_10_stores_sales = Vs_sales::select(
                DB::raw('location'),
                DB::raw('store_name'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('store_name')
                ->orderBy('total_sales', 'DESC')
                ->take(10)
                ->get()
                ->toArray();


            $monthly_location_sales = Vs_sales::select(
                DB::raw('location'),
                DB::raw('sum(quantity * unit_price) as total_sales'),
            )->whereMonth('created_at', $month)
                ->groupBy('location')
                ->orderBy('total_sales', 'DESC')
                ->take(10)
                ->get()
                ->toArray();

            if ($monthly_location_sales) {
                foreach ($monthly_location_sales as $monthly_location_sales_result) {
                    $monthly_location_sales_result_location[] = $monthly_location_sales_result['location'];
                    $monthly_location_sales_result_sales[] = round($monthly_location_sales_result['total_sales'], 2);
                }
            } else {
                $monthly_location_sales_result_location[] = '';
                $monthly_location_sales_result_sales[] = '';
            }


            $number_series = 1;
            $number_series_2 = 1;
            $number_series_3 = 1;


            return view('van_selling_dashboard', [
                'user' => $user,
                'main_tab' => 'manage_van_selling_main_tab',
                'sub_tab' => 'manage_van_selling_sub_tab',
                'active_tab' => 'van_selling_dashboard',
                'employee_name' => $employee_name,
                'customer' => $customer,
                'top_10_sku_sales' => $top_10_sku_sales,
                'number_series' => $number_series,
                'top_10_agent_data' => $top_10_agent_data,
                'top_10_agent_sales' => $top_10_agent_sales,
                'number_series_2' => $number_series_2,
                'number_series_3' => $number_series_3,
                'top_10_stores_sales' => $top_10_stores_sales,
                'principal' => $principal,
            ])->with('labels', $month_label)
                ->with('data', $monthly_total_sales)
                ->with('year', $year)
                ->with('month', $month)
                ->with('month_label_for_agent_performance', $month_label_for_agent_performance)
                ->with('monthly_principal_sales_result_month', $monthly_principal_sales_result_principal)
                ->with('monthly_principal_sales_result_sales', $monthly_principal_sales_result_sales)
                ->with('monthly_agent_sales_result_name', $monthly_agent_sales_result_name)
                ->with('monthly_agent_sales_result_sales', $monthly_agent_sales_result_sales)
                ->with('principal_monthly_sales_result_principal', $principal_monthly_sales_result_principal)
                ->with('principal_monthly_sales_result_sales', $principal_monthly_sales_result_sales)
                ->with('monthly_location_sales_result_location', $monthly_location_sales_result_location)
                ->with('monthly_location_sales_result_sales', $monthly_location_sales_result_sales);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }
}
