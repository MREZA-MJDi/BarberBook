@extends('layouts.app')

@section('content')

    <div
        class="relative overflow-hidden bg-background text-text"
        dir="rtl"
    >

        {{-- Hero --}}
        <section id="home">
            @include('salon.hero', [
                'salon' => $salon,
                'averageRating' => $averageRating,
                'reviewsCount' => $reviewsCount,
            ])
        </section>


        {{-- Booking --}}
        <section id="booking">
            <x-salon.booking
                :salon="$salon"
                :selected-date="$selectedDate"
                :jalali-date="$jalaliDate"
                :selected-service="$selectedService"
                :available-slots="$availableSlots"
                :selected-time="$selectedTime"
            />
        </section>


        {{-- Salon Info --}}
        <section id="info">
            <x-salon.info
                :salon="$salon"
            />
        </section>

    </div>

@endsection
