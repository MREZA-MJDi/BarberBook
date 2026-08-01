@extends('layouts.app')

@section('content')

    <div
        class="relative overflow-hidden bg-background text-text"
        dir="rtl">

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
            class="relative z-10 px-6 py-16 mx-auto space-y-24 max-w-7xl">

            {{-- Trends --}}
            <section id="trends">
                <x-salon.trends />
            </section>

            {{-- Services --}}
            <section id="services">
                <x-salon.services />
            </section>

            {{-- Gallery --}}
            <section id="gallery">
                <x-salon.gallery />
            </section>

            {{-- Reviews --}}
            <section id="reviews">
                <x-salon.reviews />
            </section>

            {{-- Salon Information --}}
            <section id="info">
                <x-salon.info />
            </section>

        </div>

        {{-- Booking --}}
        <section id="booking">
            <x-salon.booking />
        </section>

    </div>

@endsection
