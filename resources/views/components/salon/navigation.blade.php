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
            gap-6
            px-5
            sm:px-6
            lg:px-8
        "
    >

        {{-- =====================================================
            Salon Identity
        ====================================================== --}}

        <a
            href="#home"
            class="flex min-w-0 items-center gap-3"
        >

            {{-- Logo --}}
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

                @if(!empty($salon->logo))

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


            {{-- Name --}}
            <div class="hidden min-w-0 sm:block">

                <div
                    class="
                        truncate
                        text-sm
                        font-black
                        text-text
                    "
                >
                    {{ $salon->name }}
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
            Desktop Navigation
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
                href="#home"
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
                href="{{ route('salon.services', $salon->slug) }}"
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
                href="{{ route('salon.gallery', $salon->slug) }}"
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
                href="{{ route('salon.reviews', $salon->slug) }}"
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
                href="{{ route('salon.about', $salon->slug) }}"
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

        <a
            href="#booking"
            class="
                inline-flex
                shrink-0
                items-center
                gap-2
                rounded-xl
                bg-primary
                px-4
                py-2.5
                text-sm
                font-black
                text-white
                shadow-[0_0_25px_rgba(249,115,22,.18)]
                transition
                hover:bg-primary/90
            "
        >

            <svg
                class="h-4 w-4"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >

                <rect
                    x="3"
                    y="4"
                    width="18"
                    height="17"
                    rx="3"
                />

                <path
                    stroke-linecap="round"
                    d="M16 2v4M8 2v4M3 9h18"
                />

            </svg>

            <span class="hidden sm:inline">
                رزرو نوبت
            </span>

            <span class="sm:hidden">
                رزرو
            </span>

        </a>

    </div>

</nav>
