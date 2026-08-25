@props([
'salon',
])

<nav
    class="
        sticky
        top-0
        z-50
        border-b
        border-border
        bg-background/85
        backdrop-blur-xl
    "
>

    <div
        class="
            mx-auto
            flex
            h-16
            max-w-7xl
            items-center
            justify-between
            gap-3
            px-4
            sm:px-6
            lg:px-8
        "
    >

        {{-- =====================================================
            Salon Identity
        ====================================================== --}}

        <a
            href="#salon-page"
            class="flex min-w-0 shrink-0 items-center gap-3"
        >

            <div
                class="
                    flex
                    h-10
                    w-10
                    shrink-0
                    items-center
                    justify-center
                    overflow-hidden
                    rounded-xl
                    border
                    border-border
                    bg-surface
                "
            >

                @if(!empty($salon?->logo))

                    <img
                        src="{{ asset('storage/' . $salon->logo) }}"
                        alt="{{ $salon->name }}"
                        class="h-full w-full object-cover"
                    >

                @else

                    <span
                        class="
                            text-sm
                            font-black
                            text-primary
                        "
                    >
                        {{ mb_substr($salon->name ?? 'س', 0, 1) }}
                    </span>

                @endif

            </div>


            <div class="hidden min-w-0 sm:block">

                <div
                    class="
                        max-w-40
                        truncate
                        text-sm
                        font-black
                        text-text
                    "
                >
                    {{ $salon->name ?? 'آرایشگاه' }}
                </div>

                <div
                    class="
                        mt-0.5
                        truncate
                        text-[11px]
                        text-muted
                    "
                >
                    رزرو آنلاین نوبت
                </div>

            </div>

        </a>


        {{-- =====================================================
            Navigation
        ====================================================== --}}

        <div
            class="
                hidden
                items-center
                gap-1
                lg:flex
            "
        >

            <a
                href="#salon-page"
                class="
                    rounded-xl
                    px-4
                    py-2.5
                    text-sm
                    font-bold
                    text-primary
                    transition
                    hover:bg-primary/10
                "
            >
                خانه
            </a>


            <a
                href="#services"
                class="
                    rounded-xl
                    px-4
                    py-2.5
                    text-sm
                    font-bold
                    text-text/60
                    transition
                    hover:bg-primary/10
                    hover:text-primary
                "
            >
                خدمات
            </a>


            <a
                href="#gallery"
                class="
                    rounded-xl
                    px-4
                    py-2.5
                    text-sm
                    font-bold
                    text-text/60
                    transition
                    hover:bg-primary/10
                    hover:text-primary
                "
            >
                گالری
            </a>


            <a
                href="#reviews"
                class="
                    rounded-xl
                    px-4
                    py-2.5
                    text-sm
                    font-bold
                    text-text/60
                    transition
                    hover:bg-primary/10
                    hover:text-primary
                "
            >
                نظرات
            </a>


            <a
                href="#about"
                class="
                    rounded-xl
                    px-4
                    py-2.5
                    text-sm
                    font-bold
                    text-text/60
                    transition
                    hover:bg-primary/10
                    hover:text-primary
                "
            >
                درباره سالن
            </a>

        </div>


        {{-- =====================================================
            Booking CTA
        ====================================================== --}}

        @if($salon?->qr_token)

            <a
                href="{{ route('salon.booking.create', $salon->qr_token) }}"
                class="
                    inline-flex
                    shrink-0
                    items-center
                    gap-2
                    rounded-xl
                    bg-primary
                    px-3.5
                    py-2.5
                    text-sm
                    font-black
                    text-white
                    shadow-[0_0_25px_rgba(249,115,22,.18)]
                    transition
                    hover:bg-primary/90
                    active:scale-[0.98]
                    sm:px-4
                "
            >

                <x-lucide-calendar-plus class="h-4 w-4" />

                <span class="hidden sm:inline">
                    رزرو نوبت
                </span>

                <span class="sm:hidden">
                    رزرو
                </span>

            </a>

        @endif

    </div>

</nav>
