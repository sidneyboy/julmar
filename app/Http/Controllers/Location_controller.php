<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Location_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $location = Location::get();
            return view('location', [
                'user' => $user,
                'location' => $location,
                'main_tab' => 'manage_agent_and_location_main_tab',
                'sub_tab' => 'manage_agent_and_location_sub_tab',
                'active_tab' => 'location',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function location_save(Request $request)
    {
        $checker = Location::where('location', strtoupper($request->input('location')))
            ->where('detailed_location', strtoupper($request->input('detailed_location')))
            ->count();

        if ($checker == 0) {
            $location_save = new Location([
                'location' => strtoupper($request->input('location')),
                'detailed_location' => strtoupper($request->input('detailed_location')),
            ]);
            $location_save->save();

            return 'saved';
        }else{
            return 'existing';
        }
    }
}
