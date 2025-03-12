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
                'area' => '東京',
                'genre' => 'イタリアン',
                'introduction' => '本格的なイタリアンが楽しめるお店。',
            ],
            [
                'shop_name' => 'カフェ B',
                'area' => '大阪',
                'genre' => 'カフェ',
                'introduction' => 'おしゃれなカフェでくつろぎの時間を。',
            ],
            [
                'shop_name' => '寿司 C',
                'area' => '北海道',
                'genre' => '寿司',
                'introduction' => '新鮮なネタを提供する寿司屋。',
            ],
            [
                'shop_name' => '焼肉 D',
                'area' => '福岡',
                'genre' => '焼肉',
                'introduction' => '最高級の和牛を楽しめる焼肉店。',
            ],
            [
                'shop_name' => 'ラーメン E',
                'area' => '京都',
                'genre' => 'ラーメン',
                'introduction' => 'こだわりのスープが自慢のラーメン店。',
            ],
            [
                'shop_name' => '中華 F',
                'area' => '神戸',
                'genre' => '中華',
                'introduction' => '本場の味を楽しめる中華料理店。',
            ],
            [
                'shop_name' => 'バー G',
                'area' => '名古屋',
                'genre' => 'バー',
                'introduction' => '落ち着いた雰囲気でお酒を楽しめるバー。',
            ],
            [
                'shop_name' => 'フレンチ H',
                'area' => '横浜',
                'genre' => 'フレンチ',
                'introduction' => '高級感あふれるフレンチレストラン。',
            ],
        ];

        DB::table('shops')->insert($shops);
    }
}
