<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RentFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+2 months');

        return [
            'user_id' => User::factory(),
            'car_id' => Car::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $this->faker->numberBetween(500000, 5000000),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'completed']),
            'payment_status' => $this->faker->randomElement(['unpaid', 'paid']),
            'notes' => $this->faker->optional()->text(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}
