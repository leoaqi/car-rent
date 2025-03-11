<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Rent;
use Illuminate\Database\Seeder;

class RentSeeder extends Seeder
{
    public function run(): void
    {
        $cars = Car::all();
        
        foreach ($cars as $car) {
            $numberOfRents = rand(2, 5);
            
            for ($i = 0; $i < $numberOfRents; $i++) {
                $startDate = fake()->dateTimeBetween('-1 month', '+2 months');
                $endDate = fake()->dateTimeBetween($startDate, '+3 months');
                
                Rent::create([
                    'car_id' => $car->id,
                    'name' => fake()->name(),
                    'phone' => fake()->phoneNumber(),
                    'type' => fake()->randomElement(['automatic', 'manual', 'with-driver']),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'price' => fake()->numberBetween(300000, 1000000),
                    'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'completed']),
                    'location_pickup' => fake()->address(),
                    'location_delivery' => fake()->address(),
                    'payment_status' => fake()->randomElement(['unpaid', 'paid', 'partial']),
                ]);
            }
        }
    }
}
