<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\User;
use App\Models\Reservation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Mockery;

class DetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 店舗詳細ページに必要な情報が表示される()
    {
        $area = Area::factory()->create(['area_name' => '東京']);
        $genre = Genre::factory()->create(['genre_name' => '居酒屋']);

        $shop = Shop::factory()->create([
            'shop_name' => 'テスト居酒屋',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'introduction' => '美味しい料理とお酒が楽しめます。',
            'shop_image' => 'sample.jpg',
        ]);

        $response = $this->get('/detail/' . $shop->id);

        $response->assertStatus(200);
        $response->assertSee('テスト居酒屋');
        $response->assertSee('東京');
        $response->assertSee('居酒屋');
        $response->assertSee('美味しい料理とお酒が楽しめます。');
        $response->assertSee('sample.jpg');
    }

    /** @test */
    public function 日付未入力で予約するとエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $this->actingAs($user);

        $response = $this->from('/detail/' . $shop->id)
            ->post('/reserve/' . $shop->id, [
                'shop_id' => $shop->id,
                'date' => '',
                'time' => '18:00',
                'guest_count' => 2,
            ]);

        $response->assertRedirect('/detail/' . $shop->id);
        $response->assertSessionHasErrors(['date']);
    }

    /** @test */
    public function 時間未入力で予約するとエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $this->actingAs($user);

        $response = $this->from('/detail/' . $shop->id)
            ->post('/reserve/' . $shop->id, [
                'shop_id' => $shop->id,
                'date' => '2025-06-20',
                'time' => '',
                'guest_count' => 2,
            ]);

        $response->assertRedirect('/detail/' . $shop->id);
        $response->assertSessionHasErrors(['time']);
    }

    /** @test */
    public function 人数未入力で予約するとエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $this->actingAs($user);

        $response = $this->from('/detail/' . $shop->id)
            ->post('/reserve/' . $shop->id, [
                'shop_id' => $shop->id,
                'date' => '2025-06-20',
                'time' => '18:00',
                'guest_count' => '',
            ]);

        $response->assertRedirect('/detail/' . $shop->id);
        $response->assertSessionHasErrors(['guest_count']);
    }

    /** @test */
    public function 正常な入力で予約が保存され支払いページにリダイレクトされる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $this->actingAs($user);
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        $postData = [
            'shop_id' => $shop->id,
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '18:00',
            'guest_count' => 3,
        ];

        $response = $this->withSession([
            'temp_reservation' => $postData
        ])->post('/reserve/' . $shop->id, $postData);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'guest_count' => 3,
            'reservation_datetime' => $postData['date'] . ' ' . $postData['time'],
        ]);

        $reservation = Reservation::latest()->first();
        $response->assertRedirect(route('amount', ['reservation' => $reservation->id]));
    }

    /** @test */
    public function 利用済の予約があるユーザーはレビューを投稿できる()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'used_at' => now(),
        ]);

        $this->actingAs($user);
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        $postData = [
            'comment' => 'とても良いお店でした！',
            'rating' => 5,
        ];

        $response = $this->post('/shops/' . $shop->id . '/review', $postData);

        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'comment' => 'とても良いお店でした！',
            'rating' => 5,
        ]);

        $response->assertSessionHas('success', 'コメントと評価を投稿しました！');
    }

    /** @test */
    public function stripe決済後にdoneページが表示される()
    {
        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/done/' . $shop->id);

        $response->assertStatus(200);
        $response->assertSee('ご予約ありがとうございます');
    }
}
