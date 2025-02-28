<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Container\Attributes\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Honda',
            'Hyundai',
            'Toyota',
            'Suzuki',
            'Kia',
            'Nissan',
            'Wuling',
            'Hino',
            'Mercedes',
        ];

        foreach ($brands as $brand) {
            Brand::factory()->create(['name' => $brand]);
        }
    }
}
