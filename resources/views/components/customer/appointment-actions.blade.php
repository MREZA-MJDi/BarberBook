@props([
'booking',
])

@php
    $status = $booking?->status ?? 'pending';

    $canCancel = in_array($status, [
        'pending',
        'approved',
        'confirmed',
    ]);

    $canReview = $status === 'completed';
@endphp

<div
    {{ $attributes->merge([
        'class' => 'flex flex-wrap items-center gap-2',
    ]) }}
>

    {{-- View Details --}}

    @if($booking?->id)

        <a
            href="{{ route('customer.bookings.show', $booking) }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-2.5 text-sm font-bold text-black transition hover:bg-orange-400"
        >

            <x-lucide-eye class="h-4 w-4" />

            جزئیات نوبت

        </a>

    @endif


    {{-- Review --}}

    @if($canReview)

        <a
            href="{{ route('customer.reviews.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-yellow-500/20 bg-yellow-500/10 px-4 py-2.5 text-sm font-bold text-yellow-400 transition hover:bg-yellow-500/20"
        >

            <x-lucide-star class="h-4 w-4" />

            ثبت نظر

        </a>

    @endif


    {{-- Cancel --}}

    @if($canCancel && $booking?->id)

        <form
            method="POST"
            action="{{ route('customer.bookings.cancel', $booking) }}"
            onsubmit="return confirm('آیا از لغو این نوبت مطمئن هستید؟')"
        >

            @csrf
            @method('PATCH')

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-2.5 text-sm font-bold text-red-400 transition hover:bg-red-500 hover:text-white"
            >

                <x-lucide-calendar-x class="h-4 w-4" />

                لغو نوبت

            </button>

        </form>

    @endif

</div>
