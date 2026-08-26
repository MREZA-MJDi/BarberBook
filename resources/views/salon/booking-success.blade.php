{{-- resources/views/salon/booking-success.blade.php --}}

@extends('layouts.app')

@section('title', 'رزرو با موفقیت ثبت شد | ' . ($salon->name ?? 'آرایشگاه'))

@section('content')

    <main
        class="
            min-h-screen
            bg-background
            px-4
            py-12
            sm:px-6
            sm:py-16
            lg:px-8
        "
        dir="rtl"
    >

        <div class="mx-auto w-full max-w-3xl">

            {{-- =====================================================
                Success Header
            ====================================================== --}}

            <div class="text-center">

                <div
                    class="
                        mx-auto
                        flex
                        h-20
                        w-20
                        items-center
                        justify-center
                        rounded-full
                        bg-emerald-500/10
                        text-4xl
                        font-black
                        text-emerald-400
                    "
                >
                    ✓
                </div>


                <p
                    class="
                        mt-6
                        text-sm
                        font-black
                        text-emerald-400
                    "
                >
                    رزرو با موفقیت ثبت شد
                </p>


                <h1
                    class="
                        mt-3
                        text-3xl
                        font-black
                        text-text
                        sm:text-4xl
                    "
                >
                    نوبتت با موفقیت ثبت شد 🎉
                </h1>


                <p
                    class="
                        mx-auto
                        mt-4
                        max-w-2xl
                        text-sm
                        leading-8
                        text-muted
                        sm:text-base
                    "
                >
                    درخواست نوبت شما برای آرایشگاه ثبت شده است.
                    اطلاعات رزرو را در پایین مشاهده کنید.
                </p>

            </div>


            {{-- =====================================================
                Booking Card
            ====================================================== --}}

            <div
                class="
                    mt-10
                    overflow-hidden
                    rounded-[32px]
                    border
                    border-border
                    bg-surface
                    shadow-xl
                    shadow-black/5
                    sm:mt-12
                "
            >

                {{-- Salon Header --}}

                <div
                    class="
                        border-b
                        border-border
                        bg-primary/5
                        p-5
                        sm:p-8
                    "
                >

                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                        "
                    >

                        <div class="min-w-0">

                            <p class="text-sm font-bold text-primary">
                                رزرو در
                            </p>


                            <h2
                                class="
                                    mt-2
                                    truncate
                                    text-2xl
                                    font-black
                                    text-text
                                "
                            >
                                {{ $salon->name }}
                            </h2>

                        </div>


                        <div
                            class="
                                inline-flex
                                w-fit
                                shrink-0
                                items-center
                                gap-2
                                rounded-full
                                bg-amber-500/10
                                px-4
                                py-2
                                text-sm
                                font-black
                                text-amber-400
                            "
                        >

                            <span
                                class="
                                    h-2.5
                                    w-2.5
                                    rounded-full
                                    bg-amber-400
                                "
                            ></span>

                            در انتظار تأیید

                        </div>

                    </div>

                </div>


                {{-- Booking Details --}}

                <div class="p-5 sm:p-8">

                    <div class="grid gap-4 sm:grid-cols-2">


                        {{-- Reference --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-primary/20
                                bg-primary/5
                                p-5
                                sm:col-span-2
                            "
                        >

                            <div
                                class="
                                    flex
                                    flex-col
                                    gap-4
                                    sm:flex-row
                                    sm:items-center
                                    sm:justify-between
                                "
                            >

                                <div>

                                    <p class="text-sm text-muted">
                                        کد پیگیری
                                    </p>

                                    <p
                                        class="
                                            mt-2
                                            break-all
                                            text-xl
                                            font-black
                                            tracking-wide
                                            text-primary
                                        "
                                    >
                                        {{ $booking->reference_code }}
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
                                        rounded-xl
                                        bg-primary
                                        px-5
                                        py-3
                                        text-sm
                                        font-black
                                        text-white
                                        transition
                                        hover:bg-primary-hover
                                        sm:w-auto
                                    "
                                >

                                    <x-lucide-search-check class="h-4 w-4" />

                                    پیگیری نوبت

                                </a>

                            </div>

                        </div>


                        {{-- Service --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm text-muted">
                                خدمت
                            </p>

                            <p class="mt-2 font-black text-text">
                                {{ $booking->service?->name ?? 'خدمت انتخاب‌شده' }}
                            </p>

                        </div>


                        {{-- Date --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm text-muted">
                                تاریخ
                            </p>

                            <p class="mt-2 font-black text-text">

                                @php
                                    $jalaliBookingDate = null;

                                    try {
                                        $jalaliBookingDate = \Morilog\Jalali\Jalalian::fromCarbon(
                                            \Carbon\Carbon::parse($booking->booking_date)
                                        )->format('Y/m/d');
                                    } catch (\Throwable) {
                                        $jalaliBookingDate = $booking->booking_date;
                                    }
                                @endphp

                                {{ $jalaliBookingDate }}

                            </p>

                        </div>


                        {{-- Time --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm text-muted">
                                ساعت
                            </p>

                            <p
                                class="
                                    mt-2
                                    font-black
                                    text-text
                                "
                                dir="ltr"
                            >
                                {{ substr((string) $booking->booking_time, 0, 5) }}
                            </p>

                        </div>


                        {{-- Duration --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm text-muted">
                                مدت زمان
                            </p>

                            <p class="mt-2 font-black text-text">
                                {{ $booking->duration_minutes }} دقیقه
                            </p>

                        </div>


                        {{-- Price --}}

                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm text-muted">
                                مبلغ
                            </p>

                            <p class="mt-2 font-black text-primary">

                                {{ number_format((float) $booking->final_price) }}

                                <span class="text-xs">
                                    تومان
                                </span>

                            </p>

                        </div>

                    </div>


                    {{-- Customer Info --}}

                    <div
                        class="
                            mt-6
                            rounded-2xl
                            border
                            border-border
                            bg-background
                            p-5
                        "
                    >

                        <p class="text-sm font-bold text-primary">
                            اطلاعات مشتری
                        </p>


                        <div
                            class="
                                mt-4
                                grid
                                gap-4
                                sm:grid-cols-2
                            "
                        >

                            <div>

                                <p class="text-xs text-muted">
                                    نام
                                </p>

                                <p class="mt-1 font-bold text-text">
                                    {{ $booking->customer_name }}
                                </p>

                            </div>


                            <div>

                                <p class="text-xs text-muted">
                                    شماره موبایل
                                </p>

                                <p
                                    class="mt-1 font-bold text-text"
                                    dir="ltr"
                                >
                                    {{ $booking->customer_phone }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Note --}}

                    @if($booking->customer_note)

                        <div
                            class="
                                mt-6
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <p class="text-sm font-bold text-primary">
                                توضیحات شما
                            </p>

                            <p
                                class="
                                    mt-3
                                    text-sm
                                    leading-7
                                    text-muted
                                "
                            >
                                {{ $booking->customer_note }}
                            </p>

                        </div>

                    @endif


                    {{-- Important Message --}}

                    <div
                        class="
                            mt-6
                            rounded-2xl
                            border
                            border-amber-500/20
                            bg-amber-500/5
                            p-5
                        "
                    >

                        <div
                            class="
                                flex
                                items-start
                                gap-3
                            "
                        >

                            <div
                                class="
                                    flex
                                    h-9
                                    w-9
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-xl
                                    bg-amber-500/10
                                "
                            >

                                <x-lucide-info
                                    class="h-4 w-4 text-amber-400"
                                />

                            </div>


                            <div>

                                <p class="font-black text-amber-400">
                                    درخواست شما ثبت شد
                                </p>

                                <p
                                    class="
                                        mt-2
                                        text-sm
                                        leading-7
                                        text-muted
                                    "
                                >
                                    وضعیت این رزرو در حال حاضر
                                    «در انتظار تأیید» است.
                                    لطفاً کد پیگیری خود را نزد خود نگه دارید.
                                </p>

                            </div>

                        </div>

                    </div>


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

                        <a
                            href="{{ route('salon.public', [
                                'salon' => $salon->slug,
                            ]) }}"
                            class="
                                inline-flex
                                w-full
                                items-center
                                justify-center
                                rounded-2xl
                                bg-primary
                                px-6
                                py-4
                                font-black
                                text-white
                                transition
                                hover:bg-primary-hover
                                sm:w-auto
                            "
                        >
                            بازگشت به صفحه سالن
                        </a>


                        <a
                            href="{{ route('salon.booking.create', [
                                'salon' => $salon->slug,
                            ]) }}"
                            class="
                                inline-flex
                                w-full
                                items-center
                                justify-center
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                px-6
                                py-4
                                font-bold
                                text-text
                                transition
                                hover:border-primary
                                hover:text-primary
                                sm:w-auto
                            "
                        >
                            رزرو نوبت دیگر
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </main>

@endsection
