<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id'
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
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
