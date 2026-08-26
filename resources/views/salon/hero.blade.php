@php
    $publicUrl = route('salon.public', [
        'salon' => $salon->slug,
    ]);
@endphp


<section
    class="
        relative
        isolate
        min-h-[620px]
        overflow-hidden
        bg-black
        sm:min-h-[680px]
        lg:min-h-[720px]
    "
    dir="rtl"
>

    {{-- =========================================================
        Background
    ========================================================== --}}

    <div class="absolute inset-0">

        @if($salon?->cover)

            <img
                src="{{ Storage::url($salon->cover) }}"
                alt="{{ $salon->name }}"
                class="
                    h-full
                    w-full
                    object-cover
                    object-center
                "
            >

        @else

            <div
                class="
                    h-full
                    w-full
                    bg-gradient-to-br
                    from-zinc-900
                    via-zinc-950
                    to-black
                "
            ></div>

        @endif


        <div
            class="
                absolute
                inset-0
                bg-black/60
            "
        ></div>


        <div
            class="
                absolute
                inset-0
                bg-gradient-to-l
                from-black/85
                via-black/45
                to-black/20
            "
        ></div>

    </div>


    {{-- =========================================================
        Content
    ========================================================== --}}

    <div
        class="
            relative
            mx-auto
            flex
            min-h-[620px]
            max-w-7xl
            items-center
            px-5
            py-20
            sm:min-h-[680px]
            sm:px-6
            lg:min-h-[720px]
            lg:px-8
        "
    >

        <div class="max-w-2xl">

            {{-- Logo --}}

            <div class="mb-6">

                @if($salon?->logo)

                    <img
                        src="{{ Storage::url($salon->logo) }}"
                        alt="لوگوی {{ $salon->name }}"
                        class="
                            h-20
                            w-20
                            rounded-2xl
                            border
                            border-white/10
                            bg-black/30
                            object-cover
                            shadow-2xl
                        "
                    >

                @else

                    <div
                        class="
                            flex
                            h-20
                            w-20
                            items-center
                            justify-center
                            rounded-2xl
                            border
                            border-white/10
                            bg-white/10
                            text-2xl
                            font-black
                            text-white
                            backdrop-blur
                        "
                    >

                        {{ mb_substr($salon->name ?? 'س', 0, 1) }}

                    </div>

                @endif

            </div>


            {{-- Rating --}}

            @if($averageRating)

                <div
                    class="
                        mb-5
                        inline-flex
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-white/10
                        bg-black/30
                        px-3
                        py-2
                        backdrop-blur
                    "
                >

                    <x-lucide-star
                        class="h-4 w-4 fill-primary text-primary"
                    />

                    <span class="text-xs font-black text-white">
                        {{ number_format((float) $averageRating, 1) }}
                    </span>

                    <span class="text-[10px] text-white/60">
                        ({{ $reviewsCount }} نظر)
                    </span>

                </div>

            @endif


            {{-- Label --}}

            <span
                class="
                    inline-flex
                    items-center
                    gap-2
                    rounded-full
                    border
                    border-white/10
                    bg-white/10
                    px-4
                    py-2
                    text-xs
                    font-black
                    text-white
                    backdrop-blur
                "
            >

                <span class="h-2 w-2 rounded-full bg-primary"></span>

                رزرو آنلاین

            </span>


            {{-- Name --}}

            <h1
                class="
                    mt-6
                    text-4xl
                    font-black
                    leading-tight
                    tracking-tight
                    text-white
                    sm:text-5xl
                    lg:text-6xl
                "
            >
                {{ $salon->name }}
            </h1>


            {{-- Description --}}

            @if($salon?->description)

                <p
                    class="
                        mt-5
                        max-w-xl
                        text-sm
                        leading-8
                        text-zinc-200
                        sm:text-base
                    "
                >
                    {{ $salon->description }}
                </p>

            @endif


            {{-- Actions --}}

            <div
                class="
                    mt-8
                    flex
                    flex-col
                    gap-3
                    sm:flex-row
                "
            >

                {{-- Booking --}}

                <a
                    href="#booking"
                    class="
                        inline-flex
                        items-center
                        justify-center
                        gap-2
                        rounded-2xl
                        bg-primary
                        px-7
                        py-4
                        text-sm
                        font-black
                        text-white
                        shadow-lg
                        shadow-primary/20
                        transition
                        hover:bg-primary-hover
                        active:scale-[.98]
                    "
                >

                    <x-lucide-calendar-plus
                        class="h-5 w-5"
                    />

                    رزرو نوبت

                </a>


                {{-- Phone --}}

                @if($salon?->phone)

                    <a
                        href="tel:{{ $salon->phone }}"
                        dir="ltr"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            gap-2
                            rounded-2xl
                            border
                            border-white/10
                            bg-white/10
                            px-7
                            py-4
                            text-sm
                            font-bold
                            text-white
                            backdrop-blur
                            transition
                            hover:bg-white/15
                        "
                    >

                        <x-lucide-phone class="h-5 w-5" />

                        تماس با سالن

                    </a>

                @endif

            </div>

        </div>

    </div>

</section>
