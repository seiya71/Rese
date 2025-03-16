<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

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

    public function addlike($shopId)
    {
        $user = Auth::user();

        if (!$user) {
            session(['redirect_after_login' => url()->current()]);
            return redirect()->route('login');
        }

        $userId = Auth::id();

        if (!Like::where('user_id', $userId)->where('shop_id', $shopId)->exists()) {
            Like::create([
                'user_id' => $userId,
                'shop_id' => $shopId
            ]);
        }

        return redirect()->back();
    }

    public function removelike($shopId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        Like::where('user_id', $user->id)
            ->where('shop_id', $shopId)
            ->delete();

        return redirect()->back();
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

    public function done(){
        return view('done');
    }
}
