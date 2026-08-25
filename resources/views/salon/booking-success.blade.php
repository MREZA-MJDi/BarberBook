{{-- resources/views/salon/booking-success.blade.php --}}

@extends('layouts.app')

@section('content')

    <main
        class="min-h-screen bg-background px-5 py-16 sm:px-6 lg:px-8"
        dir="rtl"
    >

        <div class="mx-auto max-w-3xl">

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
                    "
                >
                    ✓
                </div>

                <p class="mt-6 text-sm font-black text-emerald-400">
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
                        leading-8
                        text-muted
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
                    mt-12
                    overflow-hidden
                    rounded-[32px]
                    border
                    border-border
                    bg-surface
                    shadow-xl
                    shadow-black/5
                "
            >

                {{-- Salon Header --}}

                <div
                    class="
                        border-b
                        border-border
                        bg-primary/5
                        p-6
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

                        <div>

                            <p class="text-sm font-bold text-primary">
                                رزرو در
                            </p>

                            <h2
                                class="
                                    mt-2
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
                                class="h-2.5 w-2.5 rounded-full bg-amber-400"
                            ></span>

                            در انتظار تأیید

                        </div>

                    </div>

                </div>


                {{-- Booking Details --}}

                <div class="p-6 sm:p-8">

                    <div class="grid gap-4 sm:grid-cols-2">


                        {{-- Reference --}}

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
                                کد پیگیری
                            </p>

                            <p
                                class="
                                    mt-2
                                    break-all
                                    font-black
                                    tracking-wide
                                    text-primary
                                "
                            >
                                {{ $booking->reference_code }}
                            </p>

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
                                {{ $booking->booking_date }}
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

                            <p class="mt-2 font-black text-text" dir="ltr">
                                {{ $booking->booking_time }}
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
                                {{ number_format($booking->final_price) }}

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

                            <p class="mt-3 leading-7 text-muted">
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

                        <div class="flex items-start gap-3">

                            <div class="text-xl">
                                ℹ️
                            </div>

                            <div>

                                <p class="font-black text-amber-400">
                                    درخواست شما ثبت شد
                                </p>

                                <p class="mt-2 text-sm leading-7 text-muted">
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
                            href="{{ route('salon.public', ['qr_token' => $salon->qr_token]) }}"
                            class="
                                inline-flex
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
                            "
                        >
                            بازگشت به صفحه سالن
                        </a>


                        <a
                            href="{{ route('salon.booking.create', ['qr_token' => $salon->qr_token]) }}"
                            class="
                                inline-flex
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
