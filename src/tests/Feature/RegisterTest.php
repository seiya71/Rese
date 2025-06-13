<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 名前が未入力の場合はエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
        $errors = session('errors');
        $this->assertEquals('お名前を入力してください', $errors->first('name'));
    }

    /** @test */
    public function メールアドレスが未入力の場合はエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $errors = session('errors');
        $this->assertEquals('メールアドレスを入力してください', $errors->first('email'));
    }

    /** @test */
    public function パスワードが未入力の場合はエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
        $errors = session('errors');
        $this->assertEquals('パスワードを入力してください', $errors->first('password'));
    }

    /** @test */
    public function パスワードが7文字以下の場合はエラーメッセージが表示される()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'pass123',
            'password_confirmation' => 'pass123',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください',
        ]);
    }

    /** @test */
    public function 正常に登録できるとメール確認画面へ遷移する()
    {
        Event::fake();
        
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'test',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/email/verify');

        Event::assertDispatched(Registered::class);
    }
}
