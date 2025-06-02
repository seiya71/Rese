<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class ReservationController extends Controller
{
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

        $reservation = Reservation::createReservation(
            $user->id,
            $shopId,
            $reservationDatetime,
            $tempReservation['guest_count']
        );

        session()->forget('temp_reservation');

        return redirect()->route('amount', ['reservation' => $reservation->id]);
    }

    public function review(Request $request, $shopId)
    {
        $userId = auth()->id();

        if (!ReservationController::canReview($userId, $shopId)) {
            return back()->with('error', 'このお店のレビューは投稿できません。');
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Review::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
            'comment' => $request->input('comment'),
            'rating' => $request->input('rating'),
        ]);

        session()->forget('selected_rating');

        return back()->with('success', 'コメントと評価を投稿しました！');
    }

    public static function canReview($userId, $shopId): bool
    {
        return Reservation::where('user_id', $userId)
            ->where('shop_id', $shopId)
            ->whereNotNull('used_at')
            ->exists();
    }
}
