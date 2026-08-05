<x-layouts.dashboard>


    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">


        <div>

            <h1 class="text-3xl font-black text-white">
                جزئیات رزرو
            </h1>


            <p class="mt-2 text-zinc-400">
                مشاهده اطلاعات مشتری و مدیریت وضعیت رزرو
            </p>

        </div>



        <a href="{{ route('bookings.index') }}"
           class="rounded-xl border border-zinc-800 px-5 py-3 text-sm font-bold text-zinc-300 transition hover:border-orange-500 hover:text-orange-500">

            بازگشت به رزروها

        </a>


    </div>





    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">



        {{-- Main Info --}}
        <div class="lg:col-span-2 space-y-6">



            {{-- Customer --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


                <div class="flex items-center gap-4">


                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-2xl
                        bg-orange-500/10 border border-orange-500/20
                        text-xl font-black text-orange-500">


                        {{ mb_substr($booking->customer_name,0,1) }}


                    </div>



                    <div>


                        <h2 class="text-xl font-black text-white">

                            {{ $booking->customer_name }}

                        </h2>


                        <p class="mt-1 text-sm text-zinc-500">

                            {{ $booking->customer_phone }}

                        </p>


                    </div>



                </div>


            </div>





            {{-- Booking Info --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


                <h3 class="mb-6 text-lg font-black text-white">

                    اطلاعات رزرو

                </h3>



                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">



                    <div>

                        <p class="text-sm text-zinc-500">
                            سرویس
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ $booking->service->name ?? '-' }}

                        </p>

                    </div>




                    <div>

                        <p class="text-sm text-zinc-500">
                            کد پیگیری
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ $booking->reference_code }}

                        </p>

                    </div>




                    <div>

                        <p class="text-sm text-zinc-500">
                            تاریخ
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ $booking->booking_date }}

                        </p>

                    </div>





                    <div>

                        <p class="text-sm text-zinc-500">
                            ساعت
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ $booking->booking_time }}

                        </p>

                    </div>




                    <div>

                        <p class="text-sm text-zinc-500">
                            مبلغ نهایی
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ number_format($booking->final_price ?? 0) }}

                            تومان

                        </p>

                    </div>




                    <div>

                        <p class="text-sm text-zinc-500">
                            مدت زمان
                        </p>


                        <p class="mt-1 font-bold text-white">

                            {{ $booking->duration_minutes ?? 0 }}

                            دقیقه

                        </p>

                    </div>



                </div>


            </div>





            {{-- Notes --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


                <h3 class="mb-4 text-lg font-black text-white">

                    یادداشت‌ها

                </h3>



                <div class="space-y-4">



                    <div>

                        <p class="text-sm text-zinc-500">
                            یادداشت مشتری
                        </p>


                        <p class="mt-2 text-sm text-zinc-300">

                            {{ $booking->customer_note ?? 'بدون یادداشت' }}

                        </p>

                    </div>




                    <div>

                        <p class="text-sm text-zinc-500">
                            پیام آرایشگر
                        </p>


                        <p class="mt-2 text-sm text-zinc-300">

                            {{ $booking->barber_note ?? 'بدون پیام' }}

                        </p>

                    </div>



                </div>


            </div>



        </div>







        {{-- Sidebar Actions --}}
        <div class="space-y-6">



            {{-- Status --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


                <p class="mb-3 text-sm text-zinc-500">

                    وضعیت رزرو

                </p>


                <x-dashboard.bookings.status
                    :status="$booking->status"
                />


            </div>






            {{-- Actions --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


                <h3 class="mb-5 text-lg font-black text-white">

                    عملیات

                </h3>



                <x-dashboard.bookings.actions
                    :booking="$booking"
                />


            </div>



        </div>



    </div>



</x-layouts.dashboard>
