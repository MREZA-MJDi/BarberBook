<section class="w-full py-24 bg-background" dir="rtl">

    <div class="max-w-5xl px-6 mx-auto">

        {{-- Title --}}
        <div class="text-center mb-14">

            <span
                class="inline-flex items-center rounded-full bg-primary/10 px-5 py-2 text-sm font-bold text-primary">

                🕒 انتخاب زمان

            </span>

            <h2 class="mt-6 text-4xl font-black text-text">

                ساعت مناسب خودت را انتخاب کن

            </h2>

            <p class="mt-4 text-muted">

                فقط زمان‌های آزاد نمایش داده می‌شوند.

            </p>

        </div>



        <div class="grid gap-8 lg:grid-cols-[1fr_320px]">

            {{-- Time Slots --}}
            <div
                class="rounded-[32px] border border-border bg-surface p-8">

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">

                    @foreach([
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '14:00',
                    '14:30',
                    '15:00',
                    '16:00',
                    '17:30',
                    '18:00'
                    ] as $time)

                        @php

                            $busy=in_array($time,['09:30','14:30','17:30']);
                            $active=$time=='15:00';

                        @endphp

                        <button
                            class="group relative overflow-hidden rounded-2xl border px-4 py-5 transition-all duration-300

                            {{ $active
                            ? 'bg-primary border-primary text-white scale-105 shadow-lg shadow-primary/20'
                            : ($busy
                                ? 'bg-red-500/10 border-red-500/20 text-red-400 cursor-not-allowed'
                                : 'bg-background border-border text-text hover:border-primary hover:-translate-y-1 hover:shadow-lg') }}">

                            <div class="text-lg font-black">

                                {{ $time }}

                            </div>

                            @if(!$busy)

                                <div class="mt-2 text-xs text-muted group-hover:text-primary">

                                    آزاد

                                </div>

                            @else

                                <div class="mt-2 text-xs">

                                    رزرو شده

                                </div>

                            @endif

                        </button>

                    @endforeach

                </div>

            </div>



            {{-- Summary --}}
            <div
                class="rounded-[32px] border border-border bg-surface p-8">

                <h3
                    class="text-xl font-black text-text">

                    خلاصه رزرو

                </h3>

                <div class="mt-8 space-y-6">

                    <div>

                        <p class="text-sm text-muted">

                            مدل انتخابی

                        </p>

                        <p class="mt-1 font-bold text-text">

                            French Crop

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-muted">

                            تاریخ

                        </p>

                        <p class="mt-1 font-bold text-text">

                            شنبه ۲۵ مرداد

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-muted">

                            ساعت

                        </p>

                        <p class="mt-1 text-2xl font-black text-secondary">

                            15:00

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-muted">

                            مدت زمان

                        </p>

                        <p class="mt-1 font-bold text-text">

                            ۴۵ دقیقه

                        </p>

                    </div>

                </div>

                <button
                    class="mt-10 w-full rounded-2xl bg-primary py-4 font-black text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-hover">

                    ادامه رزرو

                </button>

            </div>

        </div>

    </div>

</section>
