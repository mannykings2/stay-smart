<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DriverService;

class DriverServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Airport Transfer',
            'City Tour',
            'Intercity Travel',
            'Hourly Rental',
            'Wedding Service',
            'Corporate Transport',
            'Event Transportation',
            'Long Distance Travel'
        ];

        foreach ($services as $service) {
            DriverService::create([
                'name' => $service
            ]);
        }
    }
}