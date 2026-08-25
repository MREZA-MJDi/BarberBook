{{-- resources/views/components/salon/booking.blade.php --}}

@php

    /*
    |--------------------------------------------------------------------------
    | Booking State
    |--------------------------------------------------------------------------
    */

    $services = $salon?->services ?? collect();

    $selectedService = $selectedService ?? null;
    $selectedDate = $selectedDate ?? null;
    $selectedTime = $selectedTime ?? null;
    $jalaliDate = $jalaliDate ?? request('date');
    $availableSlots = $availableSlots ?? [];

    /*
    |--------------------------------------------------------------------------
    | Current Selection
    |--------------------------------------------------------------------------
    */

    $serviceId =
        $selectedService?->id
        ?? request('service_id');

    $bookingTime =
        $selectedTime
        ?? request('booking_time');

    /*
    |--------------------------------------------------------------------------
    | Selected Date
    |--------------------------------------------------------------------------
    |
    | URL / UI date:
    | 1405/06/04
    |
    | POST date:
    | 2026-08-26
    |
    */

    $bookingDate =
        $selectedDate instanceof \Carbon\Carbon
            ? $selectedDate->format('Y-m-d')
            : null;

    /*
    |--------------------------------------------------------------------------
    | Customer State
    |--------------------------------------------------------------------------
    */

    $customerName =
        old('customer_name');

    $customerPhone =
        old('customer_phone');

    /*
    |--------------------------------------------------------------------------
    | Step State
    |--------------------------------------------------------------------------
    */

    $hasService =
        (bool) $selectedService;

    $hasDate =
        (bool) $selectedDate;

    $hasTime =
        (bool) $bookingTime;

    $hasCustomer =
        filled($customerName)
        && filled($customerPhone);

@endphp


<section
    id="booking"
    class="scroll-mt-20 overflow-hidden bg-background py-10 sm:py-12 lg:py-14"
    dir="rtl"
