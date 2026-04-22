<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordForm(){
        return view('admin.auth.forget-password');
    }

    public function sendEmailLink(Request $request){
        // dd('test');
        $request->validate(['email'=>'required|email']);
       
       Password::broker('admins')->sendResetLink(
        $request->only('email')
    );
       return back()->with('status','Password Reset Link Sent Successfully');
    }
}
