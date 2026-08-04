<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $salon = Auth::user()->salon;


        $stats = [

            'today_bookings' => Booking::where('salon_id', $salon->id)
                ->whereDate('booking_date', today())
                ->count(),


            'pending_bookings' => Booking::where('salon_id', $salon->id)
                ->where('status', 'pending')
                ->count(),


            'services_count' => Service::where('salon_id', $salon->id)
                ->count(),


            'customers_count' => Booking::where('salon_id', $salon->id)
                ->distinct('customer_phone')
                ->count('customer_phone'),

        ];


        $bookings = Booking::where('salon_id', $salon->id)
            ->latest()
            ->take(5)
            ->get();


        $revenue = [

            'labels' => [
                'فروردین',
                'اردیبهشت',
                'خرداد',
                'تیر',
                'مرداد',
                'شهریور',
            ],

            'data' => [
                12000000,
                18000000,
                22000000,
                15000000,
                28000000,
                32000000,
            ],

            'total' => 32000000,

        ];


        return view('dashboard.index', compact(
            'stats',
            'bookings',
            'revenue'
        ));
    }
}
