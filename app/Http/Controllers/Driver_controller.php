<?php

namespace App\Http\Controllers;

use App\Driver_helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class Driver_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $driver = Driver_helper::select('id', 'full_name', 'contact_number', 'work_description')->get();

            return view('driver', [
                'driver' => $driver,
                'user' => $user,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'driver',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function driver_saved(Request $request)
    {
        $new_driver = new Driver_helper([
            'full_name' => strtoupper($request->input('full_name')),
            'contact_number' => $request->input('contact_number'),
            'full_address' => '',
            'truck_unit_number' => '',
            'work_description' =>'',
            'user_id' => auth()->user()->id,
        ]);

        $new_driver->save();

        return redirect('driver');
    }
}
