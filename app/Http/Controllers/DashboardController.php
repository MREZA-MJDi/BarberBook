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
        | Revenue is based on completed bookings
        | and the final price of each booking.
        |
        */

        $todayRevenue = (clone $bookingQuery)
            ->whereDate('booking_date', today())
            ->where('status', 'completed')
            ->sum('final_price');


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
   |
   | Find the nearest upcoming booking from now.
   | It can be later today, tomorrow, or any future date.
   |
   */

        $now = now();

        $nextBooking = (clone $bookingQuery)
            ->whereIn('status', [
                'pending',
                'approved',
            ])
            ->where(function ($query) use ($now) {

                // Later today
                $query
                    ->whereDate('booking_date', today())
                    ->whereTime(
                        'booking_time',
                        '>=',
                        $now->format('H:i:s')
                    )

                    // OR any future date
                    ->orWhereDate(
                        'booking_date',
                        '>',
                        today()
                    );

            })
            ->with('service')
            ->orderBy('booking_date')
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

        $notifications = $notificationBookings
            ->map(function ($booking) {

                return [
                    'type' => 'bookings',

                    'title' => 'رزرو جدید',

                    'message' => sprintf(
                        '%s برای %s درخواست رزرو داده است.',
                        $booking->customer_name,
                        $booking->service?->name ?? 'خدمت'
                    ),

                    'date' => Carbon::parse(
                        $booking->booking_date
                    )->locale('fa')->translatedFormat('d F'),

                    'time' => Carbon::parse(
                        $booking->booking_time
                    )->format('H:i'),

                    'created_at' => $booking->created_at?->diffForHumans(),

                    'booking_id' => $booking->id,
                ];

            })
            ->values()
            ->all();

        $notificationsCount = $notificationBookings->count();

        /*
        |--------------------------------------------------------------------------
        | Current Month
        |--------------------------------------------------------------------------
        */

        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Previous Month
        |--------------------------------------------------------------------------
        */

        $previousMonthStart = now()
            ->copy()
            ->subMonthNoOverflow()
            ->startOfMonth();

        $previousMonthEnd = now()
            ->copy()
            ->subMonthNoOverflow()
            ->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Current Month Revenue
        |--------------------------------------------------------------------------
        */

        $currentMonthRevenue = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $currentMonthStart->toDateString(),
                $currentMonthEnd->toDateString(),
            ])
            ->where('status', 'completed')
            ->sum('final_price');


        /*
        |--------------------------------------------------------------------------
        | Previous Month Revenue
        |--------------------------------------------------------------------------
        */

        $previousMonthRevenue = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $previousMonthStart->toDateString(),
                $previousMonthEnd->toDateString(),
            ])
            ->where('status', 'completed')
            ->sum('final_price');


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
        | Until a real monthly goal field exists on salons,
        | use 120% of previous month's revenue as target.
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
        | Monthly Performance
        |--------------------------------------------------------------------------
        */

        $currentMonthBookings = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $currentMonthStart->toDateString(),
                $currentMonthEnd->toDateString(),
            ])
            ->count();


        $currentMonthCompleted = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $currentMonthStart->toDateString(),
                $currentMonthEnd->toDateString(),
            ])
            ->where('status', 'completed')
            ->count();


        $currentMonthCancelled = (clone $bookingQuery)
            ->whereBetween('booking_date', [
                $currentMonthStart->toDateString(),
                $currentMonthEnd->toDateString(),
            ])
            ->where('status', 'cancelled')
            ->count();


        $monthlyPerformance = [

            'bookings' => $currentMonthBookings,

            'completed' => $currentMonthCompleted,

            'cancelled' => $currentMonthCancelled,

            'revenue' => $currentMonthRevenue,

            'growth' => $revenueGrowth,

        ];


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
                ->sum('final_price');


            $revenueLabels[] = $month
                ->locale('fa')
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
            'notificationsCount' => $notificationsCount,


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
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('dashboard.index', [

            'stats' => $stats,

            'bookings' => $bookings,

            'nextBooking' => $nextBooking,

            'revenue' => $revenue,

            'monthlyPerformance' => $monthlyPerformance,

            'recentActivities' => $recentActivities,

            'notifications' => $notifications,

            'notificationsCount' => $notificationsCount,

            'salonStatus' => $salonStatus,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Close Salon For Today
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Open Salon For Today
    |--------------------------------------------------------------------------
    */

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
