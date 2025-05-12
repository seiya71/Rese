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
use App\Http\Requests\ShopUpdateRequest;

class AdminController extends Controller
{

    public function sendNotice(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $message = $request->input('message');

        Mail::to($user->email)->send(new NoticeMail($message, $user));

        return back()->with('status', 'メールを送信しました！');
    }

    public function admin()
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return redirect()->back();
        }

        return view('admin');
    }

    public function owner()
    {
        $owner = auth()->user();

        if ($owner->role !== 'owner') {
            return redirect()->back();
        }

        $shops = $owner->shops;

        return view('owner', compact('owner', 'shops'));
    }

    public function ownerRegister(RegisterRequest $request)
    {
        $user = User::createOwner($request->all());

        return redirect()->back()->with('success', 'オーナー登録が完了しました');
    }

    public function shopAdmin($shopId)
    {
        $shop = Shop::with(['area', 'genre'])->findOrFail($shopId);

        $reservations = Reservation::with('shop')->get();

        $users = User::select('id', 'name', 'email')->get();

        $areas = Area::all();

        $genres = Genre::all();


        return view('shopAdmin', compact('shop', 'reservations','users', 'areas', 'genres'));
    }

    public function showCreate()
    {
        return view('shopCreate');
    }

    public function shopCreate(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validated();

        $shop = Shop::create([
            'shop_name' => $validatedData['shop_name'],
            'shop_image' => $validatedData['shop_image'] ?? null,
            'area' => $validatedData['area'],
            'genre' => $validatedData['genre'],
            'introduction' => $validatedData['introduction'],
            'user_id' => $user->id,
        ]);

        session()->forget('shop_image');

        return redirect()->route('owner');
    }

    public function uploadShopImage(Request $request)
    {
        if ($request->hasFile('shop_image')) {
            $path = $request->file('shop_image')->store('shop_images', 'public');

            session(['shop_image' => $path]);

            if (app()->runningUnitTests()) {
                return response()->json(['shop_image' => $path]);
            }

            return back();
        }

        return back();
    }

    public function shopUpdate(ShopUpdateRequest $request, $shopId)
    {
        $shop = Shop::findOrFail($shopId);

        if (session()->has('shop_image')) {
            $shop->shop_image = session('shop_image');
        }

        $shop->update($request->validated());

        session()->forget('shop_image');

        return redirect()->route('shopAdmin', ['shopId' => $shop->id]);
    }
}
