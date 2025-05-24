<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;

class QrCodeController extends Controller
{
    public function show($id)
    {
        $reservation = Reservation::with('shop', 'user')->findOrFail($id);

        $qrData = "【予約情報】\n"
            . "店名：{$reservation->shop->name}\n"
            . "予約者：{$reservation->user->name}\n"
            . "日付：{$reservation->date}\n"
            . "時間：{$reservation->time}\n"
            . "人数：{$reservation->people_count}名";

        $result = Builder::create()
            ->data($qrData)
            ->size(200)
            ->build();

        $base64 = base64_encode($result->getString());

        return view('qr.show', compact('base64'));
    }
}
