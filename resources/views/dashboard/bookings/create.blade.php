<x-layouts.dashboard>

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}

    <div class="mb-8">

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
                    رزرو دستی
                </p>

                <h1
                    class="
                        mt-2
                        text-2xl
                        font-black
                        text-text
                        sm:text-3xl
                    "
                >
                    ثبت رزرو برای مشتری
                </h1>

                <p class="mt-2 text-sm text-muted">
                    سرویس، تاریخ، ساعت و اطلاعات مشتری را وارد کنید.
                </p>

            </div>


            <a
                href="{{ route('bookings.index') }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    rounded-2xl
                    border
                    border-border
                    bg-background
                    px-5
                    py-3
                    text-sm
                    font-black
                    text-text
                    transition
                    hover:border-primary
                    hover:text-primary
                "
            >
                ← بازگشت به رزروها
            </a>

        </div>

    </div>


    {{-- =========================================================
        BOOKING ANCHOR
    ========================================================== --}}

    <div
        id="dashboard-booking"
        class="scroll-mt-24"
    >

        <form
            method="POST"
            action="{{ route('bookings.store') }}"
            class="space-y-8"
        >

            @csrf


            {{-- =====================================================
                BOOKING DATA
            ====================================================== --}}

            @if($selectedService)

                <input
                    type="hidden"
                    name="service_id"
                    value="{{ $selectedService->id }}"
                >

            @endif


            <input
                type="hidden"
                name="booking_date"
                value="{{ $jalaliDate }}"
            >


            <input
                type="hidden"
                name="booking_time"
                value="{{ $selectedTime ?? '' }}"
            >


            {{-- =====================================================
                STEP 1 — SERVICE
            ====================================================== --}}

            <section
                class="
                    rounded-3xl
                    border
                    border-border
                    bg-surface
                    p-6
                    sm:p-8
                "
            >

                <div class="mb-6">

                    <span class="text-xs font-black text-primary">
                        مرحله ۱
                    </span>

                    <h2 class="mt-2 text-xl font-black text-text">
                        انتخاب سرویس
                    </h2>

                    <p class="mt-2 text-sm text-muted">
                        سرویس موردنظر مشتری را انتخاب کنید.
                    </p>

                </div>


                @if($services->isEmpty())

                    <div
                        class="
                            rounded-2xl
                            border
                            border-border
                            bg-background
                            px-6
                            py-10
                            text-center
                        "
                    >

                        <div class="text-3xl">
                            ✂
                        </div>

                        <h3 class="mt-4 font-black text-text">
                            هنوز سرویسی ثبت نشده
                        </h3>

                        <p class="mt-2 text-sm text-muted">
                            ابتدا حداقل یک سرویس فعال ایجاد کنید.
                        </p>

                        <a
                            href="{{ route('services.create') }}"
                            class="
                                mt-5
                                inline-flex
                                rounded-xl
                                bg-primary
                                px-5
                                py-3
                                text-sm
                                font-black
                                text-white
                                transition
                                hover:bg-primary-hover
                            "
                        >
                            افزودن سرویس
                        </a>

                    </div>

                @else

                    <div
                        class="
                            grid
                            gap-4
                            sm:grid-cols-2
                            lg:grid-cols-3
                        "
                    >

                        @foreach($services as $service)

                            @php

                                $isSelected =
                                    $selectedService &&
                                    $selectedService->id === $service->id;


                                $serviceUrl = route(
                                    'bookings.create',
                                    array_filter([
                                        'date' =>
                                            $jalaliDate,

                                        'service_id' =>
                                            $service->id,

                                        'booking_time' =>
                                            $selectedTime,
                                    ], fn ($value) =>
                                        $value !== null &&
                                        $value !== ''
                                    )
                                );

                            @endphp


                            <a
                                href="{{ $serviceUrl }}#dashboard-booking"
                                @class([
                                    'group rounded-2xl border p-5 transition-all duration-200',
                                    'border-primary bg-primary/10 shadow-lg shadow-primary/10' => $isSelected,
                                    'border-border bg-background hover:-translate-y-1 hover:border-primary/50' => !$isSelected,
                                ])
                            >

                                <div
                                    class="
                                        flex
                                        items-start
                                        justify-between
                                        gap-4
                                    "
                                >

                                    <div>

                                        <h3 class="font-black text-text">
                                            {{ $service->name }}
                                        </h3>


                                        @if($service->description)

                                            <p
                                                class="
                                                    mt-2
                                                    line-clamp-2
                                                    text-sm
                                                    text-muted
                                                "
                                            >
                                                {{ $service->description }}
                                            </p>

                                        @endif

                                    </div>


                                    @if($isSelected)

                                        <div
                                            class="
                                                flex
                                                h-7
                                                w-7
                                                shrink-0
                                                items-center
                                                justify-center
                                                rounded-full
                                                bg-primary
                                                text-sm
                                                font-black
                                                text-white
                                            "
                                        >
                                            ✓
                                        </div>

                                    @endif

                                </div>


                                <div
                                    class="
                                        mt-5
                                        flex
                                        items-center
                                        justify-between
                                    "
                                >

                                    <span class="text-sm font-bold text-muted">
                                        {{ $service->duration }} دقیقه
                                    </span>

                                    <span class="font-black text-primary">
                                        {{ number_format($service->price) }}
                                        تومان
                                    </span>

                                </div>

                            </a>

                        @endforeach

                    </div>

                @endif

            </section>


            {{-- =====================================================
                STEP 2 — DATE + TIME
            ====================================================== --}}

            <section
                class="
                    rounded-3xl
                    border
                    border-border
                    bg-surface
                    p-6
                    sm:p-8
                "
            >

                <div class="mb-6">

                    <span class="text-xs font-black text-primary">
                        مرحله ۲
                    </span>

                    <h2 class="mt-2 text-xl font-black text-text">
                        انتخاب تاریخ و ساعت
                    </h2>

                    <p class="mt-2 text-sm text-muted">
                        تاریخ و ساعت آزاد موردنظر مشتری را انتخاب کنید.
                    </p>

                </div>


                <div class="grid gap-8 lg:grid-cols-2">


                    {{-- Calendar --}}

                    <div>

                        <label
                            class="
                                mb-3
                                block
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            تاریخ رزرو
                        </label>


                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            <x-booking.calendar
                                :selected-date="$selectedDate"
                                :jalali-date="$jalaliDate"
                                :selected-service="$selectedService"
                            />

                        </div>

                    </div>


                    {{-- Time Picker --}}

                    <div>

                        <label
                            class="
                                mb-3
                                block
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            ساعت رزرو
                        </label>


                        <div
                            class="
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                p-5
                            "
                        >

                            @if(!$selectedService)

                                <div
                                    class="
                                        flex
                                        min-h-[260px]
                                        items-center
                                        justify-center
                                        text-center
                                    "
                                >

                                    <div>

                                        <div class="text-3xl">
                                            ✂
                                        </div>

                                        <p
                                            class="
                                                mt-3
                                                text-sm
                                                font-bold
                                                text-muted
                                            "
                                        >
                                            ابتدا یک سرویس انتخاب کنید.
                                        </p>

                                    </div>

                                </div>

                            @elseif(empty($availableSlots))

                                <div
                                    class="
                                        flex
                                        min-h-[260px]
                                        items-center
                                        justify-center
                                        text-center
                                    "
                                >

                                    <div>

                                        <div class="text-3xl">
                                            🕒
                                        </div>

                                        <p class="mt-3 font-black text-text">
                                            زمانی برای این روز موجود نیست.
                                        </p>

                                        <p class="mt-2 text-sm text-muted">
                                            تاریخ دیگری را امتحان کنید.
                                        </p>

                                    </div>

                                </div>

                            @else

                                <x-booking.time-picker
                                    :available-slots="$availableSlots"
                                    :selected-time="$selectedTime"
                                    :selected-date="$jalaliDate"
                                    :selected-service="$selectedService"
                                />

                            @endif

                        </div>

                    </div>

                </div>

            </section>


            {{-- =====================================================
                STEP 3 — CUSTOMER
            ====================================================== --}}

            <section
                class="
                    rounded-3xl
                    border
                    border-border
                    bg-surface
                    p-6
                    sm:p-8
                "
            >

                <div class="mb-6">

                    <span class="text-xs font-black text-primary">
                        مرحله ۳
                    </span>

                    <h2 class="mt-2 text-xl font-black text-text">
                        اطلاعات مشتری
                    </h2>

                    <p class="mt-2 text-sm text-muted">
                        اطلاعات مشتری را برای ثبت رزرو وارد کنید.
                    </p>

                </div>


                <div class="grid gap-5 md:grid-cols-2">


                    {{-- Name --}}

                    <div>

                        <label
                            for="customer_name"
                            class="
                                mb-2
                                block
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            نام مشتری
                        </label>

                        <input
                            id="customer_name"
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="مثلاً محمدرضا"
                            required
                            class="
                                w-full
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                px-4
                                py-4
                                text-sm
                                font-bold
                                text-text
                                outline-none
                                transition
                                placeholder:text-muted/60
                                focus:border-primary
                            "
                        >

                        @error('customer_name')

                        <p class="mt-2 text-xs font-bold text-red-500">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Phone --}}

                    <div>

                        <label
                            for="customer_phone"
                            class="
                                mb-2
                                block
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            شماره موبایل
                        </label>

                        <input
                            id="customer_phone"
                            type="tel"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="09xxxxxxxxx"
                            inputmode="numeric"
                            maxlength="11"
                            required
                            class="
                                w-full
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                px-4
                                py-4
                                text-sm
                                font-bold
                                text-text
                                outline-none
                                transition
                                placeholder:text-muted/60
                                focus:border-primary
                            "
                        >

                        @error('customer_phone')

                        <p class="mt-2 text-xs font-bold text-red-500">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>


                    {{-- Note --}}

                    <div class="md:col-span-2">

                        <label
                            for="customer_note"
                            class="
                                mb-2
                                block
                                text-sm
                                font-black
                                text-text
                            "
                        >
                            توضیحات مشتری
                        </label>

                        <textarea
                            id="customer_note"
                            name="customer_note"
                            rows="4"
                            placeholder="مثلاً مدل خاصی مدنظر مشتری است..."
                            class="
                                w-full
                                resize-none
                                rounded-2xl
                                border
                                border-border
                                bg-background
                                px-4
                                py-4
                                text-sm
                                font-bold
                                text-text
                                outline-none
                                transition
                                placeholder:text-muted/60
                                focus:border-primary
                            "
                        >{{ old('customer_note') }}</textarea>

                        @error('customer_note')

                        <p class="mt-2 text-xs font-bold text-red-500">
                            {{ $message }}
                        </p>

                        @enderror

                    </div>

                </div>

            </section>


            {{-- =====================================================
                STEP 4 — SUMMARY
            ====================================================== --}}

            <x-booking.booking-summary
                :selected-service="$selectedService"
                :selected-date="$jalaliDate"
                :selected-time="$selectedTime"
            />

        </form>

    </div>

</x-layouts.dashboard>
