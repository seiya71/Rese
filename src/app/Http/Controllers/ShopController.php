<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;

class ShopController extends Controller
{
    public function index(){
        $user = Auth::user();

        $favoriteShopIds = [];

        if ($user) {
            $favoriteShopIds = $user->likes()->pluck('shop_id')->toArray();

        }

        $shops = Shop::with(['area', 'genre'])->get();

        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'favoriteShopIds', 'areas', 'genres'));
    }

    public function toggleLike($shopId)
    {
        $user = Auth::user();

        if (!$user) {
            session(['redirect_after_login' => url()->current()]);
            return redirect()->route('login');
        }

        $isFavorite = Like::toggleFavorite($user->id, $shopId);

        if ($isFavorite) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $favoriteShopIds = [];

        if ($user) {
            $favoriteShopIds = $user->likes()->pluck('shop_id')->toArray();

        }

        $shops = Shop::with(['area', 'genre'])
            ->AreaSearch($request->area)
            ->GenreSearch($request->genre)
            ->KeywordSearch($request->keyword)
            ->get();

        $areas = Area::all();
        $genres = Genre::all();

        return view('index', compact('shops', 'favoriteShopIds', 'areas', 'genres'));
    }

    public function detail($shopId){
        $user = Auth::user();
        $shop = Shop::with(['area', 'genre'])->findOrFail($shopId);

        if (request()->has(['date', 'time', 'guest_count'])) {
            session([
                'temp_reservation' => [
                    'shop_id' => $shopId,
                    'date' => request('date'),
                    'time' => request('time'),
                    'guest_count' => request('guest_count')
                ]
            ]);
        }

        $tempReservation = session('temp_reservation');

        $reviews = \App\Models\Review::where('shop_id', $shopId)
            ->with('user') // ユーザー情報をつける（名前など）
            ->latest()
            ->get();

        // ビューに渡す
        return view('detail', compact('shop', 'tempReservation', 'reviews'));
    }

    public function reservation(ReservationRequest $request, $shopId)
    {
        if (!Auth::check()) {
            session(['redirect_after_login' => route('detail', ['id' => $shopId])]);
            return redirect()->route('login');
        }

        $user = Auth::user();

        $tempReservation = session('temp_reservation');

        if (!$tempReservation || $tempReservation['shop_id'] != $shopId) {
            return redirect()->back();
        }

        $reservationDatetime = $tempReservation['date'] . ' ' . $tempReservation['time'];

        Reservation::createReservation(
            $user->id,
            $shopId,
            $reservationDatetime,
            $tempReservation['guest_count']
        );

        session()->forget('temp_reservation');

        return redirect()->route('done', ['shopId' => $shopId]);
    }

    public function done(){
        return view('done');
    }

    public function review(Request $request, $shopId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // 投稿済みチェックや重複防止したいならここで条件つけてもOK

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'shop_id' => $shopId,
            'comment' => $request->input('comment'),
            'rating' => 5,
        ]);

        return back()->with('success', 'コメントを投稿しました！');
    }
}
