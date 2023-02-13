<?php

namespace App\Http\Controllers;

use App\User;
use App\Sku_principal;
use App\Sku_category;
use App\Sku_sub_category;
use Illuminate\Http\Request;

class Manage_principal_controller extends Controller
{
    public function index()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal_data = Sku_principal::get();
            return view('new_principal', [
                'user' => $user,
                'principal_data' => $principal_data,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'new_principal',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function new_principal_process(Request $request)
    {
        $new = new Sku_principal([
            'principal' => $request->input('principal'),
            'contact_number' => $request->input('contact_number'),
        ]);

        if ($new->save()) {
            return redirect('new_principal')->with('success', 'Successfully Added New Principal');
        } else {
            return redirect('new_principal')->with('success', 'Error. Please Call IT Support');
        }
    }

    public function new_principal_categories()
    {
        if (Auth()->user()->id) {
            $user = User::select('name', 'position')->find(Auth()->user()->id);
            $principal = Sku_principal::where('principal','!=','none')->get();
            $category = Sku_category::get();

            return view('new_principal_categories', [
                'user' => $user,
                'principal' => $principal,
                'category' => $category,
                'main_tab' => 'manage_principal_main_tab',
                'sub_tab' => 'manage_principal_sub_tab',
                'active_tab' => 'new_principal_categories',
            ]);
        } else {
            return redirect('auth.login')->with('error', 'Session Expired. Please Login');
        }
    }

    public function new_categories_process(Request $request)
    {
        $category_name = strtolower($request->input('category'));
        $category = new Sku_category([
            'category' => ucfirst($category_name),
            'principal_id' => $request->input('principal_id'),
        ]);

        if ($category->save()) {
            return redirect('new_principal_categories')->with('success', 'Successfully Added New Principal Category');
        } else {
            return redirect('new_principal_categories')->with('error', 'Something Went Wrong. Please Call IT Support');
        }
    }

    public function new_principal_categories_update(Request $request, $id)
    {
        $request->validate([
            'editCategory' => 'required'
        ]);

        $category = Sku_category::find($id);
        $category->category = $request->get('editCategory');

        if ($category->save()) {
            return redirect('new_principal_categories')->with('success', 'Successfully Updated Selected Category');
        } else {
            return redirect('new_principal_categories')->with('error', 'Something Went Wrong. Please Call IT Support');
        }
    }

    public function sku_category_add_sub_category(Request $request)
    {
        //return $request->input();

        $sub_category = strtolower($request->input('sub_category'));
        $new = new Sku_sub_category([
            'main_category_id' => $request->input('category_id'),
            'sub_category' => ucfirst($sub_category),
        ]);

        if ($new->save()) {
            return redirect('new_principal_categories')->with('success', 'Successfully Added New Sub Category');
        } else {
            return redirect('new_principal_categories')->with('error', 'Something Went Wrong. Please Call IT Support');
        }
    }
}
