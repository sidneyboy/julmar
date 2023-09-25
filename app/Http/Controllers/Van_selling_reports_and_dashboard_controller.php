<?php

namespace App\Http\Controllers;

use App\User;
use App\Vs_sales;
use App\Location;
use App\Customer;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Van_selling_reports_and_dashboard_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            date_default_timezone_set('Asia/Manila');
            $date = date('Y-m-d');
            $year = date('Y');
            $month = date('m');
            $month_label_for_agent_performance = date('F');

            $total_monthly_productive_calls = Vs_sales::whereMonth('created_at', $month)->distinct()->count('customer_store_name');

    
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

            return view('van_selling_reports_and_dashboard', [
                'total_monthly_productive_calls' => $total_monthly_productive_calls,
                'month' => $month,
                'date' => $date,
                'year' => $year,
                'user' => $user,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'van_selling_reports_and_dashboard',
                'month_label' => $month_label,
                'monthly_total_sales' => $monthly_total_sales,
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_reports_and_dashboard_productive_calls()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::select('id', 'location')->get();
            $customer = Customer::select('id', 'store_name')
                ->where('kind_of_business', 'VAN SELLING')
                ->get();

            return view('van_selling_reports_and_dashboard_productive_calls', [
                'customer' => $customer,
                'location' => $location,
                'user' => $user,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'van_selling_reports_and_dashboard',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function van_selling_reports_and_dashboard_productive_calls_generate(Request $request)
    {
        //return $request->input();

        $var = explode('-', $request->input('date_range'));
        $date_from = date('Y-m-d', strtotime($var[0]));
        $date_to = date('Y-m-d', strtotime($var[1]));


        $productive_calls = Vs_sales::select(
            'customer_id',
            DB::raw('principal_id'),
            DB::raw('COUNT(customer_store_name) as count'),
        )->whereBetween(DB::raw('DATE(created_at)'),  [$date_from, $date_to])
            ->where('location', $request->input('location_id'))
            ->where('customer_id', $request->input('customer_id'))
            ->groupBy('principal_id')
            ->groupBy('customer_id')
            ->distinct()
            ->get();

       


        return view('van_selling_reports_and_dashboard_productive_calls_generate', [
            'productive_calls' => $productive_calls,
           
        ]);
    }
}
