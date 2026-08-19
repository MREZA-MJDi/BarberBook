<?php

namespace App\Http\Controllers;

use App\Http\Requests\PublicBooking\StorePublicBookingRequest;
use App\Models\Booking;
use App\Models\Salon;
use App\Models\Service;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Morilog\Jalali\Jalalian;

class PublicBookingController extends Controller
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
    | Create
    |--------------------------------------------------------------------------
    */

    /**
     * Show public booking page.
     *
     * Customer reaches this flow through the salon QR code.
     */
    public function create(
        string $qr_token
    ): View {

        /*
        |--------------------------------------------------------------------------
        | Salon
        |--------------------------------------------------------------------------
        */

        $salon = Salon::query()
            ->where('qr_token', $qr_token)
            ->where('is_active', true)
            ->with([
                'services' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->orderBy('name');
                },
            ])
            ->firstOrFail();

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
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'salon.booking',
            [
                'salon' =>
                    $salon,

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
    | Store
    |--------------------------------------------------------------------------
    */

    /**
     * Store customer booking.
     */
    public function store(
        StorePublicBookingRequest $request,
        string $qr_token
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Salon
        |--------------------------------------------------------------------------
        */

        $salon = Salon::query()
            ->where('qr_token', $qr_token)
            ->where('is_active', true)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Validated Data
        |--------------------------------------------------------------------------
        */

        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Service
        |--------------------------------------------------------------------------
        |
        | The service must belong to this salon.
        |
        */

        $service = Service::query()
            ->where('id', $validated['service_id'])
            ->where('salon_id', $salon->id)
            ->where('is_active', true)
            ->first();

        if (!$service) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'خدمت انتخاب‌شده معتبر نیست.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Booking Date
        |--------------------------------------------------------------------------
        */

        $bookingDate = $this->parseBookingDate(
            $validated['booking_date']
        );

        if (!$bookingDate) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'تاریخ انتخاب‌شده معتبر نیست.'
                );
        }

        $bookingDate = $bookingDate
            ->copy()
            ->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Prevent Past Date
        |--------------------------------------------------------------------------
        */

        if ($bookingDate->lt(Carbon::today())) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'امکان ثبت رزرو برای تاریخ گذشته وجود ندارد.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize Time
        |--------------------------------------------------------------------------
        */

        $bookingTime = trim(
            $validated['booking_time']
        );

        /*
        |--------------------------------------------------------------------------
        | Availability
        |--------------------------------------------------------------------------
        */

        $isAvailable =
            $this->availabilityService->isAvailable(
                $salon->id,
                $bookingDate,
                $bookingTime,
                $service->duration
            );

        if (!$isAvailable) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'زمان انتخاب‌شده دیگر قابل رزرو نیست. لطفاً زمان دیگری انتخاب کنید.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Booking
        |--------------------------------------------------------------------------
        */

        $booking = Booking::create([

            'salon_id' =>
                $salon->id,

            'service_id' =>
                $service->id,

            'customer_name' =>
                $validated['customer_name'],

            'customer_phone' =>
                $validated['customer_phone'],

            'booking_date' =>
                $bookingDate->format('Y-m-d'),

            'booking_time' =>
                $bookingTime,

            'customer_note' =>
                $validated['customer_note'] ?? null,

            'final_price' =>
                $service->price,

            'duration_minutes' =>
                $service->duration,

            /*
            |--------------------------------------------------------------------------
            | Public Booking
            |--------------------------------------------------------------------------
            |
            | Customer bookings always start as pending.
            |
            */

            'status' =>
                'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'salon.booking.success',
                [
                    'qr_token' =>
                        $salon->qr_token,

                    'booking' =>
                        $booking->reference_code,
                ]
            )
            ->with(
                'success',
                'درخواست نوبت شما با موفقیت ثبت شد.'
            );
    }
    /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */

    /**
     * Show successful booking page.
     */
    public function success(
        string $qr_token,
        string $booking
    ): View {

        $salon = Salon::query()
            ->where('qr_token', $qr_token)
            ->where('is_active', true)
            ->firstOrFail();

        $bookingModel = Booking::query()
            ->where('reference_code', $booking)
            ->where('salon_id', $salon->id)
            ->with('service')
            ->firstOrFail();

        return view(
            'salon.booking-success',
            [
                'salon' => $salon,
                'booking' => $bookingModel,
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