>

    <div class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8">


        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="mx-auto mb-7 max-w-3xl text-center">

            <span
                class="
                    inline-flex
                    items-center
                    gap-2
                    rounded-full
                    border
                    border-primary/20
                    bg-primary/10
                    px-3
                    py-1.5
                    text-[11px]
                    font-black
                    text-primary
                    sm:text-xs
                "
            >

                <x-lucide-calendar-plus class="h-3.5 w-3.5"/>

                رزرو آنلاین

            </span>


            <h2
                class="
                    mt-3
                    text-2xl
                    font-black
                    leading-tight
                    text-text
                    sm:text-3xl
                "
            >
                نوبتت رو همین‌جا رزرو کن
            </h2>


            <p
                class="
                    mx-auto
                    mt-2
                    max-w-2xl
                    text-sm
                    leading-6
                    text-muted
                "
            >
                خدمت، تاریخ و ساعت مناسب خودت رو انتخاب کن و اطلاعاتت رو ثبت کن.
            </p>

        </div>


        {{-- =========================================================
            Booking Shell
        ========================================================== --}}

        <div
            class="
                w-full
                overflow-hidden
                rounded-[28px]
                border
                border-border
                bg-surface
                shadow-2xl
                shadow-black/10
            "
        >


            {{-- =====================================================
                Stepper
            ====================================================== --}}

            <div class="border-b border-border">

                <div class="overflow-x-auto">

                    <div
                        class="
                            mx-auto
                            flex
                            min-w-max
                            items-center
                            justify-center
                            px-3
                            py-3
                            sm:px-5
                        "
                    >

                        {{-- Step 1 --}}

                        <div class="flex items-center gap-2 px-2 sm:px-3">

                            <span
                                class="
                                    flex
                                    h-7
                                    w-7
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    bg-primary
                                    text-[11px]
                                    font-black
                                    text-white
                                "
                            >
                                ۱
                            </span>

                            <span class="text-[11px] font-bold text-text sm:text-xs">
                                خدمت
                            </span>

                        </div>


                        <span class="h-px w-5 bg-border sm:w-8"></span>


                        {{-- Step 2 --}}

                        <div class="flex items-center gap-2 px-2 sm:px-3">

                            <span
                                @class([
                                    'flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-black',
                                    'bg-primary text-white' => $hasService,
                                    'bg-background text-muted' => !$hasService,
                                ])
                            >
                                ۲
                            </span>

                            <span
                                @class([
                                    'text-[11px] font-bold sm:text-xs',
                                    'text-text' => $hasService,
                                    'text-muted' => !$hasService,
                                ])
                            >
                                تاریخ
                            </span>

                        </div>


                        <span class="h-px w-5 bg-border sm:w-8"></span>


                        {{-- Step 3 --}}

                        <div class="flex items-center gap-2 px-2 sm:px-3">

                            <span
                                @class([
                                    'flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-black',
                                    'bg-primary text-white' => $hasDate,
                                    'bg-background text-muted' => !$hasDate,
                                ])
                            >
                                ۳
                            </span>

                            <span
                                @class([
                                    'text-[11px] font-bold sm:text-xs',
                                    'text-text' => $hasDate,
                                    'text-muted' => !$hasDate,
                                ])
                            >
                                ساعت
                            </span>

                        </div>


                        <span class="h-px w-5 bg-border sm:w-8"></span>


                        {{-- Step 4 --}}

                        <div class="flex items-center gap-2 px-2 sm:px-3">

                            <span
                                @class([
                                    'flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-black',
                                    'bg-primary text-white' => $hasTime,
                                    'bg-background text-muted' => !$hasTime,
                                ])
                            >
                                ۴
                            </span>

                            <span
                                @class([
                                    'text-[11px] font-bold sm:text-xs',
                                    'text-text' => $hasTime,
                                    'text-muted' => !$hasTime,
                                ])
                            >
                                اطلاعات
                            </span>

                        </div>


                        <span class="h-px w-5 bg-border sm:w-8"></span>


                        {{-- Step 5 --}}

                        <div class="flex items-center gap-2 px-2 sm:px-3">

                            <span
                                @class([
                                    'flex h-7 w-7 shrink-0 items-center justify-center rounded-full text-[11px] font-black',
                                    'bg-primary text-white' => $hasCustomer,
                                    'bg-background text-muted' => !$hasCustomer,
                                ])
                            >
                                ۵
                            </span>

                            <span
                                @class([
                                    'text-[11px] font-bold sm:text-xs',
                                    'text-text' => $hasCustomer,
                                    'text-muted' => !$hasCustomer,
                                ])
                            >
                                تأیید
                            </span>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Salon Mini Info
            ====================================================== --}}

            <div class="border-b border-border bg-background/40 px-4 py-4 sm:px-5">

                <div
                    class="
                        flex
                        flex-col
                        gap-3
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                    "
                >

                    <div class="min-w-0">

                        <div class="flex min-w-0 items-center gap-2">

                            <span
                                class="
                                    flex
                                    h-8
                                    w-8
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-lg
                                    bg-primary/10
                                    text-primary
                                "
                            >
                                <x-lucide-store class="h-4 w-4"/>
                            </span>

                            <p
                                class="
                                    min-w-0
                                    truncate
                                    text-sm
                                    font-black
                                    text-text
                                "
                            >
                                {{ $salon->name }}
                            </p>

                        </div>


                        @if($salon->address)

                            <p
                                class="
                                    mt-2
                                    flex
                                    min-w-0
                                    items-center
                                    gap-1.5
                                    truncate
                                    pr-10
                                    text-[11px]
                                    text-muted
                                "
                            >

                                <x-lucide-map-pin class="h-3.5 w-3.5 shrink-0"/>

                                <span class="truncate">
                                    {{ $salon->address }}
                                </span>

                            </p>

                        @endif

                    </div>


                    <div class="flex shrink-0 flex-wrap gap-2">

                        @if($salon->phone)

                            <a
                                href="tel:{{ $salon->phone }}"
                                class="
                                    inline-flex
                                    items-center
                                    gap-1.5
                                    rounded-lg
                                    border
                                    border-border
                                    bg-surface
                                    px-3
                                    py-2
                                    text-[11px]
                                    font-bold
                                    text-text
                                    transition
                                    hover:border-primary
                                    hover:text-primary
                                "
                            >

                                <x-lucide-phone class="h-3.5 w-3.5"/>

                                تماس

                            </a>

                        @endif


                        @if($salon->address)

                            <a
                                href="https://www.google.com/maps/search/?api=1&query={{ urlencode($salon->address) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="
                                    inline-flex
                                    items-center
                                    gap-1.5
                                    rounded-lg
                                    border
                                    border-border
                                    bg-surface
                                    px-3
                                    py-2
                                    text-[11px]
                                    font-bold
                                    text-text
                                    transition
                                    hover:border-primary
                                    hover:text-primary
                                "
                            >

                                <x-lucide-map class="h-3.5 w-3.5"/>

                                نقشه

                            </a>

                        @endif

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Booking Form
            ====================================================== --}}

            <form
                method="POST"
                action="{{ route('salon.booking.store', [
                    'salon' => $salon->slug,
                ]) }}"
                class="w-full"
            >

                @csrf


                {{-- =================================================
                    Single Source Of Truth For POST Values
                ================================================== --}}

                <input
                    type="hidden"
                    name="service_id"
                    value="{{ $serviceId }}"
                >

                <input
                    type="hidden"
                    name="booking_date"
                    value="{{ $bookingDate }}"
                >

                <input
                    type="hidden"
                    name="booking_time"
                    value="{{ $bookingTime }}"
                >


                {{-- =================================================
                    STEP 1 — SERVICE
                ================================================== --}}

                <section class="border-b border-border px-4 py-5 sm:px-5 sm:py-6">

                    <div
                        class="
                            mb-4
                            flex
                            items-start
                            justify-between
                            gap-4
                        "
                    >

                        <div>

                            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                                مرحله ۱
                            </p>

                            <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                انتخاب خدمت
                            </h3>

                            <p class="mt-1 text-xs text-muted">
                                خدمتی که می‌خواهی دریافت کنی را انتخاب کن.
                            </p>

                        </div>


                        @if($selectedService)

                            <span
                                class="
                                    inline-flex
                                    shrink-0
                                    items-center
                                    gap-1.5
                                    rounded-lg
                                    bg-primary/10
                                    px-2.5
                                    py-1.5
                                    text-[10px]
                                    font-bold
                                    text-primary
                                "
                            >

                                <x-lucide-check class="h-3 w-3"/>

                                انتخاب شده

                            </span>

                        @endif

                    </div>


                    @if($services->isNotEmpty())

                        <div
                            class="
                                grid
                                gap-3
                                sm:grid-cols-2
                                lg:grid-cols-3
                            "
                        >

                            @foreach($services as $service)

                                @php

                                    $isSelected =
                                        (int) $serviceId ===
                                        (int) $service->id;

                                    $serviceUrl = route(
                                        'salon.public',
                                        array_filter([
                                            'salon' => $salon->slug,
                                            'date' => request('date') ?: $jalaliDate,
                                            'service_id' => $service->id,
                                            'booking_time' => $bookingTime,
                                        ], function ($value) {
                                            return $value !== null
                                                && $value !== '';
                                        })
                                    );

                                @endphp


                                <a
                                    href="{{ $serviceUrl }}#booking"
                                    @class([
                                        'group rounded-2xl border p-3.5 transition duration-200 sm:p-4',
                                        'border-primary bg-primary/5 shadow-sm shadow-primary/10'
                                            => $isSelected,
                                        'border-border bg-background hover:border-primary/40 hover:bg-primary/5'
                                            => !$isSelected,
                                    ])
                                >

                                    <div
                                        class="
                                            flex
                                            items-start
                                            justify-between
                                            gap-3
                                        "
                                    >

                                        <div class="min-w-0">

                                            <h4
                                                @class([
                                                    'truncate text-sm font-black',
                                                    'text-primary' => $isSelected,
                                                    'text-text' => !$isSelected,
                                                ])
                                            >
                                                {{ $service->name }}
                                            </h4>


                                            @if($service->description)

                                                <p
                                                    class="
                                                        mt-1
                                                        line-clamp-2
                                                        text-[11px]
                                                        leading-5
                                                        text-muted
                                                    "
                                                >
                                                    {{ $service->description }}
                                                </p>

                                            @endif

                                        </div>


                                        <div class="shrink-0 text-left">

                                            <p class="text-xs font-black text-primary sm:text-sm">
                                                {{ number_format($service->price) }}
                                            </p>

                                            <p class="mt-0.5 text-[9px] text-muted">
                                                تومان
                                            </p>

                                        </div>

                                    </div>


                                    <div
                                        class="
                                            mt-3
                                            flex
                                            items-center
                                            justify-between
                                            gap-2
                                        "
                                    >

                                        <span
                                            class="
                                                inline-flex
                                                items-center
                                                gap-1
                                                text-[10px]
                                                font-bold
                                                text-muted
                                            "
                                        >

                                            <x-lucide-clock-3 class="h-3 w-3"/>

                                            {{ $service->duration }} دقیقه

                                        </span>


                                        <span class="text-[10px] font-black text-primary">

                                            {{ $isSelected ? 'انتخاب شده' : 'انتخاب' }}

                                        </span>

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    @else

                        <div
                            class="
                                rounded-2xl
                                border
                                border-dashed
                                border-border
                                bg-background
                                p-6
                                text-center
                            "
                        >

                            <x-lucide-scissors
                                class="mx-auto h-7 w-7 text-zinc-600"
                            />

                            <p class="mt-3 text-sm font-black text-text">
                                در حال حاضر خدمتی برای رزرو وجود ندارد.
                            </p>

                            <p class="mt-1 text-xs leading-5 text-muted">
                                لطفاً بعداً دوباره مراجعه کنید.
                            </p>

                        </div>

                    @endif

                </section>


                {{-- =================================================
                    STEP 2 + STEP 3
                ================================================== --}}

                <div
                    class="
                        grid
                        border-b
                        border-border
                        lg:grid-cols-2
                    "
                >

                    {{-- Calendar --}}

                    <section
                        class="
                            min-w-0
                            border-b
                            border-border
                            px-4
                            py-5
                            sm:px-5
                            sm:py-6
                            lg:border-b-0
                            lg:border-l
                        "
                    >

                        <div class="mb-4">

                            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                                مرحله ۲
                            </p>

                            <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                انتخاب تاریخ
                            </h3>

                            <p class="mt-1 text-xs text-muted">
                                تاریخ مناسب خودت را انتخاب کن.
                            </p>

                        </div>


                        <div class="min-w-0 overflow-hidden">

                            <x-public.booking.calendar
                                :salon="$salon"
                                :selectedService="$selectedService"
                                :selectedDate="$selectedDate"
                                :jalaliDate="$jalaliDate"
                            />

                        </div>

                    </section>


                    {{-- Time --}}

                    <section
                        class="
                            min-w-0
                            px-4
                            py-5
                            sm:px-5
                            sm:py-6
                        "
                    >

                        <div class="mb-4">

                            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                                مرحله ۳
                            </p>

                            <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                انتخاب ساعت
                            </h3>

                            <p class="mt-1 text-xs text-muted">
                                یکی از ساعت‌های آزاد را انتخاب کن.
                            </p>

                        </div>


                        <div class="min-w-0 overflow-hidden">

                            <x-public.booking.time-picker
                                :salon="$salon"
                                :selectedService="$selectedService"
                                :availableSlots="$availableSlots"
                                :selectedTime="$selectedTime"
                                :selectedDate="$selectedDate"
                                :jalaliDate="$jalaliDate"
                            />

                        </div>

                    </section>

                </div>


                {{-- =================================================
                    STEP 4 — CUSTOMER INFO
                ================================================== --}}

                <section class="border-b border-border px-4 py-5 sm:px-5 sm:py-6">

                    <div
                        class="
                            mb-4
                            flex
                            items-end
                            justify-between
                            gap-4
                        "
                    >

                        <div>

                            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                                مرحله ۴
                            </p>

                            <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                اطلاعات شما
                            </h3>

                        </div>

                        <span class="hidden text-[10px] text-muted sm:block">
                            برای ثبت و پیگیری نوبت
                        </span>

                    </div>


                    <div class="grid gap-4 sm:grid-cols-2">

                        {{-- Name --}}

                        <div>

                            <label
                                for="customer_name"
                                class="text-xs font-bold text-text"
                            >
                                نام و نام خانوادگی
                            </label>

                            <input
                                id="customer_name"
                                type="text"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                maxlength="255"
                                autocomplete="name"
                                placeholder="مثلاً محمدرضا مجیدی"
                                class="
                                    mt-2
                                    w-full
                                    rounded-xl
                                    border
                                    border-border
                                    bg-background
                                    px-4
                                    py-3
                                    text-sm
                                    text-text
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:border-primary
                                    focus:ring-2
                                    focus:ring-primary/10
                                "
                            >

                            @error('customer_name')

                            <p class="mt-1.5 text-[11px] font-bold text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>


                        {{-- Phone --}}

                        <div>

                            <label
                                for="customer_phone"
                                class="text-xs font-bold text-text"
                            >
                                شماره موبایل
                            </label>

                            <input
                                id="customer_phone"
                                type="tel"
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                required
                                maxlength="30"
                                inputmode="tel"
                                autocomplete="tel"
                                dir="ltr"
                                placeholder="0912xxxxxxx"
                                class="
                                    mt-2
                                    w-full
                                    rounded-xl
                                    border
                                    border-border
                                    bg-background
                                    px-4
                                    py-3
                                    text-sm
                                    text-text
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:border-primary
                                    focus:ring-2
                                    focus:ring-primary/10
                                "
                            >

                            @error('customer_phone')

                            <p class="mt-1.5 text-[11px] font-bold text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>


                        {{-- Note --}}

                        <div class="sm:col-span-2">

                            <label
                                for="customer_note"
                                class="text-xs font-bold text-text"
                            >
                                توضیحات

                                <span class="font-normal text-muted">
                                    (اختیاری)
                                </span>
                            </label>

                            <textarea
                                id="customer_note"
                                name="customer_note"
                                rows="3"
                                maxlength="1000"
                                placeholder="مثلاً مدل مو مثل عکس قبلی باشه..."
                                class="
                                    mt-2
                                    w-full
                                    resize-none
                                    rounded-xl
                                    border
                                    border-border
                                    bg-background
                                    p-4
                                    text-sm
                                    leading-6
                                    text-text
                                    outline-none
                                    transition
                                    placeholder:text-zinc-600
                                    focus:border-primary
                                    focus:ring-2
                                    focus:ring-primary/10
                                "
                            >{{ old('customer_note') }}</textarea>

                            @error('customer_note')

                            <p class="mt-1.5 text-[11px] font-bold text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    STEP 5 — SUMMARY
                ================================================== --}}

                <section
                    class="
                        border-b
                        border-primary/10
                        bg-primary/[0.025]
                        px-4
                        py-5
                        sm:px-5
                        sm:py-6
                    "
                >

                    <div
                        class="
                            mb-4
                            flex
                            items-center
                            justify-between
                            gap-3
                        "
                    >

                        <div>

                            <p class="text-[10px] font-black text-primary sm:text-[11px]">
                                مرحله ۵
                            </p>

                            <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                مرور و تأیید نهایی
                            </h3>

                            <p class="mt-1 text-xs text-muted">
                                اطلاعات نوبتت را یک بار بررسی کن.
                            </p>

                        </div>


                        <div
                            class="
                                flex
                                h-9
                                w-9
                                shrink-0
                                items-center
                                justify-center
                                rounded-xl
                                bg-primary/10
                                text-primary
                            "
                        >

                            <x-lucide-clipboard-check class="h-4 w-4"/>

                        </div>

                    </div>


                    <div
                        class="
                            rounded-2xl
                            border
                            border-border
                            bg-background
                            p-4
                        "
                    >

                        <x-public.booking.booking-summary
                            :salon="$salon"
                            :selectedService="$selectedService"
                            :jalaliDate="$jalaliDate"
                            :selectedTime="$selectedTime"
                        />

                    </div>


                    {{-- Validation Errors --}}

                    @if($errors->any())

                        <div
                            class="
                                mt-4
                                rounded-xl
                                border
                                border-red-500/20
                                bg-red-500/5
                                p-3
                            "
                        >

                            <p class="text-xs font-black text-red-400">
                                بررسی اطلاعات رزرو
                            </p>

                            <ul
                                class="
                                    mt-1.5
                                    space-y-1
                                    text-[11px]
                                    leading-5
                                    text-red-300/80
                                "
                            >

                                @foreach($errors->all() as $error)

                                    <li>
                                        • {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- Session Error --}}

                    @if(session('error'))

                        <div
                            class="
                                mt-4
                                rounded-xl
                                border
                                border-red-500/20
                                bg-red-500/5
                                p-3
                                text-xs
                                font-bold
                                leading-6
                                text-red-400
                            "
                        >

                            {{ session('error') }}

                        </div>

                    @endif

                </section>


                {{-- =================================================
                    FINAL SUBMIT
                ================================================== --}}

                <div
                    class="
                        flex
                        flex-col
                        gap-4
                        bg-surface
                        px-4
                        py-4
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        sm:px-5
                        sm:py-5
                    "
                >

                    <div>

                        <h3 class="text-sm font-black text-text sm:text-base">
                            آماده‌ای نوبتت رو ثبت کنی؟
                        </h3>

                        <p class="mt-1 text-[11px] leading-5 text-muted">
                            بعد از ثبت، درخواست برای آرایشگاه ارسال می‌شود.
                        </p>

                    </div>


                    <button
                        type="submit"
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
                            shadow-lg
                            shadow-primary/20
                            transition
                            hover:bg-primary-hover
                            active:scale-[0.98]
                            disabled:cursor-not-allowed
                            disabled:opacity-50
                            sm:w-auto
                            sm:min-w-48
                        "
                        @disabled(
                        !$selectedService ||
                        !$bookingDate ||
                        !$bookingTime
                        )
                    >

                        <x-lucide-calendar-check-2 class="h-5 w-5"/>

                        ثبت نهایی نوبت

                    </button>

                </div>

            </form>

        </div>

    </div>

</section>
