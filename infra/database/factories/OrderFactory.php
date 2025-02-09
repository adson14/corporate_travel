<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'destiny' => fake()->city(),
            'departure_date' => fake()->date(),
            'return_date' => fake()->date(),
            'status_order' => 'PENDING',
        ];
    }

    public function withdestiny($destiny)
    {
        return $this->state(function (array $attributes) use ($destiny) {
            return [
                'destiny' => $destiny,
            ];
        });
    }
}
