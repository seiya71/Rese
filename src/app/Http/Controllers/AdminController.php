<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

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
}
