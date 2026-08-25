{{-- resources/views/components/salon/booking.blade.php --}}

<section
    id="booking"
    class="bg-background py-24"
    dir="rtl"
>
    <div class="mx-auto max-w-7xl px-5">

        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="text-center">

            <span
                class="inline-flex items-center rounded-full bg-primary/10 px-4 py-2 text-sm font-black text-primary"
            >
                رزرو آنلاین
            </span>

            <h2 class="mt-5 text-3xl font-black text-text sm:text-4xl">
                فقط چند قدم تا نوبتت باقی مونده
            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-8 text-muted">
                خدمت، تاریخ و ساعت مناسب خودت رو انتخاب کن و بدون تماس تلفنی
                نوبتت رو ثبت کن.
            </p>

        </div>


        {{-- =========================================================
            Booking Form
        ========================================================== --}}

        <form
            method="POST"
            action="{{ route('salon.booking.store', [
                'qr_token' => $salon->qr_token,
            ]) }}"
            class="mt-14"
        >

            @csrf


            {{-- =====================================================
                Booking Values
            ====================================================== --}}

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


            {{-- =====================================================
                Main Grid
            ====================================================== --}}

            <div class="grid gap-8 lg:grid-cols-3">


                {{-- =================================================
                    Main Content
                ================================================== --}}

                <div class="space-y-6 lg:col-span-2">


                    {{-- =================================================
                        Salon Info
                    ================================================== --}}

                    <div
                        class="rounded-[30px] border border-border bg-surface p-7"
                    >

                        <div
                            class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between"
                        >

                            <div>

                                <p class="text-sm font-bold text-primary">
                                    رزرو در
                                </p>

                                <h3 class="mt-2 text-2xl font-black text-text">
                                    {{ $salon->name }}
                                </h3>

                                @if($salon->address)

                                    <p class="mt-3 leading-7 text-muted">
                                        {{ $salon->address }}
                                    </p>

                                @endif

                            </div>


                            <span
                                class="inline-flex w-fit shrink-0 items-center rounded-full bg-emerald-500/10 px-4 py-2 text-sm font-black text-emerald-400"
                            >

                                <span
                                    class="ml-2 h-2.5 w-2.5 rounded-full bg-emerald-400"
                                ></span>

                                فعال

                            </span>

                        </div>


                        <div class="mt-6 flex flex-wrap gap-3">

                            @if($salon->phone)

                                <a
                                    href="tel:{{ $salon->phone }}"
                                    class="rounded-2xl border border-border bg-background px-5 py-3 text-sm font-bold text-text transition hover:border-primary hover:text-primary"
                                >
                                    📞 تماس با آرایشگاه
                                </a>

                            @endif


                            @if($salon->address)

                                <a
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($salon->address) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="rounded-2xl border border-border bg-background px-5 py-3 text-sm font-bold text-text transition hover:border-primary hover:text-primary"
                                >
                                    🗺 مشاهده روی نقشه
                                </a>

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                        Service Selection
                    ================================================== --}}

                    <div
                        class="rounded-[30px] border border-border bg-surface p-7"
                    >

                        <div>

                            <p class="text-sm font-bold text-primary">
                                مرحله ۱
                            </p>

                            <h3 class="mt-2 text-xl font-black text-text">
                                انتخاب خدمت
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-muted">
                                خدمتی که می‌خواهی دریافت کنی را انتخاب کن.
                            </p>

                        </div>


                        @if($salon->services->count())

                            <div class="mt-6 grid gap-4 sm:grid-cols-2">

                                @foreach($salon->services as $service)

                                    @php

                                        $isSelected =
                                            (int) request('service_id')
                                            ===
                                            (int) $service->id;

                                        $serviceUrl = route(
                                            'salon.public',
                                            array_filter([
                                                'qr_token' => $salon->qr_token,
                                                'date' => request('date') ?: $jalaliDate,
                                                'service_id' => $service->id,
                                                'booking_time' => request('booking_time'),
                                            ], function ($value) {
                                                return $value !== null
                                                    && $value !== '';
                                            })
                                        );

                                    @endphp


                                    <a
                                        href="{{ $serviceUrl }}#booking"
                                        class="block rounded-2xl border p-5 transition-all duration-200 {{ $isSelected
                                            ? 'border-primary bg-primary/5 shadow-lg shadow-primary/10'
                                            : 'border-border bg-background hover:-translate-y-0.5 hover:border-primary/60 hover:bg-primary/5'
                                        }}"
                                    >

                                        <div
                                            class="flex items-start justify-between gap-4"
                                        >

                                            <div>

                                                <h4 class="font-black text-text">
                                                    {{ $service->name }}
                                                </h4>

                                                @if($service->description)

                                                    <p class="mt-2 text-xs leading-6 text-muted">
                                                        {{ $service->description }}
                                                    </p>

                                                @endif

                                            </div>


                                            <div class="shrink-0 text-left">

                                                <p class="font-black text-primary">
                                                    {{ number_format($service->price) }}
                                                </p>

                                                <p class="mt-1 text-xs text-muted">
                                                    تومان
                                                </p>

                                            </div>

                                        </div>


                                        <div class="mt-4 flex items-center justify-between">

                                            <span class="text-xs font-bold text-muted">
                                                ⏱ {{ $service->duration }} دقیقه
                                            </span>

                                            <span class="text-xs font-black text-primary">

                                                {{
                                                    $isSelected
                                                        ? 'انتخاب شده'
                                                        : 'انتخاب'
                                                }}

                                            </span>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        @else

                            <div
                                class="mt-6 rounded-2xl border border-dashed border-border bg-background p-8 text-center"
                            >

                                <div class="text-3xl">
                                    ✂
                                </div>

                                <p class="mt-4 font-black text-text">
                                    در حال حاضر خدمتی برای رزرو وجود ندارد.
                                </p>

                                <p class="mt-2 text-sm leading-6 text-muted">
                                    لطفاً بعداً دوباره به این صفحه مراجعه کنید.
                                </p>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                        Calendar + Time
                    ================================================== --}}

                    <div class="grid gap-6 lg:grid-cols-2">


                        {{-- Public Calendar --}}

                        <div
                            class="rounded-[30px] border border-border bg-surface p-7"
                        >

                            <p class="text-sm font-bold text-primary">
                                مرحله ۲
                            </p>

                            <h3 class="mt-2 text-xl font-black text-text">
                                انتخاب تاریخ
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-muted">
                                تاریخ مناسب خودت رو انتخاب کن.
                            </p>


                            <div class="mt-6">

                                <x-public.booking.calendar
                                    :salon="$salon"
                                    :selectedService="$selectedService"
                                    :selectedDate="$selectedDate"
                                    :jalaliDate="$jalaliDate"
                                />

                            </div>

                        </div>


                        {{-- Public Time Picker --}}

                        <div
                            class="rounded-[30px] border border-border bg-surface p-7"
                        >

                            <p class="text-sm font-bold text-primary">
                                مرحله ۳
                            </p>

                            <h3 class="mt-2 text-xl font-black text-text">
                                انتخاب ساعت
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-muted">
                                فقط ساعت‌های آزاد برای سرویس انتخابی نمایش داده می‌شوند.
                            </p>


                            <div class="mt-6">

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
                        Customer Information
                    ================================================== --}}

                    <div
                        class="rounded-[30px] border border-border bg-surface p-7"
                    >

                        <div>

                            <p class="text-sm font-bold text-primary">
                                مرحله ۴
                            </p>

                            <h3 class="mt-2 text-xl font-black text-text">
                                اطلاعات شما
                            </h3>

                            <p class="mt-2 text-sm leading-7 text-muted">
                                برای ثبت نوبت، نام و شماره موبایلت رو وارد کن.
                            </p>

                        </div>


                        <div class="mt-6 grid gap-5 sm:grid-cols-2">

                            {{-- Customer Name --}}

                            <div>

                                <label
                                    for="customer_name"
                                    class="text-sm font-bold text-text"
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
                                    class="mt-2 w-full rounded-2xl border border-border bg-background px-4 py-3.5 text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                                >

                                @error('customer_name')

                                <p class="mt-2 text-xs font-bold text-red-400">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>


                            {{-- Customer Phone --}}

                            <div>

                                <label
                                    for="customer_phone"
                                    class="text-sm font-bold text-text"
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
                                    class="mt-2 w-full rounded-2xl border border-border bg-background px-4 py-3.5 text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                                >

                                @error('customer_phone')

                                <p class="mt-2 text-xs font-bold text-red-400">
                                    {{ $message }}
                                </p>

                                @enderror

                            </div>

                        </div>


                        {{-- Customer Note --}}

                        <div class="mt-5">

                            <label
                                for="customer_note"
                                class="text-sm font-bold text-text"
                            >
                                توضیحات برای آرایشگر
                            </label>

                            <textarea
                                id="customer_note"
                                name="customer_note"
                                rows="4"
                                maxlength="1000"
                                placeholder="مثلاً مدل مو مثل عکس قبلی باشه..."
                                class="mt-2 w-full rounded-2xl border border-border bg-background p-4 text-text outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/10"
                            >{{ old('customer_note') }}</textarea>

                            @error('customer_note')

                            <p class="mt-2 text-xs font-bold text-red-400">
                                {{ $message }}
                            </p>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                        Validation Errors
                    ================================================== --}}

                    @if($errors->any())

                        <div
                            class="rounded-[24px] border border-red-500/20 bg-red-500/5 p-5"
                        >

                            <div class="flex items-start gap-3">

                                <div class="text-lg">
                                    ⚠️
                                </div>

                                <div>

                                    <p class="font-black text-red-400">
                                        بررسی اطلاعات رزرو
                                    </p>

                                    <ul class="mt-2 space-y-1 text-sm leading-6 text-red-300/80">

                                        @foreach($errors->all() as $error)

                                            <li>
                                                {{ $error }}
                                            </li>

                                        @endforeach

                                    </ul>

                                </div>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        Session Error
                    ================================================== --}}

                    @if(session('error'))

                        <div
                            class="rounded-[24px] border border-red-500/20 bg-red-500/5 p-5"
                        >

                            <div class="flex items-start gap-3">

                                <div class="text-lg">
                                    ⚠️
                                </div>

                                <p class="text-sm font-bold leading-7 text-red-400">
                                    {{ session('error') }}
                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                    Summary
                ================================================== --}}

                <div>

                    <div class="sticky top-24">

                        <x-public.booking.booking-summary
                            :salon="$salon"
                            :selectedService="$selectedService"
                            :jalaliDate="$jalaliDate"
                            :selectedTime="$selectedTime"
                        />

                    </div>

                </div>

            </div>


            {{-- =========================================================
                Submit
            ========================================================== --}}

            <div
                class="mt-8 rounded-[30px] border border-border bg-surface p-6 sm:p-7"
            >

                <div
                    class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between"
                >

                    <div>

                        <h3 class="text-lg font-black text-text">
                            آماده‌ای نوبتت رو ثبت کنی؟
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            بعد از ثبت، درخواست شما برای آرایشگاه ارسال می‌شود.
                        </p>

                    </div>


                    <button
                        type="submit"
                        class="
                            inline-flex
                            w-full
                            items-center
                            justify-center
                            rounded-2xl
                            bg-primary
                            px-8
                            py-4
                            text-sm
                            font-black
                            text-white
                            shadow-lg
                            shadow-primary/20
                            transition
                            duration-300
                            hover:-translate-y-0.5
                            hover:bg-primary-hover
                            hover:shadow-xl
                            disabled:cursor-not-allowed
                            sm:w-auto
                        "
                        @disabled(
                        !$selectedService ||
                        !$selectedTime ||
                        !$selectedDate
                        )
                    >
                        ثبت نهایی نوبت
                    </button>

                </div>

            </div>

        </form>

    </div>
</section>
