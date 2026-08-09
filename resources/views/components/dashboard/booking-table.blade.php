{{-- resources/views/components/dashboard/booking-table.blade.php --}}

@props([
'bookings' => collect(),
])


@forelse($bookings as $booking)

    <a
        href="{{ route('bookings.show', $booking) }}"
        class="flex items-center justify-between rounded-xl border border-zinc-800 bg-zinc-950 p-4 transition hover:border-orange-500/40"
    >

        {{-- =====================================================
            Customer
        ====================================================== --}}

        <div class="flex items-center gap-4">

            <div
                class="flex h-11 w-11 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 font-black text-orange-500"
            >
                {{ mb_substr($booking->customer_name ?? 'م', 0, 1) }}
            </div>


            <div>

                <h4 class="font-bold text-white">
                    {{ $booking->customer_name }}
                </h4>


                <p class="text-sm text-zinc-500">
                    {{ $booking->service?->name ?? 'بدون سرویس' }}
                </p>

            </div>

        </div>



        {{-- =====================================================
            Time
        ====================================================== --}}

        <div class="hidden text-center md:block">

            <p class="text-sm text-zinc-400">
                ساعت
            </p>


            <p class="font-bold text-white">

                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}

            </p>

        </div>



        {{-- =====================================================
            Status
        ====================================================== --}}

        <div>

            @switch($booking->status)


                {{-- Pending --}}

                @case('pending')

                <span
                    class="rounded-full bg-orange-500/10 px-3 py-1 text-xs font-bold text-orange-400"
                >
                        در انتظار
                    </span>

                @break



                {{-- Approved --}}

                @case('approved')

                <span
                    class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-bold text-green-400"
                >
                        تایید شده
                    </span>

                @break



                {{-- Completed --}}

                @case('completed')

                <span
                    class="rounded-full bg-blue-500/10 px-3 py-1 text-xs font-bold text-blue-400"
                >
                        تکمیل شده
                    </span>

                @break



                {{-- Rejected --}}

                @case('rejected')

                <span
                    class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400"
                >
                        رد شده
                    </span>

                @break



                {{-- Cancelled --}}

                @case('cancelled')

                <span
                    class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-bold text-red-400"
                >
                        لغو شده
                    </span>

                @break



                {{-- Unknown --}}

                @default

                <span
                    class="rounded-full bg-zinc-500/10 px-3 py-1 text-xs font-bold text-zinc-400"
                >
                        {{ $booking->status }}
                    </span>

            @endswitch

        </div>

    </a>


@empty


    {{-- =====================================================
        Empty State
    ====================================================== --}}

    <div
        class="rounded-xl border border-zinc-800 bg-zinc-950 p-6 text-center text-zinc-500"
    >
        امروز هنوز رزروی وجود ندارد.
    </div>


@endforelse

