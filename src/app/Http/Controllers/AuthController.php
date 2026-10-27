<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::createUser($request->all());

        Auth::login($user);

        session()->regenerate();

        event(new Registered($user));

        return redirect('/email/verify');
    }
}
