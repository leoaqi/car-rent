<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all tour package IDs
        $tourPackageIds = TourPackage::pluck('id')->toArray();
        
        if (empty($tourPackageIds)) {
            $this->command->info('No tour packages found. Please run TourPackageSeeder first.');
            return;
        }

        $statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'partial', 'paid', 'refunded'];
        
        // Create 20 sample bookings
        for ($i = 0; $i < 20; $i++) {
            $bookingDate = Carbon::now()->subDays(rand(1, 30));
            $travelDate = Carbon::now()->addDays(rand(10, 90));
            
            Booking::create([
                'customer_name' => 'Customer ' . ($i + 1),
                'customer_email' => 'customer' . ($i + 1) . '@example.com',
                'customer_phone' => '08' . rand(10000000, 99999999),
                'booking_date' => $bookingDate,
                'travel_date' => $travelDate,
                'number_of_travelers' => rand(1, 5),
                'total_amount' => rand(1000000, 10000000),
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'booking_status' => $statuses[array_rand($statuses)],
                'special_requests' => rand(0, 1) ? 'Special request for booking ' . ($i + 1) : null,
                'package_id' => $tourPackageIds[array_rand($tourPackageIds)],
            ]);
        }
    }
}
