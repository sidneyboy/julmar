<?php

namespace App\Http\Controllers;
use App\User;
use App\Sku_principal;
use App\Location;
use App\Agent;
use App\Agent_principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Agent_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $agent = Agent::get();
            $location = Location::get();
            $principal = Sku_principal::select('id', 'principal')->where('principal', '!=', 'none')->get();
            $agent_principal = Agent_principal::get();
            return view('agent', [
                'user' => $user,
                'agent' => $agent,
                'location' => $location,
                'principal' => $principal,
                'agent_principal' => $agent_principal,
                'main_tab' => 'manage_agent_and_location_main_tab',
                'sub_tab' => 'manage_agent_and_location_sub_tab',
                'active_tab' => 'agent',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function agent_saved(Request $request)
	{
		$agent_saved = new Agent([
			'full_name' => strtoupper($request->input('full_name')),
			'location_id' => $request->input('location'),
			'contact_number' => strtoupper($request->input('contact_number')),
			'full_address' => strtoupper($request->input('full_address')),
			'email_address' => $request->input('email_address'),
			'user_id' => auth()->user()->id,
            'status' => 'active',
		]);

		$agent_saved->save();
		$agent_saved_last_id = $agent_saved->id;

		foreach ($request->input('principal') as $key => $principal_id) {
			$agent_saved_principal = new Agent_principal([
				'agent_id' => $agent_saved_last_id,
				'principal_id' => $principal_id,
			]);

			$agent_saved_principal->save();
		}

		return 'saved';
	}

    
}
