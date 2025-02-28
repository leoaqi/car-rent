<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            'Bus',
            'Truck',
            'City Car',
            'Mini Bus',
            'Hiace',
            'Elf Short',
            'Elf Medium',
        ];

        foreach ($brands as $brand) {
            Category::factory()->create(['name' => $brand]);
        }
    }
}
