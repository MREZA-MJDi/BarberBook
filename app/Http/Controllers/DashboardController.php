<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\SalonDailyStatus;
use App\Models\Service;
use App\Support\SalonStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Current Salon
        |--------------------------------------------------------------------------
        */

        $salon = Auth::user()->salon;

        abort_unless($salon, 404);


        /*
        |--------------------------------------------------------------------------
        | Salon Status
        |--------------------------------------------------------------------------
        */

        $salonStatus = SalonStatus::get($salon);


        /*
        |--------------------------------------------------------------------------
        | Basic Booking Query
        |--------------------------------------------------------------------------
        */

        $bookingQuery = Booking::query()
            ->where('salon_id', $salon->id);


        /*
        |--------------------------------------------------------------------------
        | Today's Bookings
        |--------------------------------------------------------------------------
        */

        $todayBookings = (clone $bookingQuery)
            ->whereDate(
                'booking_date',
                today()
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Pending Bookings
        |--------------------------------------------------------------------------
        */

        $pendingBookings = (clone $bookingQuery)
            ->where(
                'status',
                'pending'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */

        $servicesCount = Service::query()
            ->where(
                'salon_id',
                $salon->id
            )
            ->where(
                'is_active',
                true
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Unique Customers
        |--------------------------------------------------------------------------
        */

        $customersCount = (clone $bookingQuery)
            ->whereNotNull(
                'customer_phone'
            )
            ->distinct()
            ->count(
                'customer_phone'
            );


        /*
        |--------------------------------------------------------------------------
        | Today's Revenue
        |--------------------------------------------------------------------------
        |
        | Only completed bookings count as revenue.
        |
        | final_price is the historical price snapshot.
        |
        */

        $todayRevenue = $this->calculateRevenue(
            clone $bookingQuery,
            today(),
            today()
        );


        /*
        |--------------------------------------------------------------------------
        | Today's Bookings List
        |--------------------------------------------------------------------------
        */

        $bookings = (clone $bookingQuery)
            ->whereDate(
                'booking_date',
                today()
            )
            ->with('service')
            ->orderBy(
                'booking_time'
            )
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Next Booking
        |--------------------------------------------------------------------------
        */

        $now = now();


        $nextBooking = (clone $bookingQuery)
            ->whereIn(
                'status',
                [
                    'pending',
                    'approved',
                ]
            )
            ->where(
                function ($query) use ($now) {

                    $query
                        ->where(
                            function ($query) use ($now) {

                                $query
                                    ->whereDate(
                                        'booking_date',
                                        today()
                                    )
                                    ->whereTime(
                                        'booking_time',
                                        '>=',
                                        $now->format('H:i:s')
                                    );

                            }
                        )
                        ->orWhereDate(
                            'booking_date',
                            '>',
                            today()
                        );

                }
            )
            ->with('service')
            ->orderBy(
                'booking_date'
            )
            ->orderBy(
                'booking_time'
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = (clone $bookingQuery)
            ->with('service')
            ->latest(
                'updated_at'
            )
            ->take(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */

        $notificationBookings = (clone $bookingQuery)
            ->where(
                'status',
                'pending'
            )
            ->with('service')
            ->latest(
                'created_at'
            )
            ->take(5)
            ->get();


        $notifications = $notificationBookings
            ->map(
                function (Booking $booking) {

                    $jalaliDate = null;


                    if ($booking->booking_date) {

                        try {

                            $jalaliDate =
                                \Morilog\Jalali\Jalalian::fromCarbon(
                                    Carbon::parse(
                                        $booking->booking_date
                                    )
                                )->format(
                                    'j %B Y'
                                );

                        } catch (\Throwable) {

                            $jalaliDate =
                                $booking->booking_date;

                        }

                    }


                    return [

                        'type' =>
                            'bookings',

                        'title' =>
                            'رزرو جدید',

                        'message' =>
                            sprintf(
                                '%s برای %s درخواست رزرو داده است.',
                                $booking->customer_name,
                                $booking->service?->name
                                ?? 'خدمت'
                            ),

                        'date' =>
                            $jalaliDate,

                        'time' =>
                            $booking->booking_time
                                ? substr(
                                $booking->booking_time,
                                0,
                                5
                            )
                                : null,

                        'created_at' =>
                            $booking->created_at
                                ? $booking->created_at
                                ->locale('fa')
                                ->diffForHumans()
                                : null,

                        'booking_id' =>
                            $booking->id,

                    ];
                }
            )
            ->values()
            ->all();


        $notificationsCount =
            $notificationBookings->count();


        /*
        |--------------------------------------------------------------------------
        | Current Month
        |--------------------------------------------------------------------------
        */

        $currentMonthStart =
            now()->startOfMonth();

        $currentMonthEnd =
            now()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Previous Month
        |--------------------------------------------------------------------------
        */

        $previousMonthStart =
            now()
                ->copy()
                ->subMonthNoOverflow()
                ->startOfMonth();

        $previousMonthEnd =
            now()
                ->copy()
                ->subMonthNoOverflow()
                ->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | Current Month Revenue
        |--------------------------------------------------------------------------
        */

        $currentMonthRevenue =
            $this->calculateRevenue(
                clone $bookingQuery,
                $currentMonthStart,
                $currentMonthEnd
            );


        /*
        |--------------------------------------------------------------------------
        | Previous Month Revenue
        |--------------------------------------------------------------------------
        */

        $previousMonthRevenue =
            $this->calculateRevenue(
                clone $bookingQuery,
                $previousMonthStart,
                $previousMonthEnd
            );


        /*
        |--------------------------------------------------------------------------
        | Revenue Growth
        |--------------------------------------------------------------------------
        */

        if (
            $previousMonthRevenue > 0
        ) {

            $revenueGrowth =
                round(
                    (
                        (
                            $currentMonthRevenue
                            -
                            $previousMonthRevenue
                        )
                        /
                        $previousMonthRevenue
                    )
                    * 100
                );

        } else {

            $revenueGrowth =
                $currentMonthRevenue > 0
                    ? 100
                    : 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Monthly Revenue Goal
        |--------------------------------------------------------------------------
        */

        if (
            $previousMonthRevenue > 0
        ) {

            $monthlyGoal =
                round(
                    $previousMonthRevenue * 1.20
                );

        } else {

            $monthlyGoal =
                $currentMonthRevenue > 0
                    ? $currentMonthRevenue
                    : 0;

        }


        /*
        |--------------------------------------------------------------------------
        | Monthly Goal Progress
        |--------------------------------------------------------------------------
        */

        $monthlyGoalProgress =
            $monthlyGoal > 0
                ? min(
                100,
                round(
                    (
                        $currentMonthRevenue
                        /
                        $monthlyGoal
                    )
                    * 100
                )
            )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Current Month Booking Statistics
        |--------------------------------------------------------------------------
        */

        $currentMonthBookings =
            (clone $bookingQuery)
                ->whereBetween(
                    'booking_date',
                    [
                        $currentMonthStart
                            ->toDateString(),

                        $currentMonthEnd
                            ->toDateString(),
                    ]
                )
                ->count();


        $currentMonthCompleted =
            (clone $bookingQuery)
                ->whereBetween(
                    'booking_date',
                    [
                        $currentMonthStart
                            ->toDateString(),

                        $currentMonthEnd
                            ->toDateString(),
                    ]
                )
                ->where(
                    'status',
                    'completed'
                )
                ->count();


        $currentMonthCancelled =
            (clone $bookingQuery)
                ->whereBetween(
                    'booking_date',
                    [
                        $currentMonthStart
                            ->toDateString(),

                        $currentMonthEnd
                            ->toDateString(),
                    ]
                )
                ->where(
                    'status',
                    'cancelled'
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | Monthly Performance
        |--------------------------------------------------------------------------
        */

        $monthlyPerformance = [

            'bookings' =>
                $currentMonthBookings,

            'completed' =>
                $currentMonthCompleted,

            'cancelled' =>
                $currentMonthCancelled,

            'revenue' =>
                $currentMonthRevenue,

            'growth' =>
                $revenueGrowth,

        ];


        /*
        |--------------------------------------------------------------------------
        | Revenue Chart - Last 6 Months
        |--------------------------------------------------------------------------
        */

        $revenueLabels = [];

        $revenueData = [];


        for (
            $i = 5;
            $i >= 0;
            $i--
        ) {

            $month =
                now()
                    ->copy()
                    ->subMonths(
                        $i
                    );


            $monthStart =
                $month
                    ->copy()
                    ->startOfMonth();


            $monthEnd =
                $month
                    ->copy()
                    ->endOfMonth();


            $monthRevenue =
                $this->calculateRevenue(
                    clone $bookingQuery,
                    $monthStart,
                    $monthEnd
                );


            /*
            |--------------------------------------------------------------------------
            | Jalali Month Label
            |--------------------------------------------------------------------------
            */

            $revenueLabels[] =
                \Morilog\Jalali\Jalalian::fromCarbon(
                    $month
                )->format(
                    '%B'
                );


            $revenueData[] =
                $monthRevenue;
        }


        /*
        |--------------------------------------------------------------------------
        | Revenue Data
        |--------------------------------------------------------------------------
        */

        $revenue = [

            'labels' =>
                $revenueLabels,

            'data' =>
                $revenueData,

            'current_month' =>
                $currentMonthRevenue,

            'previous_month' =>
                $previousMonthRevenue,

            'growth' =>
                $revenueGrowth,

            'goal' =>
                $monthlyGoal,

            'progress' =>
                $monthlyGoalProgress,

            'total' =>
                $currentMonthRevenue,

            'notificationsCount' =>
                $notificationsCount,

        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard Stats
        |--------------------------------------------------------------------------
        */

        $stats = [

            'today_bookings' =>
                $todayBookings,

            'pending_bookings' =>
                $pendingBookings,

            'services_count' =>
                $servicesCount,

            'customers_count' =>
                $customersCount,

            'today_revenue' =>
                $todayRevenue,

            'current_month_revenue' =>
                $currentMonthRevenue,

            'previous_month_revenue' =>
                $previousMonthRevenue,

            'revenue_growth' =>
                $revenueGrowth,

            'monthly_goal' =>
                $monthlyGoal,

            'monthly_goal_progress' =>
                $monthlyGoalProgress,

        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.index',
            [

                'stats' =>
                    $stats,

                'bookings' =>
                    $bookings,

                'nextBooking' =>
                    $nextBooking,

                'revenue' =>
                    $revenue,

                'monthlyPerformance' =>
                    $monthlyPerformance,

                'recentActivities' =>
                    $recentActivities,

                'notifications' =>
                    $notifications,

                'notificationsCount' =>
                    $notificationsCount,

                'salonStatus' =>
                    $salonStatus,

            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Revenue Calculator
    |--------------------------------------------------------------------------
    */

    /**
     * Calculate revenue for a date range.
     *
     * Only completed bookings are counted.
     *
     * final_price is preferred.
     * If final_price is null, service.price is used as fallback.
     */
    private function calculateRevenue(
        $query,
        Carbon $start,
        Carbon $end
    ): int {

        return (int) $query
            ->whereBetween(
                'booking_date',
                [
                    $start->toDateString(),
                    $end->toDateString(),
                ]
            )
            ->where(
                'status',
                'completed'
            )
            ->with('service')
            ->get()
            ->sum(
                function (Booking $booking) {

                    if (
                        $booking->final_price !== null
                        &&
                        (int) $booking->final_price > 0
                    ) {

                        return (int) $booking->final_price;
                    }


                    return (int) (
                        $booking->service?->price
                        ?? 0
                    );
                }
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Close Salon For Today
    |--------------------------------------------------------------------------
    */

    public function closeToday()
    {
        $salon =
            Auth::user()->salon;


        SalonDailyStatus::updateOrCreate(
            [
                'salon_id' =>
                    $salon->id,

                'date' =>
                    today(),
            ],
            [
                'status' =>
                    'closed',

                'is_closed_today' =>
                    true,

                'closed_date' =>
                    today(),
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
        $salon =
            Auth::user()->salon;


        SalonDailyStatus::updateOrCreate(
            [
                'salon_id' =>
                    $salon->id,

                'date' =>
                    today(),
            ],
            [
                'status' =>
                    'open',

                'is_closed_today' =>
                    false,

                'closed_date' =>
                    null,
            ]
        );


        return back()->with(
            'success',
            'سالن برای امروز باز شد.'
        );
    }
}
