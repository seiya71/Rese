<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            ['genre_name' => 'レストラン'],
            ['genre_name' => 'ラーメン'],
            ['genre_name' => 'フレンチ'],
            ['genre_name' => '中華'],
            ['genre_name' => 'イタリアン'],
            ['genre_name' => 'フレンチ'],
        ];

        DB::table('genres')->insert($genres);
    }
}
