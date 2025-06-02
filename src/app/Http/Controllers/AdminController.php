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

class AdminController extends Controller
{
    public function admin()
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return redirect()->back();
        }

        return view('admin');
    }

    

    public function ownerRegister(RegisterRequest $request)
    {
        $user = User::createOwner($request->all());

        return redirect()->back()->with('success', 'オーナー登録が完了しました');
    }
}
