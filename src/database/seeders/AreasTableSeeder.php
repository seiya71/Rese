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
            ['area_name' => '東京'],
            ['area_name' => '千葉'],
            ['area_name' => '埼玉'],
            ['area_name' => '神奈川'],
            ['area_name' => '茨城'],
            ['area_name' => '群馬'],
        ];

        DB::table('areas')->insert($areas);
    }
}
