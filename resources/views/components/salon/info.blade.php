<section
    class="py-24"
    dir="rtl"
>

    <div class="mx-auto max-w-7xl px-5">

        {{-- =====================================================
            Header
        ====================================================== --}}

        <div class="text-center">

            <span
                class="inline-flex items-center rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary"
            >
                اطلاعات سالن
            </span>

            <h2 class="mt-5 text-4xl font-black text-text">
                قبل از رزرو، بیشتر با ما آشنا شوید
            </h2>

            <p class="mx-auto mt-4 max-w-2xl text-muted">
                اطلاعات تماس، ساعت کاری و امکانات سالن را مشاهده کنید.
            </p>

        </div>


        {{-- =====================================================
            Main Grid
        ====================================================== --}}

        <div class="mt-16 grid gap-8 lg:grid-cols-2">


            {{-- =================================================
                Contact Information
            ================================================== --}}

            <div
                class="rounded-[30px] border border-border bg-surface p-8"
            >

                <h3 class="text-2xl font-black text-text">
                    اطلاعات تماس
                </h3>


                <div class="mt-8 space-y-6">


                    {{-- Address --}}
                    <div class="flex items-start gap-4">

                        <div class="text-2xl">
                            📍
                        </div>

                        <div class="min-w-0">

                            <h4 class="font-bold text-text">
                                آدرس
                            </h4>

                            <p class="mt-1 leading-7 text-muted">
                                {{ $salon->address ?? 'آدرس ثبت نشده است.' }}
                            </p>

                        </div>

                    </div>


                    {{-- Phone --}}
                    <div class="flex items-start gap-4">

                        <div class="text-2xl">
                            📞
                        </div>

                        <div>

                            <h4 class="font-bold text-text">
                                شماره تماس
                            </h4>

                            @if($salon->phone)

                                <a
                                    href="tel:{{ $salon->phone }}"
                                    class="mt-1 inline-block text-muted transition hover:text-primary"
                                >
                                    {{ $salon->phone }}
                                </a>

                            @else

                                <p class="mt-1 text-muted">
                                    شماره تماس ثبت نشده است.
                                </p>

                            @endif

                        </div>

                    </div>


                    {{-- Working Hours --}}
                    <div class="flex items-start gap-4">

                        <div class="text-2xl">
                            🕒
                        </div>

                        <div class="min-w-0 flex-1">

                            <h4 class="font-bold text-text">
                                ساعت کاری
                            </h4>


                            @php

                                $days = [
                                    0 => 'شنبه',
                                    1 => 'یکشنبه',
                                    2 => 'دوشنبه',
                                    3 => 'سه‌شنبه',
                                    4 => 'چهارشنبه',
                                    5 => 'پنجشنبه',
                                    6 => 'جمعه',
                                ];

                            @endphp


                            <div class="mt-3 space-y-2">

                                @forelse($salon->workingHours as $workingHour)

                                    <div class="flex items-center justify-between gap-4">

                                        <span class="text-sm font-bold text-text">
                                            {{ $days[$workingHour->day_of_week] ?? 'روز' }}
                                        </span>


                                        @if($workingHour->is_closed)

                                            <span class="text-sm text-red-400">
                                                تعطیل
                                            </span>

                                        @else

                                            <span class="text-sm text-muted">

                                                {{ \Carbon\Carbon::parse($workingHour->start_time)->format('H:i') }}

                                                -

                                                {{ \Carbon\Carbon::parse($workingHour->end_time)->format('H:i') }}

                                                @if($workingHour->break_start && $workingHour->break_end)

                                                    <span class="mr-2 text-xs text-zinc-500">
                                                        استراحت:
                                                        {{ \Carbon\Carbon::parse($workingHour->break_start)->format('H:i') }}
                                                        -
                                                        {{ \Carbon\Carbon::parse($workingHour->break_end)->format('H:i') }}
                                                    </span>

                                                @endif

                                            </span>

                                        @endif

                                    </div>

                                @empty

                                    <p class="text-sm text-muted">
                                        ساعت کاری ثبت نشده است.
                                    </p>

                                @endforelse

                            </div>

                        </div>

                    </div>


                    {{-- Instagram --}}
                    <div class="flex items-start gap-4">

                        <div class="text-2xl">
                            📱
                        </div>

                        <div>

                            <h4 class="font-bold text-text">
                                اینستاگرام
                            </h4>


                            @if($salon->instagram)

                                @php
                                    $instagramUrl = str_starts_with($salon->instagram, 'http')
                                        ? $salon->instagram
                                        : 'https://instagram.com/' . ltrim($salon->instagram, '@');
                                @endphp

                                <a
                                    href="{{ $instagramUrl }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="mt-1 inline-block text-primary transition hover:underline"
                                >
                                    {{ $salon->instagram }}
                                </a>

                            @else

                                <p class="mt-1 text-muted">
                                    صفحه اینستاگرام ثبت نشده است.
                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                Features
            ================================================== --}}

            <div
                class="rounded-[30px] border border-border bg-surface p-8"
            >

                <h3 class="text-2xl font-black text-text">
                    امکانات و قوانین
                </h3>


                <div class="mt-8 grid grid-cols-2 gap-5">


                    {{-- Payment --}}
                    <div class="rounded-2xl border border-border p-5">

                        <div class="text-3xl">
                            💳
                        </div>

                        <h4 class="mt-4 font-bold text-text">
                            کارتخوان
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            امکان پرداخت حضوری با کارت
                        </p>

                    </div>


                    {{-- Parking --}}
                    <div class="rounded-2xl border border-border p-5">

                        <div class="text-3xl">
                            🚗
                        </div>

                        <h4 class="mt-4 font-bold text-text">
                            پارکینگ
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            فضای پارک در نزدیکی سالن
                        </p>

                    </div>


                    {{-- Environment --}}
                    <div class="rounded-2xl border border-border p-5">

                        <div class="text-3xl">
                            ❄️
                        </div>

                        <h4 class="mt-4 font-bold text-text">
                            محیط مجهز
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            تهویه مناسب و محیط آرام
                        </p>

                    </div>


                    {{-- Booking Rules --}}
                    <div class="rounded-2xl border border-border p-5">

                        <div class="text-3xl">
                            📅
                        </div>

                        <h4 class="mt-4 font-bold text-text">
                            قوانین رزرو
                        </h4>

                        <p class="mt-2 text-sm leading-6 text-muted">
                            لطفاً قبل از رزرو، شرایط و قوانین سالن را بررسی کنید.
                        </p>

                    </div>


                </div>

            </div>

        </div>

    </div>

</section>
