<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_datetime',
        'guest_count',
        'shop_id',
        'user_id',
        'used_at'
    ];

    public static function createReservation($userId, $shopId, $datetime, $guestCount)
    {
        return self::create([
            'user_id' => $userId,
            'shop_id' => $shopId,
            'reservation_datetime' => $datetime,
            'guest_count' => $guestCount,
            'used_at' => now(),
        ]);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
