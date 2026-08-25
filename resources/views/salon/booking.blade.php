{{-- resources/views/components/salon/booking.blade.php --}}

@php
    $services = $salon?->services ?? collect();

    $selectedService = $selectedService ?? null;
    $selectedDate = $selectedDate ?? null;
    $selectedTime = $selectedTime ?? null;
    $jalaliDate = $jalaliDate ?? null;
    $availableSlots = $availableSlots ?? [];

    $hasService = (bool) $selectedService;
    $hasDate = (bool) $selectedDate;
    $hasTime = (bool) $selectedTime;
@endphp


<section
    id="booking"
    class="bg-background py-10 sm:py-12 lg:py-14"
    dir="rtl"
>

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">


        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="mb-6 max-w-3xl">

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
                    text-xs
                    font-black
                    text-primary
                "
            >

                <x-lucide-calendar-plus class="h-3.5 w-3.5" />

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


            <p class="mt-2 text-sm leading-6 text-muted">
                خدمت، تاریخ و ساعت موردنظرت رو انتخاب کن و اطلاعاتت رو ثبت کن.
            </p>

        </div>


        {{-- =========================================================
            MAIN BOOKING CARD
        ========================================================== --}}

        <div
            class="
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
                STEP NAV
            ====================================================== --}}

            <div
                class="
                    overflow-x-auto
                    border-b
                    border-border
                "
            >

                <div class="flex min-w-max items-center px-2 py-2.5 sm:px-4">


                    {{-- Step 1 --}}

                    <div class="flex items-center gap-2 px-2.5 py-2 sm:px-3">

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

                    <div class="flex items-center gap-2 px-2.5 py-2 sm:px-3">

                        <span
                            class="
                                flex
                                h-7
                                w-7
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                text-[11px]
                                font-black
                                {{ $hasService
                                    ? 'bg-primary text-white'
                                    : 'bg-background text-muted'
                                }}
                                "
                        >
                            ۲
                        </span>

                        <span
                            class="
                                text-[11px]
                                font-bold
                                sm:text-xs
                                {{ $hasService ? 'text-text' : 'text-muted' }}
                                "
                        >
                            تاریخ
                        </span>

                    </div>


                    <span class="h-px w-5 bg-border sm:w-8"></span>


                    {{-- Step 3 --}}

                    <div class="flex items-center gap-2 px-2.5 py-2 sm:px-3">

                        <span
                            class="
                                flex
                                h-7
                                w-7
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                text-[11px]
                                font-black
                                {{ $hasDate
                                    ? 'bg-primary text-white'
                                    : 'bg-background text-muted'
                                }}
                                "
                        >
                            ۳
                        </span>

                        <span
                            class="
                                text-[11px]
                                font-bold
                                sm:text-xs
                                {{ $hasDate ? 'text-text' : 'text-muted' }}
                                "
                        >
                            ساعت
                        </span>

                    </div>


                    <span class="h-px w-5 bg-border sm:w-8"></span>


                    {{-- Step 4 --}}

                    <div class="flex items-center gap-2 px-2.5 py-2 sm:px-3">

                        <span
                            class="
                                flex
                                h-7
                                w-7
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                text-[11px]
                                font-black
                                {{ $hasTime
                                    ? 'bg-primary text-white'
                                    : 'bg-background text-muted'
                                }}
                                "
                        >
                            ۴
                        </span>

                        <span
                            class="
                                text-[11px]
                                font-bold
                                sm:text-xs
                                {{ $hasTime ? 'text-text' : 'text-muted' }}
                                "
                        >
                            اطلاعات
                        </span>

                    </div>


                    <span class="h-px w-5 bg-border sm:w-8"></span>


                    {{-- Step 5 --}}

                    <div class="flex items-center gap-2 px-2.5 py-2 sm:px-3">

                        <span
                            class="
                                flex
                                h-7
                                w-7
                                shrink-0
                                items-center
                                justify-center
                                rounded-full
                                bg-background
                                text-[11px]
                                font-black
                                text-muted
                            "
                        >
                            ۵
                        </span>

                        <span class="text-[11px] font-bold text-muted sm:text-xs">
                            تأیید
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                BOOKING FORM
            ====================================================== --}}

            <form
                method="POST"
                action="{{ route('salon.booking.store', [
                    'qr_token' => $salon->qr_token,
                ]) }}"
            >

                @csrf


                {{-- Hidden values --}}

                <input
                    type="hidden"
                    name="service_id"
                    value="{{ $selectedService?->id }}"
                >

                <input
                    type="hidden"
                    name="booking_date"
                    value="{{ $selectedDate?->format('Y-m-d') }}"
                >

                <input
                    type="hidden"
                    name="booking_time"
                    value="{{ $selectedTime }}"
                >


                <div class="divide-y divide-border">


                    {{-- =================================================
                        STEP 1 — SERVICE
                    ================================================== --}}

                    <div class="p-4 sm:p-5">

                        <div
                            class="
                                mb-4
                                flex
                                items-end
                                justify-between
                                gap-3
                            "
                        >

                            <div>

                                <p class="text-[11px] font-black text-primary">
                                    مرحله ۱
                                </p>

                                <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                    انتخاب خدمت
                                </h3>

                            </div>


                            @if($selectedService)

                                <span
                                    class="
                                        inline-flex
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

                                    <x-lucide-check class="h-3 w-3" />

                                    {{ $selectedService->name }}

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
                                            (int) request('service_id') === (int) $service->id;

                                        $serviceUrl = route(
                                            'salon.public',
                                            array_filter([
                                                'qr_token' => $salon->qr_token,
                                                'date' => request('date') ?: $jalaliDate,
                                                'service_id' => $service->id,
                                                'booking_time' => request('booking_time'),
                                            ], fn ($value) =>
                                                $value !== null &&
                                                $value !== ''
                                            )
                                        );
                                    @endphp


                                    <a
                                        href="{{ $serviceUrl }}#booking"
                                        class="
                                            rounded-2xl
                                            border
                                            p-3.5
                                            transition
                                            sm:p-4
                                            {{ $isSelected
                                                ? 'border-primary bg-primary/5'
                                                : 'border-border bg-background hover:border-primary/40'
                                            }}
                                            "
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
                                                    class="
                                                        truncate
                                                        text-sm
                                                        font-black
                                                        {{ $isSelected
                                                            ? 'text-primary'
                                                            : 'text-text'
                                                        }}
                                                        "
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

                                                <p class="text-xs font-black text-primary">
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

                                                <x-lucide-clock-3 class="h-3 w-3" />

                                                {{ $service->duration }} دقیقه

                                            </span>


                                            <span
                                                class="
                                                    text-[10px]
                                                    font-black
                                                    text-primary
                                                "
                                            >
                                                {{ $isSelected ? 'انتخاب شده' : 'انتخاب' }}
                                            </span>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        @else

                            <x-customer.empty-state
                                title="خدمتی برای رزرو وجود ندارد"
                                description="در حال حاضر خدمتی برای این سالن ثبت نشده است."
                                icon="scissors"
                            />

                        @endif

                    </div>


                    {{-- =================================================
                        STEP 2 + STEP 3
                    ================================================== --}}

                    <div class="grid lg:grid-cols-2">


                        {{-- Calendar --}}

                        <div
                            class="
                                border-b
                                border-border
                                p-4
                                sm:p-5
                                lg:border-b-0
                                lg:border-l
                            "
                        >

                            <div class="mb-4">

                                <p class="text-[11px] font-black text-primary">
                                    مرحله ۲
                                </p>

                                <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                    انتخاب تاریخ
                                </h3>

                                <p class="mt-1 text-xs text-muted">
                                    تاریخ مناسب را انتخاب کن.
                                </p>

                            </div>


                            <div class="overflow-hidden">

                                <x-public.booking.calendar
                                    :salon="$salon"
                                    :selectedService="$selectedService"
                                    :selectedDate="$selectedDate"
                                    :jalaliDate="$jalaliDate"
                                />

                            </div>

                        </div>


                        {{-- Time --}}

                        <div class="p-4 sm:p-5">

                            <div class="mb-4">

                                <p class="text-[11px] font-black text-primary">
                                    مرحله ۳
                                </p>

                                <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                    انتخاب ساعت
                                </h3>

                                <p class="mt-1 text-xs text-muted">
                                    یکی از ساعت‌های آزاد را انتخاب کن.
                                </p>

                            </div>


                            <div class="overflow-hidden">

                                <x-public.booking.time-picker
                                    :salon="$salon"
                                    :selectedService="$selectedService"
                                    :availableSlots="$availableSlots"
                                    :selectedTime="$selectedTime"
                                    :selectedDate="$selectedDate"
                                    :jalaliDate="$jalaliDate"
                                />

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        STEP 4 — CUSTOMER INFORMATION
                    ================================================== --}}

                    <div class="p-4 sm:p-5">

                        <div
                            class="
                                mb-4
                                flex
                                items-end
                                justify-between
                                gap-3
                            "
                        >

                            <div>

                                <p class="text-[11px] font-black text-primary">
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

                    </div>


                    {{-- =================================================
                        STEP 5 — SUMMARY
                    ================================================== --}}

                    <div
                        class="
                            border-t
                            border-primary/10
                            bg-primary/[0.025]
                            p-4
                            sm:p-5
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

                                <p class="text-[11px] font-black text-primary">
                                    مرحله ۵
                                </p>

                                <h3 class="mt-1 text-base font-black text-text sm:text-lg">
                                    مرور و تأیید
                                </h3>

                            </div>


                            <x-lucide-clipboard-check
                                class="h-5 w-5 text-primary"
                            />

                        </div>


                        <x-public.booking.booking-summary
                            :salon="$salon"
                            :selectedService="$selectedService"
                            :jalaliDate="$jalaliDate"
                            :selectedTime="$selectedTime"
                        />


                        {{-- Errors --}}

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
                                    اطلاعات رزرو کامل نیست.
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

                    </div>


                    {{-- =================================================
                        FINAL ACTION
                    ================================================== --}}

                    <div
                        class="
                            flex
                            flex-col
                            gap-4
                            border-t
                            border-border
                            bg-surface
                            p-4
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            sm:p-5
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
                                disabled:cursor-not-allowed
                                disabled:opacity-50
                                sm:w-auto
                                sm:min-w-48
                            "
                            @disabled(
                            !$selectedService ||
                            !$selectedTime ||
                            !$selectedDate
                            )
                        >

                            <x-lucide-calendar-check-2 class="h-5 w-5" />

                            ثبت نهایی نوبت

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</section>
