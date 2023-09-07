<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Session;

class CustomAuth extends Controller
{
    public function login() {
        return view("login.login");
    }

    public function loginUser(Request $request) {

        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5'
        ]);

        $user = User::where('email','=',$request->email)->first();

        if ($user) {
            if(Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId',$user->id);
                return redirect('dashboard');
            }
            else {
            return back()->with('fail','Password does not match.');

            }
        } 
        else {
            return back()->with('fail','This email is not registered.');
        }
        
    }

    public function dashboard() {

        return view('layouts.dashboard');
    }

    public function logout() {
        if(Session::has('loginId')) {

            Session::pull('loginId');
            return redirect('login');
        }
    }
}
