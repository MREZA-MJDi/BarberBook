@extends('layouts.app')

@section('content')

    <div
        class="relative overflow-hidden bg-background text-text"
        dir="rtl"
    >

        {{-- Background Effects --}}
        <div class="absolute inset-0 -z-0 overflow-hidden">

            <div
                class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-primary/10 blur-[140px]">
            </div>

            <div
                class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-secondary/10 blur-[120px]">
            </div>

        </div>

        {{-- Hero --}}
        <div class="relative z-10">
            <x-landing.hero />
        </div>

        {{-- Sections --}}
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

                        <h2 class="text-3xl font-black text-text">

                            <span class="text-primary">

                        </span>

                        </h2>
                        <p class="mt-4 text-muted">

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
                class="p-8 border rounded-3xl border-border bg-surface shadow-lg"
            >

                <x-booking.stepper />

                <x-booking.calendar />

                <x-booking.time-picker />

                <x-booking.payment-summary />

            </section>

        </div>

    </div>

@endsection
