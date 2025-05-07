<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showNoticeForm()
    {
        $users = User::all();
        return view('admin.notice', compact('users'));
    }

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

    public function createShop()
    {
        
    }
}
