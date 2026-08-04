<header class="relative overflow-hidden bg-background" dir="rtl">

    {{-- Background Glow --}}
    <div class="absolute inset-x-0 top-0 flex justify-center pointer-events-none">
        <div class="h-72 w-72 rounded-full bg-primary/15 blur-[140px]"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-5 py-8 lg:px-8">

        <div class="grid items-center gap-10 lg:grid-cols-2">

            {{-- ================= IMAGE ================= --}}
            {{-- ================= IMAGE ================= --}}
            <div class="order-1">

                <div class="relative">


                    <div
                        class="
            overflow-hidden
            rounded-[24px]
            border
            border-border/50
            bg-surface
            shadow-xl
            "
                    >

                        <img
                            src="{{ asset('images/login.jpg') }}"
                            alt="آرایشگاه آلیجناب"
                            class="
                h-[480px]
                w-full
                object-cover
                lg:h-[580px]
                "
                        >


                        {{-- Cinematic Overlay --}}

                        <div
                            class="
                absolute
                inset-0
                bg-gradient-to-t
                from-black/70
                via-black/10
                to-transparent
                "
                        ></div>


                    </div>


                    {{-- Small Luxury Tag --}}

                    <div
                        class="
            absolute
            bottom-6
            right-6
            rounded-2xl
            border
            border-white/10
            bg-black/50
            px-5
            py-3
            backdrop-blur-xl
            "
                    >

                        <p class="text-sm text-white/70">
                            Premium Barber
                        </p>

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
                <h1 class="mt-6 text-5xl font-black leading-tight text-text lg:text-7xl">

                    Define Your
                    <span class="text-primary">
        Signature Style
    </span>

                </h1>                    <span class="text-primary">
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
