@props([
'salon',
])

@php
    $cover = $salon?->cover
        ? asset('storage/' . $salon->cover)
        : null;

    $logo = $salon?->logo
        ? asset('storage/' . $salon->logo)
        : null;

    $salonName = $salon?->name ?? 'آرایشگاه';

    $description = $salon?->description;

    $address = $salon?->address;

    $rating = $salon?->reviews_avg_rating;

    $reviewsCount = $salon?->reviews_count ?? 0;

   $url = $salon?->slug
    ? route('salon.public', ['salon' => $salon->slug])
    : '#';
@endphp

<article
    {{ $attributes->merge([
        'class' => 'group overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 transition duration-300 hover:border-orange-500/30 hover:shadow-2xl hover:shadow-black/20',
    ]) }}
>

    {{-- Cover --}}

    <div class="relative h-40 overflow-hidden bg-zinc-800 sm:h-48">

        @if($cover)

            <img
                src="{{ $cover }}"
                alt="{{ $salonName }}"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            >

        @else

            <div
                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-zinc-800 to-zinc-950"
            >

                <x-lucide-store
                    class="h-12 w-12 text-zinc-700"
                />

            </div>

        @endif


        {{-- Overlay --}}

        <div
            class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"
        ></div>


        {{-- Logo --}}

        <div
            class="absolute bottom-4 right-4 flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border-2 border-zinc-900 bg-zinc-800 shadow-xl"
        >

            @if($logo)

                <img
                    src="{{ $logo }}"
                    alt="{{ $salonName }}"
                    class="h-full w-full object-cover"
                >

            @else

                <span class="text-lg font-black text-orange-500">
                    {{ mb_substr($salonName, 0, 1) }}
                </span>

            @endif

        </div>

    </div>


    {{-- Content --}}

    <div class="p-5">

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <h3
                    class="truncate text-base font-black text-white sm:text-lg"
                >

                    {{ $salonName }}

                </h3>

                @if($address)

                    <div class="mt-2 flex items-start gap-1.5 text-xs text-zinc-500">

                        <x-lucide-map-pin
                            class="mt-0.5 h-3.5 w-3.5 shrink-0"
                        />

                        <span class="line-clamp-2">
                            {{ $address }}
                        </span>

                    </div>

                @endif

            </div>


            {{-- Rating --}}

            @if($rating !== null)

                <div
                    class="flex shrink-0 items-center gap-1 rounded-lg bg-zinc-800 px-2.5 py-1.5"
                >

                    <x-lucide-star
                        class="h-3.5 w-3.5 fill-orange-500 text-orange-500"
                    />

                    <span class="text-xs font-black text-white">
                        {{ number_format((float) $rating, 1) }}
                    </span>

                </div>

            @endif

        </div>


        {{-- Description --}}

        @if($description)

            <p class="mt-4 line-clamp-2 text-sm leading-6 text-zinc-500">

                {{ $description }}

            </p>

        @endif


        {{-- Meta --}}

        <div class="mt-4 flex items-center gap-3 text-xs text-zinc-500">

            @if($rating !== null)

                <span class="inline-flex items-center gap-1">

                    <x-lucide-star
                        class="h-3.5 w-3.5 text-orange-500"
                    />

                    {{ $reviewsCount }} نظر

                </span>

            @endif

        </div>


        {{-- Action --}}

        <a
            href="{{ $url }}"
            class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-orange-500 px-4 py-3 text-sm font-bold text-black transition hover:bg-orange-400"
        >

            مشاهده آرایشگاه

            <x-lucide-arrow-left
                class="h-4 w-4"
            />

        </a>

    </div>

</article>
