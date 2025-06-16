<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Shop;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeMail;
use Illuminate\Support\Facades\Artisan;
use App\Mail\ReservationReminderMail;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 店舗作成画面で必要な情報がセッション画像とともに保存できる()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $fakeImagePath = 'shop_images/test.jpg';

        Storage::fake('public');
        Storage::disk('public')->put($fakeImagePath, 'dummy content');

        $user = User::factory()->create(['role' => 'owner']);
        $area = Area::factory()->create();
        $genre = Genre::factory()->create();

        $this->actingAs($user)
            ->withSession(['shop_image' => $fakeImagePath]);

        $response = $this->post(route('shopCreate'), [
            'shop_name' => 'テスト店舗',
            'area' => $area->id,
            'genre' => $genre->id,
            'introduction' => 'これはセッション画像を使ったテストです。',
            'shop_image' => $fakeImagePath,
        ]);

        $response->assertRedirect(route('owner'));

        $this->assertDatabaseHas('shops', [
            'shop_name' => 'テスト店舗',
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'introduction' => 'これはセッション画像を使ったテストです。',
            'shop_image' => $fakeImagePath,
            'user_id' => $user->id,
        ]);

        Storage::disk('public')->assertExists($fakeImagePath);
    }

    /** @test */
    public function 画像アップロード後にファイルとセッションが正しく保存される()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        Storage::fake('public');

        $user = User::factory()->create(['role' => 'owner']);
        $file = UploadedFile::fake()->image('sample.jpg');
        $filename = $file->hashName();
        $path = 'images/shop_images/' . $filename;

        $this->actingAs($user);

        $response = $this->post(route('uploadShopImage'), [
            'shop_image' => $file,
        ]);

        $response->assertRedirect();

        $this->assertEquals($filename, session('shop_image'));

        Storage::disk('public')->assertExists($path);
    }

    /** @test */
    public function 店舗代表者がセッションにある予約状況を確認できる()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        $user = User::factory()->create(['role' => 'owner']);
        $shop = Shop::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->withSession([
                'temp_reservation' => [
                    'date' => '2025-06-20',
                    'time' => '18:00',
                    'guest_count' => 3,
                ],
            ]);

        $response = $this->get(route('shopAdmin', ['shopId' => $shop->id]));

        $response->assertStatus(200);

        $response->assertSee('2025-06-20');
        $response->assertSee('18:00');
        $response->assertSee('3人');
    }

    /** @test */
    public function お知らせメールを送信できる()
    {
        $this->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

        Mail::fake();

        $sender = User::factory()->create(['role' => 'owner']);
        $recipient = User::factory()->create();

        $this->actingAs($sender);

        $messageContent = 'これはテスト用のお知らせです。';

        $response = $this->post('/shopAdmin/notice', [
            'user_id' => $recipient->id,
            'message' => $messageContent,
        ]);

        Mail::assertSent(NoticeMail::class, function ($mail) use ($messageContent, $recipient) {
            return $mail->hasTo($recipient->email)
                && $mail->messageBody === $messageContent;
        });

        $response->assertRedirect();
        $response->assertSessionHas('status', 'メールを送信しました！');
    }

    public function リマインダーメールが送信される()
    {
        Mail::fake();

        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
            'shop_id' => $shop->id,
            'reservation_datetime' => now()->startOfDay()->addHours(12),
        ]);


        Artisan::call('reminder:send-reservations');

        Mail::assertSent(ReservationReminderMail::class, function ($mail) use ($reservation) {
            return $mail->reservation->id === $reservation->id
                && $mail->hasTo($reservation->user->email);
        });
    }

    public function リマインダーコマンドが8時にスケジュールされていること()
    {
        $events = collect(app(\Illuminate\Console\Scheduling\Schedule::class)->events());

        $matched = $events->contains(function ($event) {
            return str_contains($event->command ?? '', 'reminder:send-reservations')
                && $event->expression === '0 8 * * *';
        });

        $this->assertTrue($matched, 'リマインダーコマンドが8時にスケジュールされていません。');
    }

}
