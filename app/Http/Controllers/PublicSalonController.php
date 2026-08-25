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
     * Display the public salon page.
     *
     * This page is the main customer-facing page reached
     * through the salon QR code.
     */
    public function show(
        string $qr_token
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Find Active Salon
        |--------------------------------------------------------------------------
        */

        $salon = Salon::query()
            ->where('qr_token', $qr_token)
            ->where('is_active', true)
            ->with([

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
                */

                'galleryItems' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('sort_order')
                        ->orderBy('id');
                },

            ])
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Published Reviews
        |--------------------------------------------------------------------------
        */

        $reviews = $salon->reviews()
            ->where('status', 'published')
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

        $reviewsCount = $reviews->count();

        $averageRating = $reviewsCount > 0
            ? round($reviews->avg('rating'), 1)
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Selected Date
        |--------------------------------------------------------------------------
        */

        $requestedDate = request('date');

        $selectedDate = $requestedDate
            ? $this->parseBookingDate($requestedDate)
            : Carbon::today();

        if (!$selectedDate) {
            $selectedDate = Carbon::today();
        }

        $selectedDate = $selectedDate
            ->copy()
            ->startOfDay();


        /*
        |--------------------------------------------------------------------------
        | Jalali Date For UI
        |--------------------------------------------------------------------------
        */

        $jalaliDate = Jalalian::fromCarbon(
            $selectedDate
        )->format('Y/m/d');


        /*
        |--------------------------------------------------------------------------
        | Selected Service
        |--------------------------------------------------------------------------
        */

        $selectedService = null;

        if (request()->filled('service_id')) {

            $selectedService = $salon->services->firstWhere(
                'id',
                (int) request('service_id')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Selected Time
        |--------------------------------------------------------------------------
        */

        $selectedTime = request('booking_time');


        /*
        |--------------------------------------------------------------------------
        | Available Slots
        |--------------------------------------------------------------------------
        */

        $availableSlots = [];

        if ($selectedService) {

            $availableSlots =
                $this->availabilityService->getAvailableSlots(
                    $salon->id,
                    $selectedDate,
                    $selectedService->duration
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Gallery Items
        |--------------------------------------------------------------------------
        */

        $galleryItems = $salon->galleryItems;


        /*
        |--------------------------------------------------------------------------
        | Return Public Salon Page
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
    | Helpers
    |--------------------------------------------------------------------------
    */

    /**
     * Parse booking date.
     *
     * Supports:
     *
     * Jalali:
     * 1405/05/25
     * 1405-05-25
     *
     * Gregorian:
     * 2026/08/16
     * 2026-08-16
     */
    private function parseBookingDate(
        ?string $date
    ): ?Carbon {

        if (!$date) {
            return null;
        }

        $date = trim($date);

        if ($date === '') {
            return null;
        }

        $normalized = str_replace(
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

                [$year] = explode(
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
            )->startOfDay();

        } catch (\Throwable) {

            return null;
        }
    }
}
