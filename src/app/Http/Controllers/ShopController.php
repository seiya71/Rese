<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Reservation;

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

    public function detail($id){
        $shop = Shop::findOrFail($id);

        return view('detail', compact('shop'));
    }

    public function reservation(Request $request, $shopId)
    {
        $user = Auth::user();

        if (!$user) {
            session(['redirect_after_login' => route('detail', $shopId)]);
            return redirect()->route('login');
        }

        $reservationDatetime = $request->date . ' ' . $request->time;

        Reservation::createReservation($user->id, $shopId, $reservationDatetime, $request->guest_count);

        return redirect()->route('done', ['shopId' => $shopId]);
    }

    public function done(){
        return view('done');
    }
}
