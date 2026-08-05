<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\BookingActionRequest;
use App\Http\Requests\Booking\BookingFilterRequest;
use App\Http\Requests\Booking\RescheduleBookingRequest;
use App\Models\Booking;
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

                $q->where('customer_name', 'like', '%' . $request->search . '%')
                    ->orWhere('customer_phone', 'like', '%' . $request->search . '%')
                    ->orWhere('reference_code', 'like', '%' . $request->search . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate('booking_date', $request->date);

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

        return view('dashboard.bookings.index', compact('bookings'));
    }

    /**
     * Display bookings details.
     */
    public function show(Booking $booking): View
    {
        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

        $booking->load('service');

        return view('dashboard.bookings.show', compact('booking'));
    }

    /**
     * Approve bookings.
     */
    public function approve(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

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
     * Reject bookings.
     */
    public function reject(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

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
     * Complete bookings.
     */
    public function complete(
        BookingActionRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

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
     * Reschedule bookings.
     */
    public function reschedule(
        RescheduleBookingRequest $request,
        Booking $booking
    ): RedirectResponse {

        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );

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
}
