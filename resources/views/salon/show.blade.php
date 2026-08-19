{{-- resources/views/salon/show.blade.php --}}

@extends('layouts.app')

@section('content')

    <div
        class="relative overflow-hidden bg-background text-text"
        dir="rtl"
    >

        {{-- =====================================================
            Background Effects
        ====================================================== --}}

        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div
                class="
                    absolute
                    right-0
                    top-0
                    h-[500px]
                    w-[500px]
                    rounded-full
                    bg-primary/10
                    blur-[140px]
                "
            ></div>

            <div
                class="
                    absolute
                    bottom-0
                    left-0
                    h-[400px]
                    w-[400px]
                    rounded-full
                    bg-secondary/10
                    blur-[120px]
                "
            ></div>

        </div>


        {{-- =====================================================
            Hero
        ====================================================== --}}

        <div class="relative z-10">

            @include('salon.hero', [
                'salon' => $salon,
                'averageRating' => $averageRating,
                'reviewsCount' => $reviewsCount,
            ])

        </div>


        {{-- =====================================================
            Main Public Content
        ====================================================== --}}

        <main
            class="
                relative
                z-10
                mx-auto
                max-w-7xl
                space-y-24
                px-5
                py-16
                sm:px-6
                lg:px-8
            "
        >

            {{-- =================================================
                Salon Info
            ================================================== --}}

            <section id="info">

                <x-salon.info
                    :salon="$salon"
                />

            </section>


            {{-- =================================================
                Services
            ================================================== --}}

            <section id="services">

                <x-salon.services
                    :services="$salon->services"
                />

            </section>


            {{-- =================================================
                Gallery
            ================================================== --}}

            <section id="gallery">

                <x-salon.gallery
                    :gallery-items="$galleryItems"
                />

            </section>


            {{-- =================================================
                Reviews
            ================================================== --}}

            <section id="reviews">

                <x-salon.reviews
                    :reviews="$reviews"
                    :average-rating="$averageRating"
                    :reviews-count="$reviewsCount"
                />

            </section>


            {{-- =================================================
                Trends
            ================================================== --}}

            <section id="trends">

                <x-salon.trends
                    :salon="$salon"
                />

            </section>

        </main>


        {{-- =====================================================
            Booking
        ====================================================== --}}
        {{-- IMPORTANT:
             x-salon.booking خودش section#booking را دارد.
             اینجا wrapper دیگری نساز. --}}

        <x-salon.booking
            :salon="$salon"
            :selected-date="$selectedDate"
            :jalali-date="$jalaliDate"
            :selected-service="$selectedService"
            :available-slots="$availableSlots"
            :selected-time="$selectedTime"
        />

    </div>

@endsection
