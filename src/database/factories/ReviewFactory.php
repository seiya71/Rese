<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Shop;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = ['また行きたい！', 'とてもおいしい！', 'お値段が良心的！'];

        return [
            'user_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->randomElement($comments),
        ];
    }
}
