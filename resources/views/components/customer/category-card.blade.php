{{-- resources/views/components/customer/category-card.blade.php --}}

@props([
'title',
'description' => null,
'icon' => '✂️',
'url' => null,
'active' => false,
])

@php
    $classes = $active
        ? '
            border-primary
            bg-primary/5
            shadow-lg
            shadow-primary/10
        '
        : '
            border-border
            bg-surface
            hover:border-primary/40
            hover:bg-primary/5
        ';
@endphp


@if($url)

    <a
        href="{{ $url }}"
        {{ $attributes->merge([
            'class' => "
                group
                block
                rounded-[28px]
                border
                p-5
                transition-all
                duration-300
                {$classes}
            ",
        ]) }}
    >

        <div class="flex items-start gap-4">

            <div
                class="
                    flex
                    h-12
                    w-12
                    shrink-0
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary/10
                    text-xl
                    transition
                    duration-300
                    group-hover:scale-105
                "
            >
                {{ $icon }}
            </div>

            <div class="min-w-0">

                <h3
                    class="text-sm font-black text-text"
                >
                    {{ $title }}
                </h3>

                @if($description)

                    <p
                        class="
                            mt-2
                            text-xs
                            leading-6
                            text-muted
                        "
                    >
                        {{ $description }}
                    </p>

                @endif

            </div>

        </div>


        <div
            class="
                mt-5
                flex
                items-center
                justify-between
            "
        >

            <span
                class="
                    text-xs
                    font-black
                    text-primary
                "
            >
                مشاهده
            </span>

            <span
                class="
                    text-sm
                    text-muted
                    transition
                    duration-300
                    group-hover:-translate-x-1
                    group-hover:text-primary
                "
            >
                ←
            </span>

        </div>

    </a>

@else

    <div
        {{ $attributes->merge([
            'class' => "
                rounded-[28px]
                border
                p-5
                {$classes}
            ",
        ]) }}
    >

        <div class="flex items-start gap-4">

            <div
                class="
                    flex
                    h-12
                    w-12
                    shrink-0
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary/10
                    text-xl
                "
            >
                {{ $icon }}
            </div>

            <div class="min-w-0">

                <h3
                    class="text-sm font-black text-text"
                >
                    {{ $title }}
                </h3>

                @if($description)

                    <p
                        class="
                            mt-2
                            text-xs
                            leading-6
                            text-muted
                        "
                    >
                        {{ $description }}
                    </p>

                @endif

            </div>

        </div>

    </div>

@endif
