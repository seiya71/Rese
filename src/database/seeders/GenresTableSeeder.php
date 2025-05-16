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
            ['genre_name' => '寿司'],
            ['genre_name' => '焼肉'],
            ['genre_name' => '居酒屋'],
            ['genre_name' => 'イタリアン'],
            ['genre_name' => 'ラーメン'],
        ];

        DB::table('genres')->insert($genres);
    }
}
