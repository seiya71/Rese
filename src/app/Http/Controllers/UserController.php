<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::createUser($request->all());

        return redirect('/thanks');
    }

    public function thanks(){
        return view('auth.thanks');
    }

    public function login(LoginRequest $request){
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended($request->input('redirect', route('home')));
        }

        return back();
    }

    public function mypage(){
        return view('mypage');
    }

    public function done(){
        return view('done');
    }
}
