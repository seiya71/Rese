<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function amountForm(Reservation $reservation)
    {
        return view('amount', compact('reservation'));
    }

    public function charge(Request $request)
    {
        $amount = $request->input('amount');
        $reservationId = $request->input('reservation_id');

        $reservation = Reservation::findOrFail($reservationId);
        
        Stripe::setApiKey(config('services.stripe.secret'));
        
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => '予約料金',
                        ],
                        'unit_amount' => $amount,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => route('done', ['shopId' => $reservation->shop_id]),
            'cancel_url' => route('amount', ['reservation' => $reservationId]),
        ]);

        return redirect($session->url);
    }
}
