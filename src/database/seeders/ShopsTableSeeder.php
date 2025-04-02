<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = [
            [
                'shop_name' => 'レストラン A',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '本格的なイタリアンが楽しめるお店。',
            ],
            [
                'shop_name' => 'カフェ B',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => 'おしゃれなカフェでくつろぎの時間を。',
            ],
            [
                'shop_name' => '寿司 C',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '新鮮なネタを提供する寿司屋。',
            ],
            [
                'shop_name' => '焼肉 D',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '最高級の和牛を楽しめる焼肉店。',
            ],
            [
                'shop_name' => 'ラーメン E',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => 'こだわりのスープが自慢のラーメン店。',
            ],
            [
                'shop_name' => '中華 F',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '本場の味を楽しめる中華料理店。',
            ],
            [
                'shop_name' => 'バー G',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '落ち着いた雰囲気でお酒を楽しめるバー。',
            ],
            [
                'shop_name' => 'フレンチ H',
                'shop_image' => 'sample.png',
                'area_id' => rand(1, 6),
                'genre_id' => rand(1, 6),
                'introduction' => '高級感あふれるフレンチレストラン。',
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('shops')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('shops')->insert($shops);
    }
}
