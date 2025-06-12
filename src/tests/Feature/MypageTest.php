<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;

class MypageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function マイページにユーザーの名前が表示されている。(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    /** @test */
    public function マイページにお気に入り店舗が表示されている。(): void
    {
        $user = User::factory()->create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $shop = Shop::create([
            'shop_name' => 'サンプル店',
            'shop_image' => 'sample.jpg',
            'introduction' => 'サンプルテキスト',
            'area_id' => 1,
            'genre_id' => 1,
            'user_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }
}
