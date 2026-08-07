<x-layouts.dashboard>

    {{-- Page Header --}}
    <div class="mb-8">

        <h1 class="text-3xl font-black text-white">
            مدیریت رزروها
        </h1>

        <p class="mt-2 text-zinc-400">
            مشاهده و مدیریت درخواست‌های رزرو مشتریان
        </p>

    </div>



    {{-- Filters --}}
    <x-dashboard.bookings.filters />




    {{-- Booking List --}}
    <section class="mt-8 space-y-5">


        @forelse($bookings as $booking)


            <x-dashboard.bookings.card
                :booking="$booking"
            />


        @empty


            <x-dashboard.bookings.empty />


        @endforelse


    </section>




    {{-- Pagination --}}
    @if($bookings->hasPages())

        <div class="mt-8">

            {{ $bookings->links() }}

        </div>

    @endif



</x-layouts.dashboard>
