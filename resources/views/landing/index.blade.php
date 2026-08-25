<x-layouts.app>

    {{-- =========================================================
        HERO
    ========================================================== --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-br from-rose-50 via-white to-purple-50"></div>

        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8 lg:py-28">

            <div class="grid items-center gap-12 lg:grid-cols-2">

                {{-- Content --}}
                <div class="text-center lg:text-right">

                    <span class="mb-5 inline-flex items-center rounded-full border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-medium text-rose-600">
                        رزرو آنلاین نوبت آرایشگاه
                    </span>

                    <h1 class="text-4xl font-black leading-tight text-slate-900 sm:text-5xl lg:text-6xl">
                        زیبایی،
                        <span class="text-rose-500">آسان‌تر</span>
                        از همیشه
                    </h1>

                    <p class="mx-auto mt-6 max-w-xl text-base leading-8 text-slate-600 lg:mx-0 lg:text-lg">
                        سالن زیبایی موردنظرت را پیدا کن، خدمات را ببین و بدون تماس تلفنی
                        در چند ثانیه نوبتت را رزرو کن.
                    </p>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">

                        <a href="{{ route('salons.index') }}"
                           class="inline-flex items-center justify-center rounded-2xl bg-rose-500 px-7 py-3.5 text-sm font-bold text-white shadow-lg shadow-rose-200 transition hover:bg-rose-600">
                            پیدا کردن سالن
                        </a>

                        <a href="#how-it-works"
                           class="inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-7 py-3.5 text-sm font-bold text-slate-700 transition hover:border-rose-200 hover:text-rose-500">
                            چطور کار می‌کند؟
                        </a>

                    </div>

                    {{-- Trust --}}
                    <div class="mt-8 flex flex-wrap justify-center gap-6 text-sm text-slate-500 lg:justify-start">
                        <span>✓ رزرو سریع</span>
                        <span>✓ مشاهده خدمات</span>
                        <span>✓ بدون تماس تلفنی</span>
                    </div>

                </div>

                {{-- Visual --}}
                <div class="relative">

                    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-rose-200/40 blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-purple-200/40 blur-3xl"></div>

                    <div class="relative overflow-hidden rounded-[2rem] border border-white/70 bg-white p-3 shadow-2xl shadow-slate-200/60">
                        <div class="rounded-[1.5rem] bg-gradient-to-br from-rose-100 via-white to-purple-100 p-8">

                            <div class="mx-auto max-w-sm">

                                <div class="rounded-3xl bg-white p-5 shadow-xl">

                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs text-slate-400">
                                                سالن زیبایی
                                            </p>

                                            <h3 class="mt-1 text-lg font-extrabold text-slate-800">
                                                Rose Beauty
                                            </h3>
                                        </div>

                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-rose-100 text-xl">
                                            ✨
                                        </div>
                                    </div>

                                    <div class="mt-6 grid grid-cols-2 gap-3">

                                        <div class="rounded-2xl bg-rose-50 p-4">
                                            <p class="text-xs text-slate-400">
                                                خدمات
                                            </p>

                                            <p class="mt-1 font-bold text-slate-800">
                                                ۲۴ خدمت
                                            </p>
                                        </div>

                                        <div class="rounded-2xl bg-purple-50 p-4">
                                            <p class="text-xs text-slate-400">
                                                امتیاز
                                            </p>

                                            <p class="mt-1 font-bold text-slate-800">
                                                ۴.۹ از ۵
                                            </p>
                                        </div>

                                    </div>

                                    <div class="mt-4 rounded-2xl border border-slate-100 p-4">

                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-bold text-slate-700">
                                                نوبت بعدی
                                            </span>

                                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">
                                                آزاد
                                            </span>
                                        </div>

                                        <div class="mt-4 grid grid-cols-3 gap-2">

                                            <span class="rounded-xl bg-slate-50 py-2 text-center text-xs text-slate-500">
                                                ۱۰:۰۰
                                            </span>

                                            <span class="rounded-xl bg-rose-500 py-2 text-center text-xs font-bold text-white">
                                                ۱۱:۳۰
                                            </span>

                                            <span class="rounded-xl bg-slate-50 py-2 text-center text-xs text-slate-500">
                                                ۱۳:۰۰
                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- =========================================================
        FEATURES
    ========================================================== --}}
    <section class="border-y border-slate-100 bg-white">
        <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">

            <div class="grid gap-6 md:grid-cols-3">

                <div class="rounded-3xl bg-rose-50 p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                        📅
                    </div>

                    <h3 class="font-extrabold text-slate-900">
                        رزرو آنلاین
                    </h3>

                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        هر زمان که خواستی نوبت مناسب خودت را انتخاب کن.
                    </p>
                </div>

                <div class="rounded-3xl bg-purple-50 p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                        💇🏻‍♀️
                    </div>

                    <h3 class="font-extrabold text-slate-900">
                        انتخاب خدمات
                    </h3>

                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        خدمات، قیمت و مدت زمان انجام هر سرویس را ببین.
                    </p>
                </div>

                <div class="rounded-3xl bg-pink-50 p-6">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-xl shadow-sm">
                        ⚡
                    </div>

                    <h3 class="font-extrabold text-slate-900">
                        سریع و ساده
                    </h3>

                    <p class="mt-2 text-sm leading-7 text-slate-600">
                        بدون دردسر و تماس تلفنی، نوبتت را قطعی کن.
                    </p>
                </div>

            </div>

        </div>
    </section>


    {{-- =========================================================
        HOW IT WORKS
    ========================================================== --}}
    <section id="how-it-works" class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">

            <div class="mx-auto max-w-2xl text-center">
                <span class="text-sm font-bold text-rose-500">
                    خیلی ساده
                </span>

                <h2 class="mt-3 text-3xl font-black text-slate-900">
                    رزرو نوبت در سه مرحله
                </h2>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">

                <div class="rounded-3xl bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-100 text-lg font-black text-rose-600">
                        ۱
                    </div>

                    <h3 class="mt-5 font-extrabold text-slate-900">
                        انتخاب سالن
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        سالن زیبایی موردنظرت را انتخاب کن.
                    </p>
                </div>

                <div class="rounded-3xl bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-purple-100 text-lg font-black text-purple-600">
                        ۲
                    </div>

                    <h3 class="mt-5 font-extrabold text-slate-900">
                        انتخاب خدمت و زمان
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        سرویس، تاریخ و ساعت مناسب را انتخاب کن.
                    </p>
                </div>

                <div class="rounded-3xl bg-white p-8 text-center shadow-sm">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-100 text-lg font-black text-pink-600">
                        ۳
                    </div>

                    <h3 class="mt-5 font-extrabold text-slate-900">
                        ثبت نوبت
                    </h3>

                    <p class="mt-3 text-sm leading-7 text-slate-500">
                        اطلاعاتت را ثبت کن و نوبتت را دریافت کن.
                    </p>
                </div>

            </div>

        </div>
    </section>


    {{-- =========================================================
        CTA
    ========================================================== --}}
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-6 py-20 lg:px-8">

            <div class="overflow-hidden rounded-[2rem] bg-gradient-to-br from-rose-500 to-purple-600 px-8 py-14 text-center text-white shadow-2xl shadow-rose-200/40">

                <h2 class="text-3xl font-black sm:text-4xl">
                    آماده‌ای نوبتت رو رزرو کنی؟
                </h2>

                <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-white/80 sm:text-base">
                    سالن موردنظرت را پیدا کن و در چند مرحله ساده نوبتت را ثبت کن.
                </p>

                <a href="{{ route('salons.index') }}"
                   class="mt-8 inline-flex items-center justify-center rounded-2xl bg-white px-8 py-3.5 text-sm font-bold text-rose-600 transition hover:bg-slate-50">
                    مشاهده سالن‌ها
                </a>

            </div>

        </div>
    </section>

</x-layouts.app>
