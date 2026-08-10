{{-- resources/views/components/booking/booking-summary.blade.php --}}

@php
    /*
    |--------------------------------------------------------------------------
    | Persian Digits
    |--------------------------------------------------------------------------
    */

    $toPersianDigits = function ($value) {
        return strtr((string) $value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    };


    /*
    |--------------------------------------------------------------------------
    | Selected Service
    |--------------------------------------------------------------------------
    */

    $service = $selectedService ?? null;


    /*
    |--------------------------------------------------------------------------
    | Selected Date
    |--------------------------------------------------------------------------
    |
    | jalaliDate is already a formatted string.
    |
    */

    $date = $jalaliDate
        ?? request('date');


    /*
    |--------------------------------------------------------------------------
    | Selected Time
    |--------------------------------------------------------------------------
    */

    $time = request('booking_time');


    if ($time) {

        $time = substr(
            (string) $time,
            0,
            5
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Customer Data
    |--------------------------------------------------------------------------
    */

    $customerName = old(
        'customer_name',
        request('customer_name')
    );

    $customerPhone = old(
        'customer_phone',
        request('customer_phone')
    );

    $customerNote = old(
        'customer_note',
        request('customer_note')
    );


    /*
    |--------------------------------------------------------------------------
    | Ready State
    |--------------------------------------------------------------------------
    */

    $isReady =
        $service &&
        $date &&
        $time &&
        $customerName &&
        $customerPhone;


    /*
    |--------------------------------------------------------------------------
    | Price
    |--------------------------------------------------------------------------
    */

    $price = $service?->price ?? 0;

    $duration = $service?->duration ?? null;
@endphp


<div class="rounded-3xl border border-border bg-surface p-6 sm:p-8">

    {{-- =========================================================
        Header
    ========================================================== --}}

    <div class="flex items-center justify-between gap-4">

        <div>

            <span class="text-xs font-black text-primary">
                مرحله ۴
            </span>

            <h2 class="mt-2 text-xl font-black text-text">
                خلاصه رزرو
            </h2>

            <p class="mt-2 text-sm text-muted">
                اطلاعات رزرو را قبل از ثبت نهایی بررسی کنید.
            </p>

        </div>


        @if($isReady)

            <span
                class="rounded-full bg-emerald-500/10 px-3 py-1.5 text-xs font-black text-emerald-400"
            >
                آماده ثبت
            </span>

        @else

            <span
                class="rounded-full bg-amber-500/10 px-3 py-1.5 text-xs font-black text-amber-400"
            >
                ناقص
            </span>

        @endif

    </div>


    {{-- =========================================================
        Summary
    ========================================================== --}}

    <div class="mt-8 space-y-5">


        {{-- =====================================================
            Service
        ====================================================== --}}

        <div
            class="flex items-center justify-between gap-4"
        >

            <span class="text-sm text-muted">
                ✂ سرویس
            </span>

            <strong
                class="text-sm font-black text-text"
            >
                {{ $service?->name ?? 'انتخاب نشده' }}
            </strong>

        </div>


        {{-- =====================================================
            Date
        ====================================================== --}}

        <div
            class="flex items-center justify-between gap-4"
        >

            <span class="text-sm text-muted">
                📅 تاریخ
            </span>

            <strong
                class="text-sm font-black text-text"
            >
                @if($date)
                    {{ $toPersianDigits($date) }}
                @else
                    انتخاب نشده
                @endif
            </strong>

        </div>


        {{-- =====================================================
            Time
        ====================================================== --}}

        <div
            class="flex items-center justify-between gap-4"
        >

            <span class="text-sm text-muted">
                🕒 ساعت
            </span>

            <strong
                class="text-sm font-black text-primary"
            >

                @if($time)

                    {{ $toPersianDigits($time) }}

                @else

                    انتخاب نشده

                @endif

            </strong>

        </div>


        {{-- =====================================================
            Duration
        ====================================================== --}}

        <div
            class="flex items-center justify-between gap-4"
        >

            <span class="text-sm text-muted">
                ⏱ مدت
            </span>

            <strong
                class="text-sm font-black text-text"
            >

                @if($duration)

                    {{ $toPersianDigits($duration) }}
                    دقیقه

                @else

                    -

                @endif

            </strong>

        </div>


        {{-- =====================================================
            Price
        ====================================================== --}}

        <div
            class="border-t border-border pt-5"
        >

            <div
                class="flex items-center justify-between gap-4"
            >

                <span class="text-sm text-muted">
                    💰 مبلغ
                </span>

                <strong
                    class="text-2xl font-black text-primary"
                >

                    {{ $toPersianDigits(number_format($price)) }}

                    <span class="text-sm">
                        تومان
                    </span>

                </strong>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Customer Preview
    ========================================================== --}}

    @if($customerName || $customerPhone)

        <div
            class="mt-6 rounded-2xl border border-border bg-background p-4"
        >

            <div class="mb-4">

                <p class="text-xs font-bold text-muted">
                    اطلاعات مشتری
                </p>

            </div>


            <div class="space-y-3">

                @if($customerName)

                    <div
                        class="flex items-center justify-between gap-4"
                    >

                        <span class="text-sm text-muted">
                            نام
                        </span>

                        <strong
                            class="text-sm font-black text-text"
                        >
                            {{ $customerName }}
                        </strong>

                    </div>

                @endif


                @if($customerPhone)

                    <div
                        class="flex items-center justify-between gap-4"
                    >

                        <span class="text-sm text-muted">
                            موبایل
                        </span>

                        <strong
                            dir="ltr"
                            class="text-sm font-black text-text"
                        >
                            {{ $customerPhone }}
                        </strong>

                    </div>

                @endif


                @if($customerNote)

                    <div
                        class="border-t border-border pt-3"
                    >

                        <p class="text-xs font-bold text-muted">
                            توضیحات
                        </p>

                        <p
                            class="mt-2 text-sm leading-6 text-text"
                        >
                            {{ $customerNote }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

    @endif


    {{-- =========================================================
        Approval Notice
    ========================================================== --}}

    <div
        class="mt-6 rounded-2xl border border-amber-500/20 bg-amber-500/10 p-4"
    >

        <div class="flex gap-3">

            <div class="shrink-0 text-lg">
                ℹ
            </div>


            <div>

                <p
                    class="text-sm font-black text-amber-400"
                >
                    رزرو پس از ثبت نیاز به تایید دارد.
                </p>


                <p
                    class="mt-1 text-xs leading-6 text-amber-300/70"
                >
                    این رزرو با وضعیت «در انتظار تایید» ثبت می‌شود
                    و پس از بررسی آرایشگر قابل تایید خواهد بود.
                </p>

            </div>

        </div>

    </div>


    {{-- =========================================================
        Validation State
    ========================================================== --}}

    @if(!$service)

        <div
            class="mt-4 rounded-2xl border border-red-500/20 bg-red-500/5 px-4 py-3 text-sm font-bold text-red-400"
        >
            ابتدا یک سرویس انتخاب کنید.
        </div>

    @elseif(!$time)

        <div
            class="mt-4 rounded-2xl border border-amber-500/20 bg-amber-500/5 px-4 py-3 text-sm font-bold text-amber-400"
        >
            ابتدا یک ساعت برای رزرو انتخاب کنید.
        </div>

    @endif


    {{-- =========================================================
        Submit Area
    ========================================================== --}}

    <div
        class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
    >

        {{-- Cancel --}}

        <a
            href="{{ route('bookings.index') }}"
            class="inline-flex items-center justify-center rounded-2xl border border-border px-6 py-4 text-sm font-black text-muted transition hover:border-primary hover:text-primary"
        >
            انصراف
        </a>


        {{-- Submit --}}

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-2xl bg-primary px-8 py-4 text-sm font-black text-white shadow-lg shadow-primary/20 transition hover:-translate-y-1 hover:bg-primary-hover disabled:cursor-not-allowed disabled:opacity-50"
            @disabled(!$service || !$time)
        >

            ثبت رزرو و ارسال برای تایید

        </button>

    </div>

</div>

