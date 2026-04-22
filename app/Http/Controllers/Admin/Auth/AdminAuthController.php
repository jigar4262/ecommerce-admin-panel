<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin(){
    
        return view('admin.auth.login');
    }

    public function login(Request $request){
        $credentials=$request->only('email','password');

        if(Auth::attempt($credentials)){
            $user=Auth::user();
            $request->session()->put('admin_id',$user->id);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error','Invalid credentials');

    }

    public function logout(Request $request){
          $request->session()->forget('admin_id');
          $request->session()->flush();
          return redirect()->route('admin.login');
    }
}
