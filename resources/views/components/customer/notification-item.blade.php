@props([
'notification',
])

@php
    $bookingId = data_get($notification, 'booking_id');
    $title = data_get($notification, 'title', 'اعلان جدید');
    $message = data_get($notification, 'message');
    $date = data_get($notification, 'date');
    $time = data_get($notification, 'time');
    $createdAt = data_get($notification, 'created_at');
    $type = data_get($notification, 'type', 'default');

    $icon = match ($type) {
        'booking',
        'booking_created',
        'booking_approved',
        'booking_rejected',
        'booking_completed' => 'calendar-days',

        'review' => 'star',

        'payment' => 'wallet',

        'system' => 'info',

        default => 'bell',
    };

    $iconClass = match ($type) {
        'booking_approved',
        'booking_completed' => 'border-green-500/20 bg-green-500/10 text-green-400',

        'booking_rejected' => 'border-red-500/20 bg-red-500/10 text-red-400',

        'review' => 'border-yellow-500/20 bg-yellow-500/10 text-yellow-400',

        'payment' => 'border-blue-500/20 bg-blue-500/10 text-blue-400',

        default => 'border-orange-500/20 bg-orange-500/10 text-orange-500',
    };

    $url = $bookingId
        ? route('customer.bookings.show', $bookingId)
        : route('customer.notifications.index');
@endphp

<a
    href="{{ $url }}"
    {{ $attributes->merge([
        'class' => 'group flex items-start gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/60 p-4 transition hover:border-orange-500/30 hover:bg-zinc-900',
    ]) }}
>

    {{-- Icon --}}

    <div
        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border {{ $iconClass }}"
    >

        <x-dynamic-component
            :component="'lucide-' . $icon"
            class="h-5 w-5"
        />

    </div>


    {{-- Content --}}

    <div class="min-w-0 flex-1">

        {{-- Title --}}

        <div class="flex items-start justify-between gap-3">

            <h3 class="min-w-0 text-sm font-bold text-white">

                {{ $title }}

            </h3>

            @if(data_get($notification, 'unread', false))

                <span
                    class="mt-1 h-2 w-2 shrink-0 rounded-full bg-orange-500"
                ></span>

            @endif

        </div>


        {{-- Message --}}

        @if($message)

            <p class="mt-1.5 line-clamp-2 text-xs leading-5 text-zinc-400">

                {{ $message }}

            </p>

        @endif


        {{-- Booking Info --}}

        @if($date || $time)

            <div class="mt-3 flex flex-wrap items-center gap-x-4 gap-y-2">

                @if($date)

                    <span
                        class="inline-flex items-center gap-1.5 text-[11px] text-zinc-500"
                    >

                        <x-lucide-calendar
                            class="h-3.5 w-3.5"
                        />

                        {{ $date }}

                    </span>

                @endif


                @if($time)

                    <span
                        class="inline-flex items-center gap-1.5 text-[11px] font-bold text-orange-400"
                    >

                        <x-lucide-clock
                            class="h-3.5 w-3.5"
                        />

                        {{ $time }}

                    </span>

                @endif

            </div>

        @endif


        {{-- Footer --}}

        @if($createdAt)

            <div class="mt-3 flex items-center justify-between gap-3">

                <span class="text-[10px] text-zinc-600">

                    {{ $createdAt }}

                </span>


                @if($bookingId)

                    <span
                        class="inline-flex items-center gap-1 text-[10px] font-bold text-zinc-600 transition group-hover:text-orange-400"
                    >

                        مشاهده نوبت

                        <x-lucide-arrow-left
                            class="h-3 w-3"
                        />

                    </span>

                @endif

            </div>

        @endif

    </div>

</a>
