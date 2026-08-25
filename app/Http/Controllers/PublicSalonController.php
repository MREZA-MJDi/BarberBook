<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\View\View;
use Morilog\Jalali\Jalalian;

class PublicSalonController extends Controller
{
    /**
     * Booking availability service.
     */
    public function __construct(
        protected BookingAvailabilityService $availabilityService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Show Public Salon
    |--------------------------------------------------------------------------
    */

    /**
     * Display public salon page.
     *
     * The salon is resolved automatically from its slug.
     */
    public function show(
        Salon $salon
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Active Salon
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $salon->is_active,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Load Public Data
        |--------------------------------------------------------------------------
        */

        $salon->load([
            /*
            |--------------------------------------------------------------------------
            | Active Services
            |--------------------------------------------------------------------------
            */

            'services' => function ($query) {

                $query
                    ->where('is_active', true)
                    ->orderBy('name');

            },


            /*
            |--------------------------------------------------------------------------
            | Active Gallery
            |--------------------------------------------------------------------------
            |
            | Only complete Before / After items.
            |
            */

            'galleryItems' => function ($query) {

                $query
                    ->where('is_active', true)
                    ->whereNotNull('before_image')
                    ->whereNotNull('after_image')
                    ->orderBy('sort_order')
                    ->orderBy('id');

            },

        ]);


        /*
        |--------------------------------------------------------------------------
        | Published Reviews
        |--------------------------------------------------------------------------
        */

        $reviews = $salon
            ->reviews()
            ->where(
                'status',
                'published'
            )
            ->with([
                'user',
                'booking.service',
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Review Statistics
        |--------------------------------------------------------------------------
        */

        $reviewsCount =
            $reviews->count();

        $averageRating =
            $reviewsCount > 0
                ? round(
                (float) $reviews->avg('rating'),
                1
            )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Selected Date
        |--------------------------------------------------------------------------
        */

        $requestedDate =
            request('date');

        $selectedDate =
            $requestedDate
                ? $this->parseBookingDate(
                $requestedDate
            )
                : Carbon::today();


        if (!$selectedDate) {

            $selectedDate =
                Carbon::today();
        }


        $selectedDate =
            $selectedDate
                ->copy()
                ->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | Jalali Date
        |--------------------------------------------------------------------------
        */

        $jalaliDate =
            Jalalian::fromCarbon(
                $selectedDate
            )->format('Y/m/d');


        /*
        |--------------------------------------------------------------------------
        | Selected Service
        |--------------------------------------------------------------------------
        */

        $selectedService = null;


        if (
            request()->filled(
                'service_id'
            )
        ) {

            $selectedService =
                $salon->services->firstWhere(
                    'id',
                    (int) request(
                        'service_id'
                    )
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Selected Time
        |--------------------------------------------------------------------------
        */

        $selectedTime =
            request(
                'booking_time'
            );


        /*
        |--------------------------------------------------------------------------
        | Available Slots
        |--------------------------------------------------------------------------
        */

        $availableSlots = [];


        if ($selectedService) {

            $availableSlots =
                $this->availabilityService
                    ->getAvailableSlots(
                        $salon->id,
                        $selectedDate,
                        $selectedService->duration
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        $galleryItems =
            $salon->galleryItems;


        /*
        |--------------------------------------------------------------------------
        | Public Salon Page
        |--------------------------------------------------------------------------
        */

        return view(
            'salon.show',
            [
                'salon' =>
                    $salon,

                'reviews' =>
                    $reviews,

                'reviewsCount' =>
                    $reviewsCount,

                'averageRating' =>
                    $averageRating,

                'galleryItems' =>
                    $galleryItems,

                'selectedDate' =>
                    $selectedDate,

                'jalaliDate' =>
                    $jalaliDate,

                'selectedService' =>
                    $selectedService,

                'availableSlots' =>
                    $availableSlots,

                'selectedTime' =>
                    $selectedTime,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Date Parser
    |--------------------------------------------------------------------------
    */

    /**
     * Parse Jalali or Gregorian date.
     */
    private function parseBookingDate(
        ?string $date
    ): ?Carbon {

        if (!$date) {
            return null;
        }


        $date =
            trim($date);


        if ($date === '') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Normalize
        |--------------------------------------------------------------------------
        */

        $normalized =
            str_replace(
                '-',
                '/',
                $date
            );


        /*
        |--------------------------------------------------------------------------
        | Jalali
        |--------------------------------------------------------------------------
        */

        try {

            if (
                preg_match(
                    '/^\d{4}\/\d{1,2}\/\d{1,2}$/',
                    $normalized
                )
            ) {

                [$year] =
                    explode(
                        '/',
                        $normalized
                    );


                if (
                    (int) $year >= 1200 &&
                    (int) $year <= 1500
                ) {

                    return Jalalian::fromFormat(
                        'Y/m/d',
                        $normalized
                    )
                        ->toCarbon()
                        ->startOfDay();
                }
            }

        } catch (\Throwable) {

            // Continue with Gregorian parser.

        }


        /*
        |--------------------------------------------------------------------------
        | Gregorian
        |--------------------------------------------------------------------------
        */

        try {

            return Carbon::createFromFormat(
                'Y/m/d',
                $normalized
            )
                ->startOfDay();

        } catch (\Throwable) {

            return null;
        }
    }
}
