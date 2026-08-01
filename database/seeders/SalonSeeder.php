<?php

namespace Database\Seeders;

use App\Models\Salon;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barber = User::where('email', 'ali@barberbook.test')->first();

        Salon::create([
            'user_id' => $barber->id,
            'name' => 'آرایشگاه آلیجناب',
            'slug' => 'alijenab-test',
            'qr_token' => 'BB-TEST123',
            'phone' => '09121234567',
            'address' => 'قزوین، خیابان خیام',
            'instagram' => 'alijenab.barber',
            'description' => 'سالن تخصصی اصلاح و استایل مردانه',
        ]);
    }
}
