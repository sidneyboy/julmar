<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::select('name','position')->find(Auth()->user()->id);
        return view('dashboard',[
            'main_tab' => 'manage_principal_main_tab',
            'sub_tab' => 'manage_principal_sub_tab',
            'active_tab' => 'new_principal',
        ])->with('user',$user);
    }

}
