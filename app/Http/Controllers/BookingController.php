<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{

    public function index(): View
    {
        $salon = auth()->user()->salon;


        $bookings = Booking::with('service')
            ->where('salon_id', $salon->id)
            ->latest()
            ->paginate(10);


        return view('dashboard.bookings.index', compact('bookings'));
    }



    public function show(Booking $booking): View
    {
        $this->authorizeBooking($booking);


        $booking->load('service');


        return view('dashboard.bookings.show', compact('booking'));
    }



    public function update(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);


        $validated = $request->validate([

            'status' => [
                'required',
                'in:pending,approved,rejected,cancelled'
            ],

            'barber_note' => [
                'nullable',
                'string'
            ],

            'booking_date' => [
                'nullable',
                'date'
            ],

            'booking_time' => [
                'nullable'
            ],

        ]);



        $booking->update($validated);



        return back()->with(
            'success',
            'وضعیت رزرو بروزرسانی شد.'
        );
    }




    private function authorizeBooking(Booking $booking): void
    {
        abort_if(
            $booking->salon_id !== auth()->user()->salon->id,
            403
        );
    }

}
