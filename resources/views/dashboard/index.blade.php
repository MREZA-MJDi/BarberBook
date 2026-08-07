<x-layouts.dashboard>


    {{-- Welcome --}}
    <section>

        <x-dashboard.welcome-card />

    </section>





    {{-- KPI --}}
    <section class="mt-8">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">


            <x-dashboard.stat-card
                title="رزرو امروز"
                value="12"
                icon="calendar"
                description="مشتری امروز"
                trend="+20%"
            />


            <x-dashboard.stat-card
                title="درآمد امروز"
                value="2,450,000"
                icon="money"
                description="تومان"
                trend="+15%"
            />


            <x-dashboard.stat-card
                title="مشتری جدید"
                value="8"
                icon="users"
                description="این هفته"
                trend="+3"
            />


            <x-dashboard.stat-card
                title="هدف درآمد امروز"
                value="70%"
                icon="target"
            />


        </div>

    </section>







    {{-- Next Booking --}}
    <section class="mt-8">

        <x-dashboard.next-booking />

    </section>







    {{-- Activity + Actions --}}
    <section
        class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">


        <x-dashboard.activity-feed />


        <x-dashboard.quick-actions />


    </section>








    {{-- Today Schedule --}}
    <section class="mt-8">


        <x-dashboard.today-schedule />


    </section>








    {{-- Analytics --}}
    <section class="mt-8">


        <x-dashboard.revenue-chart />


    </section>





    {{-- Booking List --}}
    <section class="mt-8">


        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


            <div class="mb-6">


                <h2 class="text-lg font-black text-white">
                    رزروهای امروز
                </h2>


                <p class="mt-1 text-sm text-zinc-500">
                    آخرین درخواست‌ها
                </p>


            </div>


            <x-dashboard.booking-table
                :bookings="$bookings"
            />


        </div>


    </section>




</x-layouts.dashboard>
