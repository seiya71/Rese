<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Shop;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public static function toggleFavorite($userId, $shopId)
    {
        $like = self::where('user_id', $userId)->where('shop_id', $shopId)->first();

        if ($like) {
            $like->delete();
            return false;
        } else {
            self::create([
                'user_id' => $userId,
                'shop_id' => $shopId
            ]);
            return true;
        }
    }
}
