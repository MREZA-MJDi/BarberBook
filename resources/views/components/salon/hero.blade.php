{{-- resources/views/salon/hero.blade.php --}}

@php
    $rating = (float) ($averageRating ?? 0);
    $reviewCount = (int) ($reviewsCount ?? 0);
@endphp

<section
    class="relative overflow-hidden bg-background text-text"
    dir="rtl"
>

    <div class="mx-auto max-w-7xl px-6 py-20 lg:py-28">

        <div class="grid items-center gap-12 lg:grid-cols-2">

            {{-- =====================================================
                Content
            ====================================================== --}}

            <div>

                {{-- Badge --}}

                <span
                    class="
                        inline-flex
                        items-center
                        gap-2
                        rounded-full
                        border
                        border-primary/20
                        bg-primary/10
                        px-5
                        py-2
                        text-sm
                        font-bold
                        text-primary
                    "
                >
                    ✨ رزرو آنلاین آرایشگاه
                </span>


                {{-- Title --}}

                <h1
                    class="
                        mt-7
                        text-4xl
                        font-black
                        leading-tight
                        text-text
                        lg:text-6xl
                    "
                >
                    {{ $salon->name }}
                </h1>


                {{-- Description --}}

                @if($salon->description)

                    <p
                        class="
                            mt-6
                            max-w-xl
                            text-lg
                            leading-9
                            text-muted
                        "
                    >
                        {{ $salon->description }}
                    </p>

                @endif


                {{-- =================================================
                    Stats
                ================================================== --}}

                <div class="mt-8 flex flex-wrap gap-4">

                    {{-- Rating --}}

                    <div
                        class="
                            rounded-2xl
                            border
                            border-border
                            bg-surface
                            px-5
                            py-3
                        "
                    >

                        <div class="flex items-center gap-2">

                            <span class="text-lg">
                                ⭐
                            </span>

                            <span class="font-black text-primary">
                                {{ number_format($rating, 1) }}
                            </span>

                            <span class="text-sm text-muted">
                                / ۵
                            </span>

                        </div>

                        <p class="mt-1 text-xs text-muted">
                            از {{ number_format($reviewCount) }} نظر مشتری
                        </p>

                    </div>


                    {{-- Address --}}

                    @if($salon->address)

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-surface
                                px-5
                                py-3
                            "
                        >

                            <div class="flex items-start gap-2">

                                <span class="text-lg">
                                    📍
                                </span>

                                <div>

                                    <p class="text-sm font-bold text-text">
                                        آدرس سالن
                                    </p>

                                    <p
                                        class="
                                            mt-1
                                            max-w-[240px]
                                            text-xs
                                            leading-5
                                            text-muted
                                        "
                                    >
                                        {{ $salon->address }}
                                    </p>

                                </div>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    Contact
                ================================================== --}}

                <div class="mt-4 flex flex-wrap gap-3">

                    @if($salon->phone)

                        <a
                            href="tel:{{ $salon->phone }}"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                border
                                border-border
                                bg-surface
                                px-4
                                py-2.5
                                text-sm
                                font-bold
                                text-text
                                transition
                                hover:border-primary
                                hover:text-primary
                            "
                        >
                            📞
                            {{ $salon->phone }}
                        </a>

                    @endif


                    @if($salon->instagram)

                        <a
                            href="{{ str_starts_with($salon->instagram, 'http')
                                ? $salon->instagram
                                : 'https://instagram.com/' . ltrim($salon->instagram, '@')
                            }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="
                                inline-flex
                                items-center
                                gap-2
                                rounded-xl
                                border
                                border-border
                                bg-surface
                                px-4
                                py-2.5
                                text-sm
                                font-bold
                                text-text
                                transition
                                hover:border-primary
                                hover:text-primary
                            "
                        >
                            📷
                            Instagram
                        </a>

                    @endif

                </div>


                {{-- =================================================
                    Buttons
                ================================================== --}}

                <div class="mt-10 flex flex-wrap gap-4">

                    <a
                        href="#booking"
                        class="
                            rounded-2xl
                            bg-primary
                            px-8
                            py-4
                            font-black
                            text-white
                            shadow-[0_0_35px_rgba(249,115,22,.25)]
                            transition
                            hover:bg-primary/90
                        "
                    >
                        رزرو نوبت
                    </a>


                    <a
                        href="#reviews"
                        class="
                            rounded-2xl
                            border
                            border-border
                            px-8
                            py-4
                            font-bold
                            text-text
                            transition
                            hover:border-primary
                            hover:text-primary
                        "
                    >
                        مشاهده نظرات
                    </a>

                </div>

            </div>


            {{-- =====================================================
                Image
            ====================================================== --}}

            <div class="relative">

                {{-- Glow --}}

                <div
                    class="
                        pointer-events-none
                        absolute
                        -inset-5
                        rounded-[50px]
                        bg-primary/20
                        blur-3xl
                    "
                ></div>


                <div
                    class="
                        relative
                        overflow-hidden
                        rounded-[45px]
                        border
                        border-border
                    "
                >

                    <img
                        src="{{ asset('images/hero2.jpg') }}"
                        alt="{{ $salon->name }}"
                        class="h-[550px] w-full object-cover"
                    >


                    {{-- Overlay --}}

                    <div
                        class="
                            absolute
                            inset-0
                            bg-gradient-to-t
                            from-background/90
                            via-transparent
                        "
                    ></div>


                    {{-- Floating Card --}}

                    <div
                        class="
                            absolute
                            bottom-6
                            right-6
                            rounded-3xl
                            border
                            border-border
                            bg-background/80
                            px-6
                            py-4
                            backdrop-blur
                        "
                    >

                        <p class="text-sm text-muted">
                            امتیاز مشتریان
                        </p>

                        <div class="mt-1 flex items-center gap-2">

                            <span class="text-xl">
                                ⭐
                            </span>

                            <span class="font-black text-primary">
                                {{ number_format($rating, 1) }}
                            </span>

                            <span class="text-sm text-muted">
                                از ۵
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
