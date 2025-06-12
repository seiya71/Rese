<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Area;
use App\Models\Genre;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'shop_name' => $this->faker->company . '店',
            'shop_image' => 'sample.jpg',
            'introduction' => $this->faker->sentence(10),
            'area_id' => Area::factory(),
            'genre_id' => Genre::factory(),
            'user_id' => User::factory(),
        ];
    }
}
