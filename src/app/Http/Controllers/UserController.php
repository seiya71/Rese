<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Like;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $redirectTo = session('redirect_after_login', route('home'));
            session()->forget('redirect_after_login');

            return redirect($redirectTo);
        }

        return back();
    }

    public function mypage()
    {
        $user = Auth::user();

        $reserve = Reservation::with('shop')->find($user->id);

        $likeShops = Like::with(['shop.area', 'shop.genre'])->where('user_id', $user->id)->get();

        return view('mypage', [
            'likeShops' => $likeShops,
            'user' => $user,
            'reservation' => $reserve,
            'date' => Carbon::parse($reserve->reservation_datetime)->toDateString(),
            'time' => Carbon::parse($reserve->reservation_datetime)->format('H:i')
        ]);
    }

    public function done(){
        return view('done');
    }
}
