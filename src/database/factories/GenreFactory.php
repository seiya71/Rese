<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $genres = ['寿司', '焼肉', '居酒屋', 'イタリアン', 'ラーメン'];
        return [
            'genre_name' => $this->faker->randomElement($genres),
        ];
    }
}
