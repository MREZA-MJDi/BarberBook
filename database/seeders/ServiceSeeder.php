<?php

namespace Database\Seeders;

use App\Models\Salon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salon = Salon::first();

        $services = [
            [
                'name' => 'اصلاح مو',
                'description' => 'اصلاح حرفه‌ای مو',
                'duration' => 45,
                'price' => 250000,
            ],
            [
                'name' => 'اصلاح ریش',
                'description' => 'فرم‌دهی و اصلاح ریش',
                'duration' => 20,
                'price' => 150000,
            ],
            [
                'name' => 'اصلاح مو + ریش',
                'description' => 'پکیج کامل',
                'duration' => 60,
                'price' => 350000,
            ],
            [
                'name' => 'فیشیال',
                'description' => 'پاکسازی پوست',
                'duration' => 40,
                'price' => 300000,
            ],
        ];

        foreach ($services as $service) {
            $salon->services()->create($service);
        }
    }
}
