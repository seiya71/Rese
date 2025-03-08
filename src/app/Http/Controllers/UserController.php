<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(){
        return view('auth.register');
    }

    public function thanks(){
        return view('auth.thanks');
    }

    public function login(){
        return view('auth.login');
    }

    public function mypage(){
        return view('mypage');
    }

    public function done(){
        return view('done');
    }
}
