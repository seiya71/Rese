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
use Endroid\QrCode\Builder\Builder;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::createUser($request->all());

        Auth::login($user);

        event(new Registered($user));

        return redirect('/email/verify');
    }

    public function thanks(){

        $redirectTo = session('redirect_after_login', route('home'));
        session()->forget('redirect_after_login');

        Auth::logout();

        return view('auth.thanks');
    }

    public function showLoginForm(Request $request)
    {
        if ($request->has('redirect')) {
            session(['redirect_after_login' => $request->query('redirect')]);
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect('/email/verify')->with('message', 'メールアドレスを確認してください。');
            }


            $redirectTo = session('redirect_after_login');


            if ($redirectTo && $this->isPostOnlyPath($redirectTo)) {
                $redirectTo = route('home');
            }

            $redirectTo ??= route('home');
            session()->forget('redirect_after_login');

            return redirect($redirectTo);
        }

        return back();
    }

    private function isPostOnlyPath($url)
    {
        return str_contains($url, '/favorite') || str_contains($url, '/togglelike');
    }

    public function mypage()
    {
        $user = Auth::user();

        $reservations = Reservation::with(['shop', 'user'])->where('user_id', $user->id)->get();

        foreach ($reservations as $reservation) {
            $reservation->qrData = $this->generateQrData($reservation);
            $reservation->qrBase64 = base64_encode(
                Builder::create()
                    ->data($reservation->qrData)
                    ->size(200)
                    ->build()
                    ->getString()
            );
        }

        $likeShops = Like::with(['shop.area', 'shop.genre'])->where('user_id', $user->id)->get();

        return view('mypage', compact('user', 'reservations', 'likeShops'));
    }

    private function generateQrData($reservation): string
    {
        return "【予約情報】\n"
            . "店名：{$reservation->shop->shop_name}\n"
            . "予約者：{$reservation->user->name}\n"
            . "日付：" . \Carbon\Carbon::parse($reservation->reservation_datetime)->toDateString() . "\n"
            . "時間：" . \Carbon\Carbon::parse($reservation->reservation_datetime)->format('H:i') . "\n"
            . "人数：{$reservation->guest_count}人";
    }

    public function qrcode($id)
    {
        $reservation = Reservation::with('shop', 'user')->findOrFail($id);

        $qrData = "【予約情報】\n"
            . "店名：{$reservation->shop->shop_name}\n"
            . "予約者：{$reservation->user->name}\n"
            . "日付：" . Carbon::parse($reservation->reservation_datetime)->toDateString() . "\n"
            . "時間：" . Carbon::parse($reservation->reservation_datetime)->format('H:i') . "\n"
            . "人数：{$reservation->guest_count}人";

        return response($qrData, 200)
            ->header('Content-Type', 'text/plain');
    }


    public function done(){
        return view('done');
    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('mypage');
    }

    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'guest_count' => 'required|integer|min:1',
        ]);

        $datetime = $request->date . ' ' . $request->time;

        $reservation->reservation_datetime = $datetime;
        $reservation->guest_count = $request->guest_count;
        $reservation->save();

        return redirect()->route('mypage')->with('status', '予約を変更しました');
    }
}
