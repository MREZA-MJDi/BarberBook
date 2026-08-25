@extends('layouts.app')

@section('title', ($salon->name ?? 'آرایشگاه') . ' | رزرو آنلاین')

@section('description')
    {{ $salon->description ?? 'رزرو آنلاین نوبت و مشاهده نمونه‌کارهای آرایشگاه' }}
@endsection

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $rating = $averageRating
            ?? $salon?->reviews_avg_rating
            ?? null;

        $reviewsTotal = $reviewsCount
            ?? $salon?->reviews_count
            ?? 0;

        $servicesCount =
            $salon?->services?->count() ?? 0;


        /*
        |--------------------------------------------------------------------------
        | Gallery
        |--------------------------------------------------------------------------
        */

        $galleryItems = collect(
            $galleryItems ?? []
        )
            ->filter(function ($item) {

                return filled($item->before_image)
                    && filled($item->after_image)
                    && (bool) $item->is_active;

            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Gallery Preview
        |--------------------------------------------------------------------------
        */

        $galleryPreview =
            $galleryItems->take(6);

        $hasMoreGallery =
            $galleryItems->count() > 6;

    @endphp


    <div
        class="relative overflow-hidden bg-background text-text"
        dir="rtl"
    >


        {{-- =========================================================
            HERO
        ========================================================== --}}

        <section id="home">

            @include('salon.hero', [
                'salon' => $salon,
                'averageRating' => $averageRating,
                'reviewsCount' => $reviewsCount,
            ])

        </section>


        {{-- =========================================================
            QUICK HIGHLIGHTS
        ========================================================== --}}

        <section
            class="border-y border-border bg-background"
        >

            <div
                class="
                    mx-auto
                    max-w-7xl
                    px-4
                    py-5
                    sm:px-6
                    sm:py-7
                    lg:px-8
                "
            >

                <div
                    class="
                        grid
                        gap-3
                        sm:grid-cols-2
                        lg:grid-cols-4
                    "
                >

                    {{-- Rating --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface/70
                            p-4
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

                            <x-lucide-star
                                class="h-5 w-5 fill-primary"
                            />

                        </div>


                        <div class="min-w-0">

                            <p class="text-[10px] text-muted">
                                امتیاز مشتریان
                            </p>

                            <div
                                class="
                                    mt-1
                                    flex
                                    items-center
                                    gap-2
                                "
                            >

                                <strong
                                    class="text-sm font-black text-text"
                                >
                                    {{ $rating !== null
                                        ? number_format((float) $rating, 1)
                                        : '—'
                                    }}
                                </strong>

                                <span class="text-[11px] text-muted">
                                    {{ $reviewsTotal }} نظر
                                </span>

                            </div>

                        </div>

                    </div>


                    {{-- Services --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface/70
                            p-4
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

                            <x-lucide-scissors class="h-5 w-5" />

                        </div>


                        <div>

                            <p class="text-[10px] text-muted">
                                خدمات سالن
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-sm
                                    font-black
                                    text-text
                                "
                            >

                                {{ $servicesCount }}

                                <span class="font-medium text-muted">
                                    خدمت
                                </span>

                            </p>

                        </div>

                    </div>


                    {{-- Online Booking --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface/70
                            p-4
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

                            <x-lucide-calendar-check-2
                                class="h-5 w-5"
                            />

                        </div>


                        <div>

                            <p class="text-[10px] text-muted">
                                نوبت‌دهی
                            </p>

                            <p class="mt-1 text-sm font-black text-text">
                                رزرو آنلاین
                            </p>

                        </div>

                    </div>


                    {{-- Phone --}}

                    <div
                        class="
                            flex
                            items-center
                            gap-3
                            rounded-2xl
                            border
                            border-border
                            bg-surface/70
                            p-4
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

                            <x-lucide-phone class="h-5 w-5" />

                        </div>


                        <div class="min-w-0">

                            <p class="text-[10px] text-muted">
                                تماس
                            </p>

                            @if($salon?->phone)

                                <a
                                    href="tel:{{ $salon->phone }}"
                                    dir="ltr"
                                    class="
                                        mt-1
                                        block
                                        truncate
                                        text-sm
                                        font-black
                                        text-text
                                        transition
                                        hover:text-primary
                                    "
                                >
                                    {{ $salon->phone }}
                                </a>

                            @else

                                <p class="mt-1 text-sm font-black text-text">
                                    اطلاعات تماس
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </section>


        {{-- =========================================================
            GALLERY
        ========================================================== --}}

        @if($galleryPreview->isNotEmpty())

            <x-salon.gallery
                :salon="$salon"
                :gallery-items="$galleryPreview"
                :has-more="$hasMoreGallery"
                :total-count="$galleryItems->count()"
            />

        @endif


        {{-- =========================================================
            BOOKING
        ========================================================== --}}

        <x-salon.booking
            :salon="$salon"
            :selected-date="$selectedDate"
            :jalali-date="$jalaliDate"
            :selected-service="$selectedService"
            :available-slots="$availableSlots"
            :selected-time="$selectedTime"
        />


        {{-- =========================================================
            BOOKING TRACKING
        ========================================================== --}}

        <section
            id="track-booking"
            class="border-y border-border bg-surface/20"
        >

            <div
                class="
                    mx-auto
                    max-w-7xl
                    px-4
                    py-8
                    sm:px-6
                    lg:px-8
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-4
                        rounded-3xl
                        border
                        border-border
                        bg-surface
                        p-5
                        sm:p-6
                        lg:flex-row
                        lg:items-center
                        lg:justify-between
                    "
                >

                    <div>

                        <p class="text-xs font-black text-primary">
                            پیگیری نوبت
                        </p>

                        <h2 class="mt-2 text-lg font-black text-text">
                            قبلاً نوبت گرفتی؟
                        </h2>

                        <p class="mt-2 text-xs leading-6 text-muted">
                            با کد رهگیری و شماره موبایلت وضعیت نوبتت را مشاهده کن.
                        </p>

                    </div>


                    <a
                        href="{{ route('booking.track.form') }}"
                        class="
                            inline-flex
                            w-full
                            items-center
                            justify-center
                            gap-2
                            rounded-2xl
                            border
                            border-primary/30
                            bg-primary/10
                            px-6
                            py-3.5
                            text-sm
                            font-black
                            text-primary
                            transition
                            hover:bg-primary/20
                            sm:w-auto
                        "
                    >

                        <x-lucide-search-check
                            class="h-4 w-4"
                        />

                        پیگیری نوبت

                    </a>

                </div>

            </div>

        </section>


        {{-- =========================================================
            SALON INFO
        ========================================================== --}}

        <section id="info">

            <x-salon.info
                :salon="$salon"
            />

        </section>


        {{-- =========================================================
            REVIEWS
        ========================================================== --}}

        @if($reviews->count())

            <section
                id="reviews"
                class="border-t border-border bg-surface/20"
            >

                <div
                    class="
                        mx-auto
                        max-w-7xl
                        px-4
                        py-12
                        sm:px-6
                        lg:px-8
                    "
                >

                    <div class="mb-7">

                        <span
                            class="
                                inline-flex
                                items-center
                                gap-2
                                text-xs
                                font-black
                                text-primary
                            "
                        >

                            <span class="h-px w-7 bg-primary"></span>

                            نظرات مشتریان

                        </span>


                        <h2
                            class="
                                mt-3
                                text-2xl
                                font-black
                                text-text
                                sm:text-3xl
                            "
                        >
                            تجربه مشتریان
                        </h2>

                    </div>


                    <x-salon.reviews
                        :salon="$salon"
                        :reviews="$reviews"
                    />

                </div>

            </section>

        @endif


        {{-- =========================================================
            FINAL CTA
        ========================================================== --}}

        <section
            class="
                border-t
                border-border
                bg-background
            "
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
                "
            >

                <div
                    class="
                        flex
                        flex-col
                        gap-5
                        rounded-[28px]
                        border
                        border-primary/20
                        bg-gradient-to-br
                        from-primary/10
                        via-surface
                        to-background
                        p-6
                        sm:p-8
                        lg:flex-row
                        lg:items-center
                        lg:justify-between
                    "
                >

                    <div>

                        <span class="text-xs font-black text-primary">
                            آماده‌ای؟
                        </span>

                        <h2
                            class="
                                mt-2
                                text-xl
                                font-black
                                text-text
                                sm:text-2xl
                            "
                        >
                            نوبتت رو رزرو کن
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            زمان مناسب خودت رو انتخاب کن و نوبتت رو ثبت کن.
                        </p>

                    </div>


                    <a
                        href="#booking"
                        class="
                            inline-flex
                            w-full
                            items-center
                            justify-center
                            gap-2
                            rounded-xl
                            bg-primary
                            px-6
                            py-3.5
                            text-sm
                            font-black
                            text-white
                            transition
                            hover:bg-primary-hover
                            sm:w-auto
                        "
                    >

                        <x-lucide-calendar-plus class="h-5 w-5" />

                        رزرو نوبت

                    </a>

                </div>

            </div>

        </section>

    </div>

@endsection
