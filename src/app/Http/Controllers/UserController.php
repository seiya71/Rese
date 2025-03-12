<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

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
