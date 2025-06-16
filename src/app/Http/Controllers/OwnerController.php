<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Area;
use App\Models\Genre;
use App\Http\Requests\ShopRequest;

class OwnerController extends Controller
{
    public function owner()
    {
        $owner = auth()->user();

        if ($owner->role !== 'owner') {
            return redirect()->back();
        }

        $shops = $owner->shops;

        return view('owner', compact('owner', 'shops'));
    }

    public function shopCreate(ShopRequest $request)
    {
        $user = Auth::user();

        $validatedData = $request->validated();

        $imagePath = self::saveImage($request) ?? session('shop_image');

        $shop = Shop::create([
            'shop_name' => $validatedData['shop_name'],
            'shop_image' => $imagePath,
            'area_id' => $validatedData['area'],
            'genre_id' => $validatedData['genre'],
            'introduction' => $validatedData['introduction'],
            'user_id' => $user->id,
        ]);

        session()->forget('shop_image');

        session()->forget('update_open');

        return redirect()->route('owner');
    }

    public function shopUpdate(ShopRequest $request, $shopId)
    {
        $shop = Shop::findOrFail($shopId);

        if (session()->has('shop_image')) {
            $shop->shop_image = session('shop_image');
        }

        $shop->update($request->validated());

        session()->forget('shop_image');

        session()->forget('update_open');

        return redirect()->route('shopAdmin', ['shopId' => $shop->id]);
    }

    public static function saveImage(Request $request, string $inputName = 'shop_image'): ?string
    {
        if ($request->hasFile($inputName)) {
            $filename = $request->file($inputName)->hashName();
            $request->file($inputName)->store('images/shop_images', 'public');

            return $filename;
        }
        return null;
    }

    public function uploadShopImage(Request $request)
    {
        $filename = self::saveImage($request);
        if ($filename) {
            session(['shop_image' => $filename]);
        }

        if (app()->runningUnitTests()) {
            return response()->json(['shop_image' => $filename]);
        }

        session(['update_open' => true]);

        return back();
    }

    public function showCreate()
    {
        $user = Auth::user();

        $areas = Area::all();

        $genres = Genre::all();

        return view('shopCreate', compact('user', 'areas', 'genres'));
    }

    public function shopAdmin($shopId)
    {
        $shop = Shop::with(['area', 'genre'])->findOrFail($shopId);

        $reservations = Reservation::with('shop')->get();

        $users = User::select('id', 'name', 'email')->get();

        $areas = Area::all();

        $genres = Genre::all();


        return view('shopAdmin', compact('shop', 'reservations', 'users', 'areas', 'genres'));
    }

    public function sendNotice(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $message = $request->input('message');

        Mail::to($user->email)->send(new NoticeMail($message, $user));

        return back()->with('status', 'メールを送信しました！');
    }
}
