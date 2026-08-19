<x-layouts.dashboard>

    {{-- =========================================================
        01. Welcome
    ========================================================== --}}

    <section>
        <x-dashboard.welcome-card
            :salon-status="$salonStatus"
            :stats="$stats"
        />
    </section>


    {{-- =========================================================
        02. KPI
    ========================================================== --}}

    <section class="mt-6 sm:mt-8">

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

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
        Monthly Performance
    ========================================================== --}}
    <section class="mt-8">

        <x-dashboard.monthly-performance
            :performance="$monthlyPerformance"
        />

    </section>
    {{-- =========================================================
        03. Main Operations
    ========================================================== --}}

    <section class="mt-6 sm:mt-8">

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6">

                <x-dashboard.next-booking
                    :booking="$nextBooking"
                />

            </div>


            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6">

                <x-dashboard.quick-actions />

            </div>

        </div>

    </section>


    {{-- =========================================================
        04. Today's Schedule
    ========================================================== --}}

    <section class="mt-6 sm:mt-8">

        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6">

            <x-dashboard.today-schedule
                :bookings="$bookings"
            />

        </div>

    </section>


    {{-- =========================================================
        05. Insights
    ========================================================== --}}

    <section class="mt-6 sm:mt-8">

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">

            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6">

                <x-dashboard.activity-feed
                    :activities="$recentActivities"
                />

            </div>


            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-5 sm:p-6">

                <x-dashboard.revenue-chart
                    :revenue="$revenue"
                />

            </div>

        </div>

    </section>


    {{-- =========================================================
        End Spacing
    ========================================================== --}}

    <div class="h-2 sm:h-4"></div>

</x-layouts.dashboard>
