<?php

namespace App\Http\Controllers;

use App\User;
use App\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Truck_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $truck = Truck::get();
            return view('truck_register', [
                'user' => $user,
                'truck' => $truck,
                'main_tab' => 'manage_logistics_main_tab',
                'sub_tab' => 'manage_logistics_sub_tab',
                'active_tab' => 'truck_register',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function truck_register_save(Request $request)
    {
        $new = new Truck([
            'plate_no' => strtoupper($request->input('plate_no')),
            'capacity' => $request->input('capacity'),
            'model' => $request->input('model'),
        ]);

        $new->save();

        return redirect('truck_register');
    }
}
