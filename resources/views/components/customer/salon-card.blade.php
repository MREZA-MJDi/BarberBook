{{-- resources/views/components/customer/salon-card.blade.php --}}

@props([
'salon',
'url' => null,
'rating' => null,
'reviewsCount' => null,
])

@php
    $rating = $rating ?? 0;

    $reviewsCount = $reviewsCount ?? 0;

    $initial = mb_substr(
        $salon->name ?? 'س',
        0,
        1
    );

    $image = $salon->logo
        ? asset('storage/' . $salon->logo)
        : null;
@endphp


@if($url)

    <a
        href="{{ $url }}"
        {{ $attributes->merge([
            'class' => '
                group
                block
                overflow-hidden
                rounded-[28px]
                border
                border-border
                bg-surface
                transition
                duration-300
                hover:border-primary/40
                hover:shadow-lg
                hover:shadow-primary/5
            ',
        ]) }}
    >

        {{-- =====================================================
            Image
        ====================================================== --}}

        <div class="relative h-48 overflow-hidden bg-background">

            @if($image)

                <img
                    src="{{ $image }}"
                    alt="{{ $salon->name }}"
                    class="
                        h-full
                        w-full
                        object-cover
                        transition
                        duration-500
                        group-hover:scale-105
                    "
                    loading="lazy"
                >

            @else

                <div
                    class="
                        flex
                        h-full
                        w-full
                        items-center
                        justify-center
                        bg-primary/5
                    "
                >

                    <span
                        class="
                            flex
                            h-16
                            w-16
                            items-center
                            justify-center
                            rounded-2xl
                            bg-primary/10
                            text-2xl
                            font-black
                            text-primary
                        "
                    >
                        {{ $initial }}
                    </span>

                </div>

            @endif


            {{-- Rating --}}
            @if($reviewsCount > 0)

                <div
                    class="
                        absolute
                        right-4
                        top-4
                        inline-flex
                        items-center
                        gap-1.5
                        rounded-full
                        border
                        border-white/10
                        bg-background/80
                        px-3
                        py-1.5
                        text-xs
                        font-black
                        text-text
                        backdrop-blur
                    "
                >

                    <span class="text-primary">
                        ★
                    </span>

                    {{ number_format((float) $rating, 1) }}

                </div>

            @endif

        </div>


        {{-- =====================================================
            Content
        ====================================================== --}}

        <div class="p-5">

            <h3
                class="
                    truncate
                    text-base
                    font-black
                    text-text
                "
            >
                {{ $salon->name }}
            </h3>


            @if($salon->address)

                <p
                    class="
                        mt-2
                        line-clamp-2
                        text-xs
                        leading-6
                        text-muted
                    "
                >
                    {{ $salon->address }}
                </p>

            @endif


            <div
                class="
                    mt-5
                    flex
                    items-center
                    justify-between
                    gap-3
                "
            >

                @if($reviewsCount > 0)

                    <span
                        class="text-xs font-bold text-muted"
                    >
                        {{ $reviewsCount }} نظر
                    </span>

                @else

                    <span
                        class="text-xs font-bold text-muted"
                    >
                        هنوز نظری ثبت نشده
                    </span>

                @endif


                <span
                    class="
                        text-xs
                        font-black
                        text-primary
                        transition
                        duration-300
                        group-hover:-translate-x-1
                    "
                >
                    مشاهده سالن ←
                </span>

            </div>

        </div>

    </a>

@else

    <article
        {{ $attributes->merge([
            'class' => '
                overflow-hidden
                rounded-[28px]
                border
                border-border
                bg-surface
            ',
        ]) }}
    >

        <div class="relative h-48 overflow-hidden bg-background">

            @if($image)

                <img
                    src="{{ $image }}"
                    alt="{{ $salon->name }}"
                    class="h-full w-full object-cover"
                    loading="lazy"
                >

            @else

                <div
                    class="
                        flex
                        h-full
                        w-full
                        items-center
                        justify-center
                        bg-primary/5
                    "
                >

                    <span
                        class="
                            flex
                            h-16
                            w-16
                            items-center
                            justify-center
                            rounded-2xl
                            bg-primary/10
                            text-2xl
                            font-black
                            text-primary
                        "
                    >
                        {{ $initial }}
                    </span>

                </div>

            @endif

        </div>


        <div class="p-5">

            <h3 class="text-base font-black text-text">
                {{ $salon->name }}
            </h3>

            @if($salon->address)

                <p class="mt-2 text-xs leading-6 text-muted">
                    {{ $salon->address }}
                </p>

            @endif

        </div>

    </article>

@endif
