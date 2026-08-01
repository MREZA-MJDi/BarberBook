<?php

namespace Database\Seeders;

use App\Models\Salon;
use Illuminate\Database\Seeder;

class WorkingHourSeeder extends Seeder
{
    public function run(): void
    {
        $salon = Salon::first();

        $days = [

            [
                'day_of_week' => 0,
                'start_time' => '09:00',
                'end_time' => '20:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
            ],

            [
                'day_of_week' => 1,
                'start_time' => '09:00',
                'end_time' => '20:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
            ],

            [
                'day_of_week' => 2,
                'is_closed' => true,
            ],

            [
                'day_of_week' => 3,
                'start_time' => '09:00',
                'end_time' => '20:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
            ],

            [
                'day_of_week' => 4,
                'start_time' => '09:00',
                'end_time' => '20:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
            ],

            [
                'day_of_week' => 5,
                'start_time' => '09:00',
                'end_time' => '20:00',
                'break_start' => '13:00',
                'break_end' => '14:00',
            ],

            [
                'day_of_week' => 6,
                'start_time' => '10:00',
                'end_time' => '18:00',
            ],
        ];

        foreach ($days as $day) {
            $salon->workingHours()->create($day);
        }
    }
}
