@props([
'salon',
'workingHours' => null,
'bookingUrl' => null,
])

@php
    $salonName = $salon?->name ?? 'آرایشگاه';

    $description = $salon?->description
        ?? 'تجربه‌ای متفاوت از اصلاح و استایل حرفه‌ای با بهترین خدمات آرایشگاهی';

    /*
    |--------------------------------------------------------------------------
    | Images
    |--------------------------------------------------------------------------
    */

    $coverImage = $salon?->cover
        ? asset('storage/' . $salon->cover)
        : asset('images/hero2.jpg');

    $logoImage = $salon?->logo
        ? asset('storage/' . $salon->logo)
        : null;

    /*
    |--------------------------------------------------------------------------
    | Booking
    |--------------------------------------------------------------------------
    */

    $bookingUrl = $bookingUrl
        ?? (
            $salon?->qr_token
                ? route('salon.booking.create', $salon->qr_token)
                : '#'
        );

    /*
    |--------------------------------------------------------------------------
    | Rating
    |--------------------------------------------------------------------------
    */

    $rating = $salon?->reviews_avg_rating !== null
        ? (float) $salon->reviews_avg_rating
        : null;

    $reviewsCount = (int) ($salon?->reviews_count ?? 0);

    /*
    |--------------------------------------------------------------------------
    | Working Hours
    |--------------------------------------------------------------------------
    */

    $workingHours = $workingHours
        ? collect($workingHours)
        : collect($salon?->workingHours ?? []);

    /*
    |--------------------------------------------------------------------------
    | Today
    |--------------------------------------------------------------------------
    |
    | We keep the project's day_of_week value if it exists.
    | Since the project uses its own Persian day mapping, we first
    | try that relation and fall back gracefully when necessary.
    |
    */

    $todayDay = now()->dayOfWeek;

    $todayWorkingHour = $workingHours->first(
        fn ($item) =>
            (int) ($item->day_of_week ?? -1) === $todayDay
    );

    /*
    |--------------------------------------------------------------------------
    | Today's Schedule
    |--------------------------------------------------------------------------
    */

    $isClosedToday = (bool) (
        $todayWorkingHour?->is_closed ?? false
    );

    $todayStart = $todayWorkingHour?->start_time;

    $todayEnd = $todayWorkingHour?->end_time;

    $todaySchedule = 'برنامه کاری ثبت نشده';

    if (
        $todayWorkingHour &&
        !$isClosedToday &&
        $todayStart &&
        $todayEnd
    ) {
        $todaySchedule =
            \Carbon\Carbon::parse($todayStart)->format('H:i')
            . ' تا '
            . \Carbon\Carbon::parse($todayEnd)->format('H:i');
    }

    /*
    |--------------------------------------------------------------------------
    | Current Salon Status
    |--------------------------------------------------------------------------
    */

    $isOpen = false;

    $statusLabel = 'اکنون بسته است';

    $statusColor = 'red';

    if (
        $todayWorkingHour &&
        !$isClosedToday &&
        $todayStart &&
        $todayEnd
    ) {
        $now = now();

        $start = \Carbon\Carbon::parse($todayStart);
        $end = \Carbon\Carbon::parse($todayEnd);

        $isOpen = $now->betweenIncluded($start, $end);
    }

    if ($isClosedToday) {
        $statusLabel = 'امروز تعطیل است';
        $statusColor = 'zinc';
    } elseif ($isOpen) {
        $statusLabel = 'اکنون باز است';
        $statusColor = 'green';
    }

@endphp


<section
    id="home"
    class="relative overflow-hidden bg-background text-text"
    dir="rtl"
