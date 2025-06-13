<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Like;
use App\Models\Reservation;
use Carbon\Carbon;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function マイページにユーザーの名前が表示されている。(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    /** @test */
    public function マイページにお気に入り店舗が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $shop = Shop::factory()->create([
            'shop_name' => 'サンプル店',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('サンプル店');
    }

    /** @test */
    public function マイページに予約状況が表示される()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $shop = Shop::factory()->create([
            'shop_name' => 'サンプル店',
        ]);

        Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($user);
        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('予約1');
    }

    /** @test */
    public function ユーザーは自分の予約を削除できる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $this->actingAs($user);

        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        $response = $this->delete("/reservation/{$reservation->id}");

        $response->assertRedirect('/mypage');
        $this->assertDatabaseMissing('reservations', [
            'id' => $reservation->id,
        ]);
    }

    /** @test */
    public function ユーザーは自分の予約を変更できる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_datetime' => '2025-06-15 19:00:00',
            'guest_count' => 2,
        ]);

        $this->actingAs($user);
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        $date = now()->addDays(5)->format('Y-m-d');
        $time = '18:30:00';
        $newDateTime = "{$date} {$time}";
        $newNumber = 4;

        $response = $this->put("/reservation/update/{$reservation->id}", [
            'date' => $date,
            'time' => $time,
            'guest_count' => $newNumber,
        ]);

        $response->assertRedirect('/mypage');

        $this->assertDatabaseHas('reservations', [
            'id' => $reservation->id,
            'reservation_datetime' => $newDateTime,
            'guest_count' => $newNumber,
        ]);
    }

    /** @test */
    public function 予約情報のQRコードに正しい内容が含まれている()
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
        ]);

        $shop = Shop::factory()->create([
            'shop_name' => 'サンプル店',
        ]);

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_datetime' => '2025-06-15 18:00:00',
            'guest_count' => 3,
        ]);

        $this->actingAs($user);
        $response = $this->get("/reservation/{$reservation->id}/qrcode");

        $response->assertStatus(200);

        $response->assertSee('店名：サンプル店');
        $response->assertSee('予約者：テストユーザー');
        $response->assertSee('日付：2025-06-15');
        $response->assertSee('時間：18:00');
        $response->assertSee('人数：3人');
    }

}
