<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Review;
use App\Http\Controllers\ReservationController;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

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

        $selectedRating = request('rating') ?? session('selected_rating', null);

        if (request('rating')) {
            session(['selected_rating' => (int) request('rating')]);
            return redirect()->route('detail', ['shopId' => $shopId]);
        }

        $reviews = Review::where('shop_id', $shopId)->with('user')->get();

        $canReview = $user ? ReservationController::canReview($user->id, $shopId) : false;

        return view('detail', compact('shop', 'tempReservation', 'reviews', 'selectedRating', 'canReview'));
    }
}
