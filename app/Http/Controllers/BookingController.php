<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingActionRequest;
use App\Http\Requests\Booking\BookingFilterRequest;
use App\Http\Requests\Booking\RescheduleBookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Display bookings list.
     */
    public function index(BookingFilterRequest $request): View
    {
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

            $query->where(function ($q) use ($request) {

                $q->where(
                    'customer_name',
                    'like',
                    '%' . $request->search . '%'
                )
                    ->orWhere(
                        'customer_phone',
                        'like',
                        '%' . $request->search . '%'
                    )
                    ->orWhere(
                        'reference_code',
                        'like',
                        '%' . $request->search . '%'
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
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
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate(
                'booking_date',
                $request->date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sort
        |--------------------------------------------------------------------------
        */

        if ($request->sort === 'oldest') {

            $query->oldest();

        } else {

            $query->latest();
        }

        $bookings = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'dashboard.bookings.index',
            compact('bookings')
        );
    }

    /**
     * Display booking details.
     */
    public function show(Booking $booking): View
    {
        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        $booking->load('service');

        return view(
            'dashboard.bookings.show',
            compact('booking')
        );
    }

    /**
     * Approve booking.
     */
    public function approve(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Prevent approving an already processed booking
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
        | Check Time Conflict
        |--------------------------------------------------------------------------
        */

        if ($this->hasBookingConflict(
            $booking->salon_id,
            $booking->booking_date,
            $booking->booking_time,
            $booking->duration_minutes,
            $booking->id
        )) {

            return back()->with(
                'error',
                'این زمان قبلاً توسط رزرو دیگری اشغال شده است.'
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

            'barber_note' => $request->barber_note,

        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت تایید شد.'
        );
    }

    /**
     * Reject booking.
     */
    public function reject(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        if ($booking->status !== 'pending') {

            return back()->with(
                'error',
                'این رزرو دیگر قابل رد کردن نیست.'
            );
        }

        $booking->update([

            'status' => 'rejected',

            'barber_note' => $request->barber_note,

        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت رد شد.'
        );
    }

    /**
     * Complete booking.
     */
    public function complete(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        if ($booking->status !== 'approved') {

            return back()->with(
                'error',
                'فقط رزرو تایید شده قابل تکمیل است.'
            );
        }

        $booking->update([

            'status' => 'completed',

            'completed_at' => now(),

            'barber_note' => $request->barber_note,

        ]);

        return back()->with(
            'success',
            'رزرو با موفقیت تکمیل شد.'
        );
    }

    /**
     * Reschedule booking.
     */
    public function reschedule(
        RescheduleBookingRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        if ($booking->status !== 'approved') {

            return back()->with(
                'error',
                'فقط رزرو تایید شده قابل جابه‌جایی است.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check New Time Conflict
        |--------------------------------------------------------------------------
        */

        if ($this->hasBookingConflict(
            $booking->salon_id,
            $request->booking_date,
            $request->booking_time,
            $booking->duration_minutes,
            $booking->id
        )) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'زمان انتخاب‌شده با یک رزرو دیگر تداخل دارد.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update Booking
        |--------------------------------------------------------------------------
        */

        $booking->update([

            'booking_date' => $request->booking_date,

            'booking_time' => $request->booking_time,

            'barber_note' => $request->barber_note,

        ]);

        return back()->with(
            'success',
            'زمان رزرو با موفقیت تغییر کرد.'
        );
    }

    /**
     * Check whether a booking conflicts with another active booking.
     */
    private function hasBookingConflict(
        int $salonId,
        string $bookingDate,
        string $bookingTime,
        ?int $durationMinutes = null,
        ?int $ignoreBookingId = null
    ): bool {

        $durationMinutes = $durationMinutes ?: 60;

        /*
        |--------------------------------------------------------------------------
        | New Booking Time Range
        |--------------------------------------------------------------------------
        */

        $newStart = Carbon::parse(
            $bookingDate . ' ' . $bookingTime
        );

        $newEnd = $newStart->copy()->addMinutes(
            $durationMinutes
        );

        /*
        |--------------------------------------------------------------------------
        | Existing Active Bookings
        |--------------------------------------------------------------------------
        */

        $query = Booking::query()
            ->where('salon_id', $salonId)
            ->whereDate('booking_date', $bookingDate)
            ->whereIn('status', [
                'pending',
                'approved',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Ignore Current Booking During Reschedule
        |--------------------------------------------------------------------------
        */

        if ($ignoreBookingId) {

            $query->where(
                'id',
                '!=',
                $ignoreBookingId
            );
        }

        $existingBookings = $query->get();

        /*
        |--------------------------------------------------------------------------
        | Check Overlap
        |--------------------------------------------------------------------------
        */

        foreach ($existingBookings as $existingBooking) {

            $existingStart = Carbon::parse(
                $bookingDate . ' ' . $existingBooking->booking_time
            );

            $existingEnd = $existingStart->copy()->addMinutes(
                $existingBooking->duration_minutes ?: 60
            );

            /*
            |--------------------------------------------------------------------------
            | Overlap Formula
            |--------------------------------------------------------------------------
            |
            | New start < Existing end
            | AND
            | New end > Existing start
            |
            */

            if (
                $newStart->lt($existingEnd) &&
                $newEnd->gt($existingStart)
            ) {

                return true;
            }
        }

        return false;
    }
}
