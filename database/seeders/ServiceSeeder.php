<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Cuci Sepatu Basic',
                'description' => 'Cuci sepatu standar dengan pembersihan menyeluruh',
                'price' => 25000,
                'duration_minutes' => 60,
                'is_active' => true,
            ],
            [
                'name' => 'Cuci Sepatu Premium',
                'description' => 'Cuci sepatu dengan treatment khusus dan conditioning',
                'price' => 45000,
                'duration_minutes' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Deep Cleaning',
                'description' => 'Pembersihan mendalam untuk sepatu yang sangat kotor',
                'price' => 60000,
                'duration_minutes' => 120,
                'is_active' => true,
            ],
            [
                'name' => 'Repaint & Restore',
                'description' => 'Pengecatan ulang dan restorasi sepatu',
                'price' => 100000,
                'duration_minutes' => 180,
                'is_active' => true,
            ],
            [
                'name' => 'Waterproof Treatment',
                'description' => 'Treatment anti air untuk sepatu',
                'price' => 35000,
                'duration_minutes' => 45,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}