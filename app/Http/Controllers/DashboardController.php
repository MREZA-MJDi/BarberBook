<?php

namespace App\Http\Controllers;

use App\Models\SalonDailyStatus;
use App\Support\SalonStatus;
use App\Models\Booking;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $salon = Auth::user()->salon;

        $salonStatus = SalonStatus::get($salon);

        /*
        |--------------------------------------------------------------------------
        | Basic Query
        |--------------------------------------------------------------------------
        */

        $bookingQuery = Booking::where('salon_id', $salon->id);


        /*
        |--------------------------------------------------------------------------
        | Today's Bookings
        |--------------------------------------------------------------------------
        */

        $todayBookings = (clone $bookingQuery)
            ->whereDate('booking_date', today())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Bookings
        |--------------------------------------------------------------------------
        */

        $pendingBookings = (clone $bookingQuery)
            ->where('status', 'pending')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $servicesCount = Service::where('salon_id', $salon->id)
            ->where('is_active', true)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Unique Customers
        |--------------------------------------------------------------------------
        */

        $customersCount = (clone $bookingQuery)
            ->whereNotNull('customer_phone')
            ->distinct()
            ->count('customer_phone');


        /*
        |--------------------------------------------------------------------------
        | Today's Revenue
        |--------------------------------------------------------------------------
        |
        | Revenue is based on completed bookings only.
        |
        */

        $todayRevenue = (clone $bookingQuery)
            ->whereDate('booking_date', today())
            ->where('status', 'completed')
            ->with('service')
            ->get()
            ->sum(function ($booking) {
                return $booking->service?->price ?? 0;
            });


        /*
        |--------------------------------------------------------------------------
        | Today's Bookings List
        |--------------------------------------------------------------------------
        */

        $bookings = (clone $bookingQuery)
            ->whereDate('booking_date', today())
            ->with('service')
            ->orderBy('booking_time')
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Next Booking
        |--------------------------------------------------------------------------
        */

        $nextBooking = (clone $bookingQuery)
            ->whereDate('booking_date', today())
            ->where('booking_time', '>=', now()->format('H:i:s'))
            ->whereIn('status', [
                'pending',
                'approved',
            ])
            ->with('service')
            ->orderBy('booking_time')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = (clone $bookingQuery)
            ->with('service')
            ->latest('updated_at')
            ->take(6)
            ->get();
        /*
   |--------------------------------------------------------------------------
   | Notifications
   |--------------------------------------------------------------------------
   */

        $notificationBookings = (clone $bookingQuery)
            ->where('status', 'pending')
            ->with('service')
            ->latest('created_at')
            ->take(5)
            ->get();

        $notifications = $notificationBookings->map(function ($booking) {

            return [
                'type' => 'bookings',

                'title' => 'رزرو جدید',

                'message' => sprintf(
                    '%s برای %s درخواست رزرو داده است.',
                    $booking->customer_name,
                    $booking->service?->name ?? 'خدمت'
                ),

                'time' => $booking->created_at?->diffForHumans(),
            ];

        })->values()->all();

        $notificationsCount = (clone $bookingQuery)
            ->where('status', 'pending')
            ->count();
        /*
        |--------------------------------------------------------------------------
        | Current Month Revenue
        |--------------------------------------------------------------------------
        */

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $currentMonthRevenue = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $currentMonthStart->toDateString(),
                $currentMonthEnd->toDateString(),
            ])
            ->where('status', 'completed')
            ->with('service')
            ->get()
            ->sum(function ($booking) {
                return $booking->service?->price ?? 0;
            });


        /*
        |--------------------------------------------------------------------------
        | Previous Month Revenue
        |--------------------------------------------------------------------------
        */

        $previousMonthStart = now()
            ->subMonthNoOverflow()
            ->startOfMonth();

        $previousMonthEnd = now()
            ->subMonthNoOverflow()
            ->endOfMonth();

        $previousMonthRevenue = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $previousMonthStart->toDateString(),
                $previousMonthEnd->toDateString(),
            ])
            ->where('status', 'completed')
            ->with('service')
            ->get()
            ->sum(function ($booking) {
                return $booking->service?->price ?? 0;
            });


        /*
        |--------------------------------------------------------------------------
        | Revenue Growth
        |--------------------------------------------------------------------------
        */

        if ($previousMonthRevenue > 0) {

            $revenueGrowth = round(
                (
                    ($currentMonthRevenue - $previousMonthRevenue)
                    / $previousMonthRevenue
                ) * 100
            );

        } else {

            $revenueGrowth = $currentMonthRevenue > 0
                ? 100
                : 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue Goal
        |--------------------------------------------------------------------------
        |
        | Until we add a real monthly goal field to salons,
        | use 120% of previous month's revenue as a dynamic target.
        |
        */

        if ($previousMonthRevenue > 0) {

            $monthlyGoal = round(
                $previousMonthRevenue * 1.20
            );

        } else {

            $monthlyGoal = $currentMonthRevenue > 0
                ? $currentMonthRevenue
                : 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Monthly Goal Progress
        |--------------------------------------------------------------------------
        */

        $monthlyGoalProgress = $monthlyGoal > 0
            ? min(
                100,
                round(
                    ($currentMonthRevenue / $monthlyGoal) * 100
                )
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Revenue Chart - Last 6 Months
        |--------------------------------------------------------------------------
        */

        $revenueLabels = [];
        $revenueData = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = now()
                ->copy()
                ->subMonths($i);

            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthRevenue = (clone $bookingQuery)
                ->whereBetween('booking_date', [
                    $monthStart->toDateString(),
                    $monthEnd->toDateString(),
                ])
                ->where('status', 'completed')
                ->with('service')
                ->get()
                ->sum(function ($booking) {
                    return $booking->service?->price ?? 0;
                });


            $revenueLabels[] = $month->locale('fa')
                ->translatedFormat('F');

            $revenueData[] = $monthRevenue;
        }


        /*
        |--------------------------------------------------------------------------
        | Revenue Chart Data
        |--------------------------------------------------------------------------
        */

        $revenue = [

            'labels' => $revenueLabels,

            'data' => $revenueData,

            'current_month' => $currentMonthRevenue,

            'previous_month' => $previousMonthRevenue,

            'growth' => $revenueGrowth,

            'goal' => $monthlyGoal,

            'progress' => $monthlyGoalProgress,

            'total' => $currentMonthRevenue,

        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard Stats
        |--------------------------------------------------------------------------
        */

        $stats = [

            'today_bookings' => $todayBookings,

            'pending_bookings' => $pendingBookings,

            'services_count' => $servicesCount,

            'customers_count' => $customersCount,

            'today_revenue' => $todayRevenue,

            'current_month_revenue' => $currentMonthRevenue,

            'previous_month_revenue' => $previousMonthRevenue,

            'revenue_growth' => $revenueGrowth,

            'monthly_goal' => $monthlyGoal,

            'monthly_goal_progress' => $monthlyGoalProgress,

        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', [

            'stats' => $stats,

            'bookings' => $bookings,

            'nextBooking' => $nextBooking,

            'revenue' => $revenue,

            'recentActivities' => $recentActivities,

            'notifications' => $notifications,

            'notificationsCount' => $notificationsCount,

            'salonStatus' => $salonStatus,
        ]);
    }

    public function closeToday()
    {
        $salon = Auth::user()->salon;

        SalonDailyStatus::updateOrCreate(
            [
                'salon_id' => $salon->id,
                'date' => today(),
            ],
            [
                'status' => 'closed',
                'is_closed_today' => true,
                'closed_date' => today(),
            ]
        );

        return back()->with(
            'success',
            'سالن برای امروز بسته شد.'
        );
    }


    public function openToday()
    {
        $salon = Auth::user()->salon;

        SalonDailyStatus::updateOrCreate(
            [
                'salon_id' => $salon->id,
                'date' => today(),
            ],
            [
                'status' => 'open',
                'is_closed_today' => false,
                'closed_date' => null,
            ]
        );

        return back()->with(
            'success',
            'سالن برای امروز باز شد.'
        );
    }
}
