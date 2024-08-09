<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }

    public function admin_login(){
        return view('admin.auth.login');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('admin/login');
    } 

    public function profile(){

        $user = Auth()->user();

        if($user){
            return view('admin.auth.profile',compact('user'));
        }else{
            return redirect('admin/login');
        }
    }

    public function update_profile(Request $request){

    }
}
