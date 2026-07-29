<section class="w-full py-24 bg-background" dir="rtl">

    <div class="max-w-5xl px-6 mx-auto">

        {{-- Title --}}
        <div class="text-center mb-14">

            <span
                class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-5 py-2 text-sm font-bold text-primary">

                📅 رزرو آنلاین

            </span>

            <h2
                class="mt-6 text-4xl font-black text-text">

                تاریخ مراجعه را انتخاب کنید

            </h2>

            <p
                class="mt-4 text-muted">

                روزهای سبز دارای ظرفیت آزاد هستند.

            </p>

        </div>



        <div class="grid gap-8 lg:grid-cols-[1fr_280px]">

            {{-- Calendar --}}
            <div
                class="rounded-[32px] border border-border bg-surface p-8">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-8">

                    <button
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-background text-text transition hover:bg-primary hover:text-white">

                        →

                    </button>

                    <h3
                        class="text-xl font-black text-text">

                        مرداد ۱۴۰۵

                    </h3>

                    <button
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-background text-text transition hover:bg-primary hover:text-white">

                        ←

                    </button>

                </div>



                {{-- Legend --}}
                <div class="mb-8 flex flex-wrap gap-4">

                    <div class="flex items-center gap-2">

                        <span class="h-3 w-3 rounded-full bg-primary"></span>

                        <span class="text-sm text-muted">

                            ظرفیت آزاد

                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="h-3 w-3 rounded-full bg-yellow-500"></span>

                        <span class="text-sm text-muted">

                            محدود

                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <span class="h-3 w-3 rounded-full bg-red-500"></span>

                        <span class="text-sm text-muted">

                            تکمیل

                        </span>

                    </div>

                </div>



                {{-- Week --}}
                <div
                    class="grid grid-cols-7 gap-3 mb-5 text-center">

                    @foreach(['ش','ی','د','س','چ','پ','ج'] as $day)

                        <div
                            class="text-sm font-bold text-muted">

                            {{ $day }}

                        </div>

                    @endforeach

                </div>



                {{-- Days --}}
                <div
                    class="grid grid-cols-7 gap-3">

                    @for($i=1;$i<=30;$i++)

                        @php

                            $state='free';

                            if(in_array($i,[7,13,18,25])) $state='busy';
                            if(in_array($i,[10,20])) $state='limited';
                            if($i==15) $state='active';

                        @endphp

                        <button
                            class="group relative flex aspect-square items-center justify-center rounded-2xl border transition-all duration-300

                            {{ $state=='active' ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20 scale-105'
                            : ($state=='busy'
                                ? 'bg-red-500/10 border-red-500/20 text-red-400'
                                : ($state=='limited'
                                    ? 'bg-yellow-500/10 border-yellow-500/20 text-yellow-300'
                                    : 'bg-background border-border text-text hover:border-primary hover:-translate-y-1 hover:shadow-lg')) }}

                                ">

                            {{ $i }}

                            @if($state=='free')
                                <span
                                    class="absolute bottom-2 h-2 w-2 rounded-full bg-primary"></span>
                            @endif

                            @if($state=='limited')
                                <span
                                    class="absolute bottom-2 h-2 w-2 rounded-full bg-yellow-500"></span>
                            @endif

                            @if($state=='busy')
                                <span
                                    class="absolute bottom-2 h-2 w-2 rounded-full bg-red-500"></span>
                            @endif

                        </button>

                    @endfor

                </div>

            </div>



            {{-- Side Card --}}
            <div
                class="rounded-[32px] border border-border bg-surface p-8">

                <h3
                    class="text-xl font-black text-text">

                    انتخاب شما

                </h3>

                <div
                    class="mt-8 space-y-6">

                    <div>

                        <p class="text-sm text-muted">

                            تاریخ

                        </p>

                        <p
                            class="mt-1 text-lg font-bold text-text">

                            ۱۵ مرداد

                        </p>

                    </div>

                    <div>

                        <p class="text-sm text-muted">

                            وضعیت

                        </p>

                        <span
                            class="mt-2 inline-flex rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary">

                            ظرفیت آزاد

                        </span>

                    </div>

                    <div>

                        <p class="text-sm text-muted">

                            زمان‌های باقی‌مانده

                        </p>

                        <p
                            class="mt-1 text-2xl font-black text-secondary">

                            ۶ نوبت

                        </p>

                    </div>

                </div>

                <button
                    class="mt-10 w-full rounded-2xl bg-primary py-4 font-black text-white transition-all duration-300 hover:-translate-y-1 hover:bg-primary-hover">

                    ادامه

                </button>

            </div>

        </div>

    </div>

</section>