>

    <div
        class="
            mx-auto
            max-w-7xl
            px-4
            py-10
            sm:px-6
            sm:py-14
            lg:px-8
            lg:py-20
        "
    >

        <div
            class="
                grid
                items-center
                gap-10
                lg:grid-cols-[0.95fr_1.05fr]
                lg:gap-14
            "
        >

            {{-- =================================================
                Content
            ================================================== --}}

            <div class="order-2 lg:order-1">

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
                        px-4
                        py-2
                        text-xs
                        font-bold
                        text-primary
                        sm:text-sm
                    "
                >

                    <span
                        class="
                            h-2
                            w-2
                            rounded-full
                            {{ $isOpen ? 'bg-green-500' : 'bg-zinc-500' }}
                            "
                    ></span>

                    رزرو آنلاین آرایشگاه

                </span>


                {{-- Identity --}}

                <div
                    class="
                        mt-5
                        flex
                        items-center
                        gap-3
                        sm:mt-6
                    "
                >

                    {{-- Logo --}}

                    <div
                        class="
                            flex
                            h-14
                            w-14
                            shrink-0
                            items-center
                            justify-center
                            overflow-hidden
                            rounded-2xl
                            border
                            border-border
                            bg-surface
                            sm:h-16
                            sm:w-16
                        "
                    >

                        @if($logoImage)

                            <img
                                src="{{ $logoImage }}"
                                alt="{{ $salonName }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <span
                                class="
                                    text-xl
                                    font-black
                                    text-primary
                                    sm:text-2xl
                                "
                            >
                                {{ mb_substr($salonName, 0, 1) }}
                            </span>

                        @endif

                    </div>


                    <div class="min-w-0">

                        <h1
                            class="
                                text-3xl
                                font-black
                                leading-tight
                                tracking-tight
                                text-text
                                sm:text-4xl
                                lg:text-5xl
                                xl:text-6xl
                            "
                        >
                            {{ $salonName }}
                        </h1>


                        {{-- Rating --}}

                        @if($rating !== null)

                            <div
                                class="
                                    mt-2
                                    flex
                                    flex-wrap
                                    items-center
                                    gap-2
                                "
                            >

                                <span
                                    class="
                                        inline-flex
                                        items-center
                                        gap-1.5
                                    "
                                >

                                    <x-lucide-star
                                        class="h-4 w-4 fill-primary text-primary"
                                    />

                                    <span
                                        class="
                                            text-sm
                                            font-black
                                            text-text
                                        "
                                    >
                                        {{ number_format($rating, 1) }}
                                    </span>

                                </span>

                                <span class="text-zinc-700">
                                    •
                                </span>

                                <span class="text-xs text-muted sm:text-sm">
                                    {{ $reviewsCount }} نظر
                                </span>

                            </div>

                        @endif

                    </div>

                </div>


                {{-- Description --}}

                <p
                    class="
                        mt-5
                        max-w-2xl
                        text-sm
                        leading-7
                        text-muted
                        sm:mt-6
                        sm:text-base
                        sm:leading-8
                        lg:text-lg
                    "
                >
                    {{ $description }}
                </p>


                {{-- =================================================
                    Quick Info
                ================================================== --}}

                <div
                    class="
                        mt-6
                        grid
                        grid-cols-1
                        gap-3
                        sm:grid-cols-2
                    "
                >

                    {{-- Status --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface
                            px-4
                            py-3
                        "
                    >

                        <div
                            class="
                                flex
                                h-10
                                w-10
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-background
                            "
                        >

                            <span
                                class="
                                    h-2.5
                                    w-2.5
                                    rounded-full
                                    {{ match ($statusColor) {
                                        'green' => 'bg-green-500',
                                        'red' => 'bg-red-500',
                                        default => 'bg-zinc-500',
                                    } }}
                                    "
                            ></span>

                        </div>


                        <div class="min-w-0">

                            <p class="text-[11px] text-muted">
                                وضعیت سالن
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-sm
                                    font-bold
                                    {{ match ($statusColor) {
                                        'green' => 'text-green-400',
                                        'red' => 'text-red-400',
                                        default => 'text-zinc-400',
                                    } }}
                                    "
                            >
                                {{ $statusLabel }}
                            </p>

                        </div>

                    </div>


                    {{-- Today's Working Hours --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface
                            px-4
                            py-3
                        "
                    >

                        <div
                            class="
                                flex
                                h-10
                                w-10
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-primary/10
                                text-primary
                            "
                        >

                            <x-lucide-clock-3 class="h-5 w-5" />

                        </div>


                        <div class="min-w-0">

                            <p class="text-[11px] text-muted">
                                ساعت کاری امروز
                            </p>

                            <p
                                class="
                                    mt-1
                                    truncate
                                    text-sm
                                    font-bold
                                    text-text
                                "
                            >
                                {{ $todaySchedule }}
                            </p>

                        </div>

                    </div>


                    {{-- Address --}}

                    @if($salon?->address)

                        <div
                            class="
                                flex
                                items-center
                                gap-3
                                rounded-2xl
                                border
                                border-border
                                bg-surface
                                px-4
                                py-3
                                sm:col-span-2
                            "
                        >

                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-xl
                                    bg-primary/10
                                    text-primary
                                "
                            >

                                <x-lucide-map-pin class="h-5 w-5" />

                            </div>


                            <div class="min-w-0">

                                <p class="text-[11px] text-muted">
                                    آدرس
                                </p>

                                <p
                                    class="
                                        mt-1
                                        line-clamp-2
                                        text-sm
                                        leading-6
                                        text-text
                                    "
                                >
                                    {{ $salon->address }}
                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    Actions
                ================================================== --}}

                <div
                    class="
                        mt-7
                        flex
                        flex-col
                        gap-3
                        sm:flex-row
                    "
                >

                    {{-- Booking --}}

                    <a
                        href="{{ $bookingUrl }}"
                        class="
                            inline-flex
                            flex-1
                            items-center
                            justify-center
                            gap-2
                            rounded-2xl
                            bg-primary
                            px-6
                            py-3.5
                            text-sm
                            font-black
                            text-white
                            shadow-[0_0_35px_rgba(249,115,22,.25)]
                            transition
                            hover:bg-primary/90
                            active:scale-[0.98]
                            sm:flex-none
                        "
                    >

                        <x-lucide-calendar-plus class="h-5 w-5" />

                        رزرو نوبت

                        <x-lucide-arrow-left class="h-4 w-4" />

                    </a>


                    {{-- Services --}}

                    <a
                        href="#services"
                        class="
                            inline-flex
                            flex-1
                            items-center
                            justify-center
                            gap-2
                            rounded-2xl
                            border
                            border-border
                            px-6
                            py-3.5
                            text-sm
                            font-bold
                            text-text
                            transition
                            hover:border-primary
                            hover:text-primary
                            sm:flex-none
                        "
                    >

                        مشاهده خدمات

                        <x-lucide-chevron-down class="h-4 w-4" />

                    </a>

                </div>

            </div>


            {{-- =================================================
                Image
            ================================================== --}}

            <div class="relative order-1 lg:order-2">

                {{-- Glow --}}

                <div
                    class="
                        absolute
                        -inset-6
                        rounded-[50px]
                        bg-primary/20
                        blur-3xl
                    "
                ></div>


                {{-- Image --}}

                <div
                    class="
                        relative
                        overflow-hidden
                        rounded-[28px]
                        border
                        border-border
                        bg-surface
                        shadow-2xl
                        shadow-black/30
                        sm:rounded-[36px]
                        lg:rounded-[45px]
                    "
                >

                    <img
                        src="{{ $coverImage }}"
                        alt="{{ $salonName }}"
                        class="
                            h-[350px]
                            w-full
                            object-cover
                            sm:h-[460px]
                            lg:h-[600px]
                        "
                    >


                    {{-- Image Overlay --}}

                    <div
                        class="
                            absolute
                            inset-0
                            bg-gradient-to-t
                            from-background/90
                            via-transparent
                            to-transparent
                        "
                    ></div>


                    {{-- Floating Card --}}

                    <div
                        class="
                            absolute
                            bottom-4
                            right-4
                            left-4
                            rounded-2xl
                            border
                            border-white/10
                            bg-background/75
                            px-4
                            py-4
                            backdrop-blur-xl
                            sm:bottom-6
                            sm:right-6
                            sm:left-6
                            sm:px-5
                            sm:py-5
                        "
                    >

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                gap-4
                            "
                        >

                            <div class="min-w-0">

                                <p class="text-xs text-muted">
                                    وضعیت فعلی سالن
                                </p>

                                <p
                                    class="
                                        mt-1
                                        text-sm
                                        font-black
                                        text-white
                                        sm:text-base
                                    "
                                >
                                    {{ $statusLabel }}
                                </p>

                            </div>


                            @if($todayStart && $todayEnd)

                                <div
                                    class="
                                        shrink-0
                                        rounded-xl
                                        border
                                        border-white/10
                                        bg-black/20
                                        px-3
                                        py-2
                                        text-center
                                    "
                                >

                                    <p class="text-[10px] text-muted">
                                        امروز
                                    </p>

                                    <p
                                        class="
                                            mt-0.5
                                            text-xs
                                            font-black
                                            text-primary
                                        "
                                    >
                                        {{ $todaySchedule }}
                                    </p>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>
