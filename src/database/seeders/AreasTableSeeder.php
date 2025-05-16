<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['area_name' => '東京都'],
            ['area_name' => '大阪府'],
            ['area_name' => '福岡県'],
        ];

        DB::table('areas')->insert($areas);
    }
}
