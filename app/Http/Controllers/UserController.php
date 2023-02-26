<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return redirect('/login');
    }

    public function login()
    {
        if(auth()->check()){
            return redirect('/dashboard')->with('message', 'Login success.');
        }
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($formFields)) {

            $request->session()->regenerate();

            if(auth()->user()->role == 1){
                return redirect('/dashboard')->with('message', 'Login success.');
            }else{
                return redirect('/home')->with('message', 'Login success.');
            }
        }

        return back()->withErrors(['password' => 'Invalid Credentials'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
