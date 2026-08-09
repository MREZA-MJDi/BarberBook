<x-layouts.dashboard>

    {{-- =========================================================
        Welcome
    ========================================================== --}}
    <section>
        <x-dashboard.welcome-card
            :salon-status="$salonStatus"
            :stats="$stats"
        />
    </section>


    {{-- =========================================================
        KPI
    ========================================================== --}}
    <section class="mt-8">

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

            <x-dashboard.stat-card
                title="رزرو امروز"
                :value="$stats['today_bookings']"
                icon="calendar"
                description="رزرو ثبت‌شده امروز"
            />

            <x-dashboard.stat-card
                title="درآمد امروز"
                :value="number_format($stats['today_revenue'])"
                icon="money"
                description="تومان"
            />

            <x-dashboard.stat-card
                title="مشتری‌ها"
                :value="$stats['customers_count']"
                icon="users"
                description="مشتری ثبت‌شده"
            />

            <x-dashboard.stat-card
                title="درخواست‌های در انتظار"
                :value="$stats['pending_bookings']"
                icon="target"
                description="نیازمند بررسی"
            />

        </div>

    </section>


    {{-- =========================================================
        Next Booking + Quick Actions
    ========================================================== --}}
    <section class="mt-8">

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            <x-dashboard.next-booking
                :booking="$nextBooking"
            />

            <x-dashboard.quick-actions />

        </div>

    </section>


    {{-- =========================================================
        Today's Schedule
    ========================================================== --}}
    <section class="mt-8">

        <x-dashboard.today-schedule
            :bookings="$bookings"
        />

    </section>


    {{-- =========================================================
        Activity + Analytics
    ========================================================== --}}
    <section class="mt-8">

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

            <x-dashboard.activity-feed
                :activities="$recentActivities"
            />

            <x-dashboard.revenue-chart
                :revenue="$revenue"
            />

        </div>

    </section>


    {{-- =========================================================
        Today's Bookings
    ========================================================== --}}
    <section class="mt-8">

        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">

            <div class="mb-6 flex items-center justify-between gap-4">

                <div>

                    <h2 class="text-lg font-black text-white">
                        رزروهای امروز
                    </h2>

                    <p class="mt-1 text-sm text-zinc-500">
                        برنامه امروز سالن
                    </p>

                </div>


                <a
                    href="{{ route('bookings.index') }}"
                    class="text-sm font-bold text-orange-400 transition hover:text-orange-300"
                >
                    مشاهده همه
                </a>

            </div>


            <x-dashboard.booking-table
                :bookings="$bookings"
            />

        </div>

    </section>

</x-layouts.dashboard>
