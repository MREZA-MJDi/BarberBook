<header class="relative overflow-hidden bg-background" dir="rtl">

    {{-- Background Glow --}}
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none">
        <div class="h-72 w-72 rounded-full bg-primary/15 blur-[140px]"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-5 py-8 lg:px-8">

        <div class="grid items-center gap-10 lg:grid-cols-2">

            {{-- ================= IMAGE ================= --}}
            <div class="order-1">

                <div class="relative overflow-hidden rounded-[32px] border border-border bg-surface shadow-2xl">

                    <img
                        src="{{ asset('images/511f951c69575248f6433e6197fcc8a1.jpg') }}"
                        alt="آرایشگاه آلیجناب"
                        class="h-[420px] w-full object-cover lg:h-[650px]">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                    {{-- Floating Card --}}
                    <div class="absolute bottom-5 right-5 left-5">

                        <div class="rounded-3xl border border-white/10 bg-black/45 p-5 backdrop-blur-xl">

                            <div class="flex items-center justify-between">

                                <div>

                                    <h2 class="text-2xl font-black text-white">
                                        آرایشگاه آلیجناب
                                    </h2>

                                    <p class="mt-2 text-sm text-zinc-300">
                                        علی مجیدی
                                    </p>

                                </div>

                                <div class="rounded-2xl bg-primary px-4 py-3 text-center text-white">

                                    <div class="text-lg font-black">
                                        ★ 4.9
                                    </div>

                                    <div class="text-xs opacity-80">
                                        ۲۳۶ نظر
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- ================= CONTENT ================= --}}
            <div class="order-2">

                {{-- Status --}}
                <div class="inline-flex items-center gap-2 rounded-full bg-green-500/10 px-4 py-2 text-sm font-bold text-green-400">

                    <span class="h-2.5 w-2.5 rounded-full bg-green-400 animate-pulse"></span>

                    امروز تا ساعت ۲۲:۰۰ پذیرش داریم

                </div>

                {{-- Heading --}}
                <h1 class="mt-6 text-4xl font-black leading-tight text-text lg:text-6xl">

                    امروز چه
                    <span class="text-primary">
                        استایلی
                    </span>

                    انتخاب می‌کنی؟

                </h1>

                {{-- Description --}}
                <p class="mt-6 max-w-lg leading-8 text-muted">

                    مدل‌های ترند، نمونه‌کارهای آرایشگاه و نظر مشتری‌ها را ببین،
                    سپس زمان مناسب خودت را انتخاب و نوبتت را ثبت کن.

                </p>

                {{-- Quick Info --}}
                <div class="mt-8 grid grid-cols-2 gap-4">

                    <div class="rounded-2xl border border-border bg-surface p-5">

                        <p class="text-sm text-muted">
                            وضعیت
                        </p>

                        <p class="mt-2 font-bold text-green-400">
                            باز
                        </p>

                    </div>

                    <div class="rounded-2xl border border-border bg-surface p-5">

                        <p class="text-sm text-muted">
                            موقعیت
                        </p>

                        <p class="mt-2 font-bold text-text">
                            قزوین
                        </p>

                    </div>

                </div>

                {{-- CTA --}}
                <div class="mt-10 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="#booking"
                        class="inline-flex items-center justify-center rounded-2xl bg-primary px-8 py-4 font-bold text-white transition hover:bg-primary-hover">

                        رزرو نوبت

                    </a>

                    <a
                        href="#gallery"
                        class="inline-flex items-center justify-center rounded-2xl border border-border bg-surface px-8 py-4 font-bold text-text transition hover:border-primary hover:text-primary">

                        مشاهده نمونه‌کارها

                    </a>

                </div>

            </div>

        </div>

    </div>

</header>
