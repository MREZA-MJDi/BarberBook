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
    public function __construct(
        protected BookingAvailabilityService $availabilityService
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    public function create(
        Salon $salon
    ): View {
        $salon->load([
            'services' => function ($query) {
                $query
                    ->where('is_active', true)
                    ->orderBy('name');
            },
        ]);

        abort_unless($salon->is_active, 404);

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
        | Jalali Date
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
            $availableSlots = $this->availabilityService->getAvailableSlots(
                $salon->id,
                $selectedDate,
                $selectedService->duration
            );
        }

        return view(
            'salon.booking',
            [
                'salon' => $salon,
                'selectedDate' => $selectedDate,
                'jalaliDate' => $jalaliDate,
                'selectedService' => $selectedService,
                'availableSlots' => $availableSlots,
                'selectedTime' => $selectedTime,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */

    public function store(
        StorePublicBookingRequest $request,
        Salon $salon
    ): RedirectResponse {
        abort_unless($salon->is_active, 404);

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

        $isAvailable = $this->availabilityService->isAvailable(
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
            'salon_id' => $salon->id,
            'service_id' => $service->id,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'booking_date' => $bookingDate->format('Y-m-d'),
            'booking_time' => $bookingTime,
            'customer_note' => $validated['customer_note'] ?? null,
            'final_price' => $service->price,
            'duration_minutes' => $service->duration,
            'status' => 'pending',
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
                    'salon' => $salon->slug,
                    'booking' => $booking->reference_code,
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

    public function success(
        Salon $salon,
        string $booking
    ): View {
        abort_unless($salon->is_active, 404);

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
