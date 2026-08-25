<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Find Salon
        |--------------------------------------------------------------------------
        */

        $salon = Salon::query()->first();

        if (! $salon) {
            $this->command->warn('No salon found. ReviewSeeder skipped.');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Users
        |--------------------------------------------------------------------------
        */

        $users = User::query()
            ->orderBy('id')
            ->take(5)
            ->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. ReviewSeeder skipped.');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Completed Bookings
        |--------------------------------------------------------------------------
        */

        $bookings = Booking::query()
            ->where('salon_id', $salon->id)
            ->where('status', 'completed')
            ->orderBy('id')
            ->take($users->count())
            ->get();

        if ($bookings->isEmpty()) {
            $this->command->warn(
                'No completed bookings found for salon. ReviewSeeder skipped.'
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Review Data
        |--------------------------------------------------------------------------
        */

        $reviews = [
            [
                'rating' => 5,
                'comment' => 'خیلی راضی بودم. کار تمیز و حرفه‌ای انجام شد و حتماً دوباره مراجعه می‌کنم.',
            ],
            [
                'rating' => 5,
                'comment' => 'برخورد عالی بود و نتیجه کار دقیقاً چیزی شد که می‌خواستم.',
            ],
            [
                'rating' => 4,
                'comment' => 'کیفیت کار خیلی خوب بود و از خدمات سالن رضایت داشتم.',
            ],
            [
                'rating' => 5,
                'comment' => 'محیط سالن عالی بود و خدمات هم خیلی با دقت انجام شد.',
            ],
            [
                'rating' => 4,
                'comment' => 'تجربه خوبی داشتم و از نتیجه نهایی راضی هستم.',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | Create Reviews
        |--------------------------------------------------------------------------
        */

        foreach ($bookings as $index => $booking) {

            $user = $users[$index % $users->count()];

            $reviewData = $reviews[$index % count($reviews)];

            Review::updateOrCreate(
                [
                    'booking_id' => $booking->id,
                ],
                [
                    'user_id' => $user->id,
                    'salon_id' => $salon->id,
                    'rating' => $reviewData['rating'],
                    'comment' => $reviewData['comment'],
                    'status' => 'approved',
                ]
            );
        }


        $this->command->info(
            "Review seeding completed for salon: {$salon->name}"
        );
    }
}
