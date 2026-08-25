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

    $publicSalonUrl = route('salon.public', [
        'salon' => $salon->slug,
    ]);

    $bookingStoreUrl = route('salon.booking.store', [
        'salon' => $salon->slug,
    ]);
@endphp


<section
    id="booking"
    class="
        scroll-mt-20
        bg-background
        py-14
        sm:py-16
        lg:py-20
    "
    dir="rtl"
>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="mb-8 max-w-3xl">

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
                    mt-4
                    text-3xl
                    font-black
                    leading-tight
                    text-text
                    sm:text-4xl
                "
            >
                نوبتت رو همین‌جا رزرو کن
            </h2>


            <p class="mt-3 max-w-2xl text-sm leading-7 text-muted">
                تاریخ، ساعت و خدمت موردنظرت رو انتخاب کن و در انتها اطلاعاتت رو ثبت کن.
            </p>

        </div>


        {{-- =========================================================
            Main Card
        ========================================================== --}}

        <div
            class="
                overflow-hidden
                rounded-[32px]
                border
                border-border
                bg-surface
                shadow-2xl
                shadow-black/10
            "
        >

            {{-- =====================================================
                Steps
            ====================================================== --}}

            <div class="overflow-x-auto border-b border-border">

                <div
                    class="
                        flex
                        min-w-max
                        items-center
                        px-3
                        py-3
                        sm:px-5
                    "
                >

                    @php
                        $steps = [
                            [
                                'number' => '۱',
                                'label' => 'تاریخ',
                                'active' => $hasDate,
                            ],
                            [
                                'number' => '۲',
                                'label' => 'ساعت',
                                'active' => $hasTime,
                            ],
                            [
                                'number' => '۳',
                                'label' => 'خدمت',
                                'active' => $hasService,
                            ],
                            [
                                'number' => '۴',
                                'label' => 'اطلاعات',
                                'active' => $hasService && $hasTime,
                            ],
                            [
                                'number' => '۵',
                                'label' => 'تأیید',
                                'active' => false,
                            ],
                        ];
                    @endphp


                    @foreach($steps as $index => $step)

                        <div class="flex items-center">

                            <div class="flex items-center gap-2 px-2.5">

                                <span
                                    @class([
                                        'flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-black',
                                        'bg-primary text-white' => $step['active'],
                                        'bg-background text-muted' => !$step['active'],
                                    ])
                                >
                                    {{ $step['number'] }}
                                </span>

                                <span
                                    @class([
                                        'text-xs font-bold',
                                        'text-text' => $step['active'],
                                        'text-muted' => !$step['active'],
                                    ])
                                >
                                    {{ $step['label'] }}
                                </span>

                            </div>


                            @if(!$loop->last)

                                <span class="h-px w-6 bg-border"></span>

                            @endif

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- =====================================================
                Form
            ====================================================== --}}

            <form
                method="POST"
                action="{{ $bookingStoreUrl }}"
            >

                @csrf


                {{-- Hidden --}}

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


                {{-- =================================================
                    Calendar + Time
                ================================================== --}}

                <div class="grid lg:grid-cols-2">

                    {{-- Calendar --}}

                    <div
                        class="
                            border-b
                            border-border
                            p-5
                            sm:p-6
                            lg:border-b-0
                            lg:border-l
                        "
                    >

                        <div class="mb-5">

                            <p class="text-[11px] font-black text-primary">
                                مرحله ۱
                            </p>

                            <h3 class="mt-1 text-lg font-black text-text">
                                انتخاب تاریخ
                            </h3>

                            <p class="mt-1 text-xs leading-6 text-muted">
                                روز مناسب برای نوبتت رو انتخاب کن.
                            </p>

                        </div>


                        <x-public.booking.calendar
                            :salon="$salon"
                            :selected-service="$selectedService"
                            :selected-date="$selectedDate"
                            :jalali-date="$jalaliDate"
                        />

                    </div>


                    {{-- Time --}}

                    <div class="p-5 sm:p-6">

                        <x-public.booking.time-picker
                            :salon="$salon"
                            :selected-service="$selectedService"
                            :available-slots="$availableSlots"
                            :selected-time="$selectedTime"
                            :selected-date="$selectedDate"
                            :jalali-date="$jalaliDate"
                        />

                    </div>

                </div>


                {{-- =================================================
                    Service + Customer
                ================================================== --}}

                <div class="grid border-t border-border lg:grid-cols-2">

                    {{-- Service --}}

                    <div
                        class="
                            border-b
                            border-border
                            p-5
                            sm:p-6
                            lg:border-b-0
                            lg:border-l
                        "
                    >

                        <div class="mb-5">

                            <p class="text-[11px] font-black text-primary">
                                مرحله ۳
                            </p>

                            <h3 class="mt-1 text-lg font-black text-text">
                                انتخاب خدمت
                            </h3>

                            <p class="mt-1 text-xs leading-6 text-muted">
                                خدمتی که می‌خواهی را انتخاب کن.
                            </p>

                        </div>


                        @if($services->isNotEmpty())

                            <div class="space-y-3">

                                @foreach($services as $service)

                                    @php

                                        $isSelected =
                                            (int) request('service_id')
                                            === (int) $service->id;


                                        $serviceUrl = route(
                                            'salon.public',
                                            array_filter([
                                                'salon' =>
                                                    $salon->slug,

                                                'date' =>
                                                    request('date')
                                                        ?: $jalaliDate,

                                                'service_id' =>
                                                    $service->id,

                                                'booking_time' =>
                                                    request('booking_time'),

                                            ], fn ($value) =>
                                                $value !== null &&
                                                $value !== ''
                                            )
                                        );

                                    @endphp


                                    <a
                                        href="{{ $serviceUrl }}#booking"
                                        @class([
                                            'block rounded-2xl border p-4 transition',
                                            'border-primary bg-primary/5' => $isSelected,
                                            'border-border bg-background hover:border-primary/40' => !$isSelected,
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

                                                <p class="text-sm font-black text-primary">
                                                    {{ number_format($service->price) }}
                                                </p>

                                                <p class="mt-0.5 text-[9px] text-muted">
                                                    تومان
                                                </p>

                                            </div>

                                        </div>


                                        <div
                                            class="
                                                mt-4
                                                flex
                                                items-center
                                                justify-between
                                            "
                                        >

                                            <span
                                                class="
                                                    inline-flex
                                                    items-center
                                                    gap-1.5
                                                    text-[10px]
                                                    font-bold
                                                    text-muted
                                                "
                                            >

                                                <x-lucide-clock-3 class="h-3.5 w-3.5" />

                                                {{ $service->duration }} دقیقه

                                            </span>


                                            <span
                                                class="
                                                    text-[10px]
                                                    font-black
                                                    {{ $isSelected
                                                        ? 'text-primary'
                                                        : 'text-muted'
                                                    }}
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


                    {{-- Customer --}}

                    <div class="p-5 sm:p-6">

                        <div class="mb-5">

                            <p class="text-[11px] font-black text-primary">
                                مرحله ۴
                            </p>

                            <h3 class="mt-1 text-lg font-black text-text">
                                اطلاعات مشتری
                            </h3>

                            <p class="mt-1 text-xs leading-6 text-muted">
                                این اطلاعات برای ثبت و پیگیری نوبت استفاده می‌شود.
                            </p>

                        </div>


                        <div class="space-y-4">

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
                                    maxlength="11"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    dir="ltr"
                                    placeholder="09121234567"
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

                            <div>

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
                                    rows="5"
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

                </div>


                {{-- =================================================
                    Summary
                ================================================== --}}

                <div
                    class="
                        border-t
                        border-primary/10
                        bg-primary/[0.025]
                        p-5
                        sm:p-6
                    "
                >

                    <div
                        class="
                            mb-5
                            flex
                            items-center
                            justify-between
                        "
                    >

                        <div>

                            <p class="text-[11px] font-black text-primary">
                                مرحله ۵
                            </p>

                            <h3 class="mt-1 text-lg font-black text-text">
                                خلاصه نوبت
                            </h3>

                        </div>


                        <x-lucide-clipboard-check
                            class="h-5 w-5 text-primary"
                        />

                    </div>


                    <x-public.booking.booking-summary
                        :salon="$salon"
                        :selected-service="$selectedService"
                        :jalali-date="$jalaliDate"
                        :selected-time="$selectedTime"
                    />


                    @if($errors->any())

                        <div
                            class="
                                mt-4
                                rounded-xl
                                border
                                border-red-500/20
                                bg-red-500/5
                                p-4
                            "
                        >

                            <p class="text-xs font-black text-red-400">
                                اطلاعات رزرو کامل نیست.
                            </p>

                            <ul class="mt-2 space-y-1 text-[11px] leading-5 text-red-300/80">

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
                                p-4
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
                    Submit
                ================================================== --}}

                <div
                    class="
                        border-t
                        border-border
                        bg-surface
                        p-5
                        sm:p-6
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

                            <h3 class="text-sm font-black text-text sm:text-base">
                                آماده ثبت نوبتی؟
                            </h3>

                            <p class="mt-1 text-[11px] leading-5 text-muted">
                                درخواست برای آرایشگاه ارسال می‌شود و منتظر تأیید می‌ماند.
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
                                rounded-2xl
                                bg-primary
                                px-7
                                py-4
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
                                sm:min-w-56
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
