<?php

namespace App\Http\Controllers;

use App\Ewt_rate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Ewt_rate_controller extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $ewt = Ewt_rate::get();
            return view('ewt_rate', [
                'user' => $user,
                'ewt' => $ewt,
                'main_tab' => 'manage_accounting_tab',
                'sub_tab' => 'manage_accounting_sub_tab',
                'active_tab' => 'ewt_rate',
            ]);
        } else {
            return redirect('/')->with('error', 'Session Expired. Please Login');
        }
    }

    public function ewt_rate_process(Request $request)
    {
        $new = new Ewt_rate([
            'ewt_rate' => $request->input('ewt_rate'),
            'user_id' => auth()->user()->id,
        ]);

        $new->save();

        return redirect('ewt_rate');
    }
}
