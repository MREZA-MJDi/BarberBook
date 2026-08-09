@props([
'booking'
])

<div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">


    {{-- Customer --}}
    <div class="flex items-center gap-4">

        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl
            border border-orange-500/20 bg-orange-500/10
            text-lg font-black text-orange-500"
        >
            {{ mb_substr($booking->customer_name ?? 'م', 0, 1) }}
        </div>


        <div>

            <h3 class="font-black text-white">
                {{ $booking->customer_name }}
            </h3>

            <p class="text-sm text-zinc-500">
                {{ $booking->service?->name ?? '-' }}
            </p>

        </div>

    </div>


    {{-- Date --}}
    <div>

        <p class="text-xs text-zinc-500">
            زمان رزرو
        </p>

        <p class="mt-1 font-bold text-white">

            {{ $booking->booking_date }}

            -

            {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}

        </p>

    </div>


    {{-- Status --}}
    <x-dashboard.bookings.status
        :status="$booking->status"
    />


    {{-- Actions --}}
    <div class="flex flex-wrap items-center gap-2">


        {{-- Pending --}}
        @if($booking->status === 'pending')

            <form
                action="{{ route('bookings.approve', $booking) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="rounded-xl bg-green-500/10
                    px-4 py-2 text-sm font-bold text-green-400
                    transition hover:bg-green-500/20"
                >
                    تأیید
                </button>

            </form>


            <form
                action="{{ route('bookings.reject', $booking) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="rounded-xl bg-red-500/10
                    px-4 py-2 text-sm font-bold text-red-400
                    transition hover:bg-red-500/20"
                >
                    رد
                </button>

            </form>

        @endif


        {{-- Approved --}}
        @if($booking->status === 'approved')

            <form
                action="{{ route('bookings.complete', $booking) }}"
                method="POST"
            >

                @csrf
                @method('PATCH')

                <button
                    type="submit"
                    class="rounded-xl bg-blue-500/10
                    px-4 py-2 text-sm font-bold text-blue-400
                    transition hover:bg-blue-500/20"
                >
                    تکمیل
                </button>

            </form>

        @endif


        {{-- Show --}}
        <a
            href="{{ route('bookings.show', $booking) }}"
            class="rounded-xl border border-zinc-700
            px-4 py-2 text-sm font-bold text-white
            transition hover:border-orange-500
            hover:text-orange-500"
        >
            مشاهده
        </a>

    </div>

</div>
