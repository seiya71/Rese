<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function トップページにサンプル店が表示されること()
    {
        Shop::factory()->create(['shop_name' => 'サンプル店1']);
        Shop::factory()->create(['shop_name' => 'サンプル店2']);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('サンプル店1');
        $response->assertSee('サンプル店2');
    }

    /** @test */
    public function 店名の部分一致検索ができること()
    {
        Shop::factory()->create(['shop_name' => 'サンプル店1']);
        Shop::factory()->create(['shop_name' => 'サンプル店2']);
        Shop::factory()->create(['shop_name' => 'テスト店']);

        $response = $this->get('/search?keyword=サンプル');

        $response->assertStatus(200);

        $response->assertSee('サンプル店1');
        $response->assertSee('サンプル店2');

        $response->assertDontSee('テスト店');
    }

    /** @test */
    public function エリア検索で該当する店舗のみが表示されること()
    {
        $tokyo = Area::factory()->create(['area_name' => '東京都']);
        $fukuoka = Area::factory()->create(['area_name' => '福岡県']);

        Shop::factory()->create([
            'shop_name' => '福岡店',
            'area_id' => $fukuoka->id,
        ]);

        Shop::factory()->create([
            'shop_name' => '東京店',
            'area_id' => $tokyo->id,
        ]);

        $response = $this->get('/search?area=' . $fukuoka->id);

        $response->assertStatus(200);
        $response->assertSee('福岡店');
        $response->assertDontSee('東京店');
    }

    /** @test */
    public function ジャンル検索で該当する店舗のみが表示されること()
    {
        $sushi = Genre::factory()->create(['genre_name' => '寿司']);
        $ramen = Genre::factory()->create(['genre_name' => 'ラーメン']);

        Shop::factory()->create([
            'shop_name' => '弥助寿司',
            'genre_id' => $sushi->id,
        ]);

        Shop::factory()->create([
            'shop_name' => '浜家',
            'genre_id' => $ramen->id,
        ]);

        $response = $this->get('/search?area=' . $sushi->id);

        $response->assertStatus(200);
        $response->assertSee('弥助寿司');
        $response->assertDontSee('浜家');
    }

    /** @test */
    public function test_ログインユーザーがお気に入り登録と解除をトグルできること()
    {
        $this->withoutMiddleware([
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $user = User::factory()->create();
        $shop = Shop::factory()->create();

        $response = $this->actingAs($user)->post('/togglelike/' . $shop->id);
        $response->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);

        $response = $this->actingAs($user)->post('/togglelike/' . $shop->id);
        $response->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'shop_id' => $shop->id,
        ]);
    }
}
