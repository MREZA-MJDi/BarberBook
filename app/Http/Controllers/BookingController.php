<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingActionRequest;
use App\Http\Requests\Booking\BookingFilterRequest;
use App\Http\Requests\Booking\RescheduleBookingRequest;
use App\Http\Requests\Booking\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Service;
use App\Services\BookingAvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Morilog\Jalali\Jalalian;

class BookingController extends Controller
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
    | Index
    |--------------------------------------------------------------------------
    */

    /**
     * Display bookings list.
     */
    public function index(
        BookingFilterRequest $request
    ): View {
        $salonId = auth()->user()->salon->id;

        $query = Booking::query()
            ->with('service')
            ->where('salon_id', $salonId);

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where(
                    'customer_name',
                    'like',
                    '%' . $search . '%'
                )
                    ->orWhere(
                        'customer_phone',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'reference_code',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        |
        | UI may send:
        |
        | 1405/05/25
        | 1405-05-25
        | 2026-08-11
        |
        */

        if ($request->filled('date')) {

            $date = $this->parseBookingDate(
                $request->date
            );

            if ($date) {

                $query->whereDate(
                    'booking_date',
                    $date->format('Y-m-d')
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        if ($request->sort === 'oldest') {

            $query->oldest();

        } else {

            $query->latest();
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $bookings = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.bookings.index',
            compact('bookings')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Create
    |--------------------------------------------------------------------------
    */

    /**
     * Show manual booking creation page.
     */
    public function create(
        Request $request
    ): View {
        $salonId = auth()->user()->salon->id;

        /*
        |--------------------------------------------------------------------------
        | Active Services
        |--------------------------------------------------------------------------
        */

        $services = Service::query()
            ->where('salon_id', $salonId)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Selected Date
        |--------------------------------------------------------------------------
        |
        | Canonical UI value:
        |
        | date=1405/05/25
        |
        | But we also accept Gregorian dates so old links
        | do not break.
        |
        */

        $requestedDate = $request->input('date');

        $selectedDate = $requestedDate
            ? $this->parseBookingDate($requestedDate)
            : Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Fallback
        |--------------------------------------------------------------------------
        */

        if (!$selectedDate) {

            $selectedDate = Carbon::today();
        }

        $selectedDate = $selectedDate->copy()->startOfDay();

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

        if ($request->filled('service_id')) {

            $selectedService = $services->firstWhere(
                'id',
                (int) $request->input('service_id')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Selected Time
        |--------------------------------------------------------------------------
        |
        | IMPORTANT:
        | Everything uses booking_time.
        |
        */

        $selectedTime = $request->input(
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
                $this->availabilityService->getAvailableSlots(
                    $salonId,
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
            'dashboard.bookings.create',
            [
                'services' => $services,

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

    /**
     * Store manual booking.
     *
     * Validation:
     * StoreBookingRequest
     *
     * Business rules:
     * Controller + Availability Service
     */
    public function store(
        StoreBookingRequest $request
    ): RedirectResponse {
        $salonId = auth()->user()->salon->id;

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
            ->where('salon_id', $salonId)
            ->where('is_active', true)
            ->first();

        if (!$service) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'سرویس انتخاب‌شده معتبر نیست.'
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
        | Availability Check
        |--------------------------------------------------------------------------
        */

        $isAvailable =
            $this->availabilityService->isAvailable(
                $salonId,
                $bookingDate,
                $bookingTime,
                $service->duration
            );

        if (!$isAvailable) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'زمان انتخاب‌شده دیگر قابل رزرو نیست.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create Booking
        |--------------------------------------------------------------------------
        */

        Booking::create([

            'salon_id' => $salonId,

            'service_id' => $service->id,

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
            | Manual Booking
            |--------------------------------------------------------------------------
            |
            | Barber creates the booking,
            | but it still starts as pending.
            |
            */

            'status' => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'رزرو با موفقیت ثبت شد و در انتظار تایید است.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    /**
     * Display booking details.
     */
    public function show(
        Booking $booking
    ): View {
        $this->authorizeBooking($booking);

        $booking->load('service');

        return view(
            'dashboard.bookings.show',
            compact('booking')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Approve
    |--------------------------------------------------------------------------
    */

    /**
     * Approve booking.
     */
    public function approve(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorizeBooking($booking);

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($booking->status !== 'pending') {

            return back()->with(
                'error',
                'این رزرو دیگر قابل تایید نیست.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Re-check Availability
        |--------------------------------------------------------------------------
        |
        | Ignore current booking itself.
        |
        */

        $isAvailable =
            $this->availabilityService->isAvailable(
                $booking->salon_id,
                Carbon::parse($booking->booking_date),
                $booking->booking_time,
                $booking->duration_minutes,
                $booking->id
            );

        if (!$isAvailable) {

            return back()->with(
                'error',
                'این زمان دیگر قابل تایید نیست یا توسط رزرو دیگری اشغال شده است.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Approve
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'status' => 'approved',

            'approved_at' => now(),

            'barber_note' =>
                $request->barber_note,
        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت تایید شد.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Reject
    |--------------------------------------------------------------------------
    */

    /**
     * Reject booking.
     */
    public function reject(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorizeBooking($booking);

        if ($booking->status !== 'pending') {

            return back()->with(
                'error',
                'این رزرو دیگر قابل رد کردن نیست.'
            );
        }

        $booking->update([

            'status' => 'rejected',

            'barber_note' =>
                $request->barber_note,
        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت رد شد.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Complete
    |--------------------------------------------------------------------------
    */

    /**
     * Complete booking.
     */
    public function complete(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorizeBooking($booking);

        if ($booking->status !== 'approved') {

            return back()->with(
                'error',
                'فقط رزرو تایید شده قابل تکمیل است.'
            );
        }

        $booking->update([

            'status' => 'completed',

            'completed_at' => now(),

            'barber_note' =>
                $request->barber_note,
        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت تکمیل شد.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule
    |--------------------------------------------------------------------------
    */

    /**
     * Reschedule booking.
     */
    public function reschedule(
        RescheduleBookingRequest $request,
        Booking $booking
    ): RedirectResponse {
        $this->authorizeBooking($booking);

        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($booking->status !== 'approved') {

            return back()->with(
                'error',
                'فقط رزرو تایید شده قابل جابه‌جایی است.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date
        |--------------------------------------------------------------------------
        */

        $bookingDate = $this->parseBookingDate(
            $request->booking_date
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
                    'امکان انتقال رزرو به تاریخ گذشته وجود ندارد.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Availability
        |--------------------------------------------------------------------------
        */

        $isAvailable =
            $this->availabilityService->isAvailable(
                $booking->salon_id,
                $bookingDate,
                $request->booking_time,
                $booking->duration_minutes,
                $booking->id
            );

        if (!$isAvailable) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'زمان انتخاب‌شده قابل رزرو نیست یا با یک رزرو دیگر تداخل دارد.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'booking_date' =>
                $bookingDate->format('Y-m-d'),

            'booking_time' =>
                $request->booking_time,

            'barber_note' =>
                $request->barber_note,
        ]);

        return back()->with(
            'success',
            'زمان رزرو با موفقیت تغییر کرد.'
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
     * Supported:
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
        string|null $date
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
        | Try Jalali
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

                /*
                | Jalali years are normally around 13xx/14xx.
                | This prevents a Gregorian date from being
                | interpreted as Jalali.
                */

                if ((int) $year >= 1200 && (int) $year <= 1500) {

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
        | Try Gregorian
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

    /**
     * Convert Gregorian Carbon to Jalali string.
     */
    private function gregorianToJalali(
        Carbon $date
    ): string {
        return Jalalian::fromCarbon(
            $date
        )->format('Y/m/d');
    }

    /**
     * Ensure booking belongs to current salon.
     */
    private function authorizeBooking(
        Booking $booking
    ): void {
        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );
    }
}
