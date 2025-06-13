<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Shop;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reservation_datetime' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
            'guest_count' => $this->faker->numberBetween(1, 5),
            'user_id' => User::factory(),
            'shop_id' => Shop::factory(),
            'used_at' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d H:i:s'),
        ];
    }
}
