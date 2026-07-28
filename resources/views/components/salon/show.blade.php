@extends('layouts.app')


@section('content')


    <div
        class="relative overflow-hidden bg-zinc-950 text-white"
        dir="rtl"
    >


        {{-- Background Effects --}}
        <div class="absolute inset-0 -z-0 overflow-hidden">


            <div
                class="absolute w-[500px] h-[500px] rounded-full bg-indigo-600/20 blur-[140px] top-0 right-0">
            </div>


            <div
                class="absolute w-[400px] h-[400px] rounded-full bg-purple-600/10 blur-[120px] bottom-0 left-0">
            </div>


        </div>




        {{-- Hero --}}
        <div class="relative z-10">

            <x-landing.hero />

        </div>





        {{-- Salon Sections --}}
        <div
            class="relative z-10 px-6 py-16 mx-auto space-y-20 max-w-7xl"
        >



            {{-- Gallery --}}
            <section id="gallery">

                <x-salon.gallery />

            </section>



            {{-- Staff --}}
            <section id="staff">

                <div class="container px-6 py-20 mx-auto">


                    <div class="mb-12 text-center">


                        <h2 class="text-3xl font-black text-white">

                            تیم
                            <span class="text-zinc-300">
                    آلیجناب
                </span>

                        </h2>


                        <p class="mt-4 text-zinc-400">

                            متخصصانی که تجربه شما را می‌سازند

                        </p>


                    </div>



                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">


                        <x-salon.staff-card />


                    </div>


                </div>

            </section>
            {{-- Services --}}
            <section id="services">

                <x-salon.services />

            </section>

            {{-- Reviews --}}
            <section>
                <x-salon.review-list />
            </section>


            {{-- Booking CTA --}}
            <section>

                <x-salon.booking-cta />

            </section>




            {{-- Booking --}}
            <section
                id="booking"
                class="p-6 border rounded-3xl border-zinc-800 bg-zinc-900/40 backdrop-blur"
            >


                <x-booking.stepper />


                <x-booking.calendar />


                <x-booking.time-picker />


                <x-booking.payment-summary />


            </section>



        </div>



    </div>


@endsection
