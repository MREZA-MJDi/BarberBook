@props([
'booking',
])

@php

    $status = $booking?->status ?? 'pending';

    $date = $booking?->booking_date
        ? \Carbon\Carbon::parse($booking->booking_date)
            ->locale('fa')
            ->translatedFormat('j F Y')
        : '---';

    $time = $booking?->booking_time
        ? \Carbon\Carbon::parse($booking->booking_time)->format('H:i')
        : '---';

    $serviceName = $booking?->service?->name ?? 'خدمت';

    $salonName = $booking?->salon?->name ?? 'آرایشگاه';

    $price = $booking?->final_price;

@endphp

<article
    {{ $attributes->merge([
        'class' => 'group overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 transition duration-300 hover:border-orange-500/30',
    ]) }}
>

    {{-- Header --}}

    <div class="flex items-start justify-between gap-4 border-b border-zinc-800 p-4 sm:p-5">

        <div class="flex min-w-0 items-center gap-3">

            {{-- Icon --}}

            <div
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10 text-orange-500"
            >

                <x-lucide-calendar-days class="h-5 w-5" />

            </div>


            {{-- Salon / Service --}}

            <div class="min-w-0">

                <h3 class="truncate text-sm font-black text-white sm:text-base">

                    {{ $serviceName }}

                </h3>

                <p class="mt-1 truncate text-xs text-zinc-500">

                    {{ $salonName }}

                </p>

            </div>

        </div>


        {{-- Status --}}

        <div class="shrink-0">

            <x-customer.appointment-status
                :status="$status"
            />

        </div>

    </div>


    {{-- Details --}}

    <div class="grid grid-cols-2 gap-3 p-4 sm:grid-cols-3 sm:p-5">

        {{-- Date --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950/60 p-3"
        >

            <div class="flex items-center gap-2 text-zinc-500">

                <x-lucide-calendar
                    class="h-4 w-4"
                />

                <span class="text-[11px]">
                    تاریخ
                </span>

            </div>

            <p class="mt-2 text-sm font-bold text-white">

                {{ $date }}

            </p>

        </div>


        {{-- Time --}}

        <div
            class="rounded-xl border border-zinc-800 bg-zinc-950/60 p-3"
        >

            <div class="flex items-center gap-2 text-zinc-500">

                <x-lucide-clock
                    class="h-4 w-4"
                />

                <span class="text-[11px]">
                    ساعت
                </span>

            </div>

            <p class="mt-2 text-sm font-bold text-white">

                {{ $time }}

            </p>

        </div>


        {{-- Price --}}

        <div
            class="col-span-2 rounded-xl border border-zinc-800 bg-zinc-950/60 p-3 sm:col-span-1"
        >

            <div class="flex items-center gap-2 text-zinc-500">

                <x-lucide-wallet
                    class="h-4 w-4"
                />

                <span class="text-[11px]">
                    مبلغ
                </span>

            </div>

            <p class="mt-2 text-sm font-bold text-white">

                @if($price !== null)

                    {{ number_format((float) $price) }}

                    <span class="text-[10px] font-normal text-zinc-500">
                        تومان
                    </span>

                @else

                    ---

                @endif

            </p>

        </div>

    </div>


    {{-- Reference --}}

    @if($booking?->reference_code)

        <div class="px-4 sm:px-5">

            <div
                class="flex items-center justify-between gap-3 rounded-xl border border-dashed border-zinc-800 bg-zinc-950/40 px-3 py-2.5"
            >

                <span class="text-xs text-zinc-500">
                    کد پیگیری
                </span>

                <span
                    dir="ltr"
                    class="font-mono text-xs font-bold text-orange-400"
                >

                    {{ $booking->reference_code }}

                </span>

            </div>

        </div>

    @endif


    {{-- Actions --}}

    <div class="flex items-center gap-2 p-4 sm:p-5">

        @if($booking?->id)

            <a
                href="{{ route('customer.bookings.show', $booking) }}"
                class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-3 text-xs font-bold text-black transition hover:bg-orange-400 sm:text-sm"
            >

                مشاهده جزئیات

                <x-lucide-arrow-left
                    class="h-4 w-4"
                />

            </a>

        @endif


        @if($booking?->reference_code)

            <button
                type="button"
                onclick="navigator.clipboard?.writeText('{{ $booking->reference_code }}')"
                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-zinc-800 bg-zinc-950 text-zinc-400 transition hover:border-orange-500/30 hover:text-orange-500"
                title="کپی کد پیگیری"
            >

                <x-lucide-copy
                    class="h-4 w-4"
                />

            </button>

        @endif

    </div>

</article>
