<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Verified;
use App\Models\User;
use Illuminate\Support\Facades\Event;

class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_認証リンクをクリックするとサンクスページへリダイレクトされる()
    {
        Event::fake();

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $verifyUrl = URL::temporarySignedRoute(
            'verification.verify', // これはルート名（web.php で確認）
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verifyUrl);

        $response->assertRedirect('/thanks'); // ← 認証後のリダイレクト先（必要に応じて変更）

        $this->assertNotNull($user->fresh()->email_verified_at);

        Event::assertDispatched(Verified::class);
    }
}
