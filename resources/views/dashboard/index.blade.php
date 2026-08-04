<x-layouts.dashboard>


    {{-- Page Header --}}
    <div class="mb-8">


        <h1 class="text-3xl font-black text-white">

            داشبورد

        </h1>



        <p class="mt-2 text-zinc-400">

            خوش آمدید، مدیریت آرایشگاه خود را از اینجا آغاز کنید.

        </p>


    </div>





    {{-- Statistics --}}
    <section
        class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">



        <x-dashboard.stat-card
            title="رزروهای امروز"
            value="{{ $stats['today_bookings'] }}"
            icon="calendar"
        />


        <x-dashboard.stat-card
            title="درخواست‌های جدید"
            value="{{ $stats['pending_bookings'] }}"
            icon="clock"
        />


        <x-dashboard.stat-card
            title="خدمات فعال"
            value="{{ $stats['services_count'] }}"
            icon="scissors"
        />


        <x-dashboard.stat-card
            title="مشتریان این ماه"
            value="{{ $stats['customers_count'] }}"
            icon="users"
        />


    </section>



    <section class="mt-8">

        <x-dashboard.revenue-chart :revenue="$revenue" />

    </section>



    {{-- Main Content --}}
    <section
        class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-3">





        {{-- Booking --}}
        <div class="xl:col-span-2">


            <div
                class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">



                <div class="flex items-center justify-between">


                    <div>

                        <h2 class="text-lg font-black text-white">

                            رزروهای امروز

                        </h2>


                        <p class="mt-1 text-sm text-zinc-500">

                            آخرین درخواست‌های ثبت شده

                        </p>


                    </div>




                    <a href="#"
                       class="text-sm font-bold text-orange-500 transition hover:text-orange-400">

                        مشاهده همه

                    </a>



                </div>






                <div class="mt-6">


                    <x-dashboard.booking-table :bookings="$bookings" />

                </div>



            </div>



        </div>








        {{-- Sidebar --}}
        <div class="space-y-6">



            <x-dashboard.quick-actions />



            <x-dashboard.qr-card />


        </div>





    </section>







</x-layouts.dashboard>
