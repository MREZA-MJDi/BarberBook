<div
    class="group overflow-hidden rounded-[30px] border border-border bg-surface transition-all duration-300 hover:-translate-y-2 hover:border-primary/40 hover:shadow-2xl">

    {{-- Image --}}
    <div class="relative h-72 overflow-hidden">

        <img
            src="{{ asset('images/service-3.jpg') }}"
            alt="اصلاح کلاسیک"
            class="h-full w-full object-cover transition duration-700 group-hover:scale-110">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>

        {{-- Badge --}}
        <span
            class="absolute top-4 right-4 rounded-full bg-primary px-3 py-1.5 text-xs font-bold text-white shadow-lg">

            🔥 محبوب

        </span>

        {{-- Rating --}}
        <div
            class="absolute bottom-4 left-4 flex items-center gap-2 rounded-full bg-black/50 px-3 py-2 text-sm text-white backdrop-blur">

            <span>⭐ 4.9</span>

            <span class="text-white/70">

                (۲۳۴ نظر)

            </span>

        </div>

    </div>

    {{-- Content --}}
    <div class="p-6">

        {{-- Title --}}
        <div class="flex items-start justify-between gap-4">

            <div>

                <h3 class="text-2xl font-black text-text">

                    اصلاح کلاسیک

                </h3>

                <p class="mt-2 text-sm leading-7 text-muted">

                    اصلاح حرفه‌ای همراه با شستشو و استایل مو.

                </p>

            </div>

            <div
                class="rounded-xl bg-primary/10 px-3 py-2 text-xs font-bold text-primary whitespace-nowrap">

                ⏱ ۴۵ دقیقه

            </div>

        </div>

        {{-- Tags --}}
        <div class="mt-6 flex flex-wrap gap-2">

            <span
                class="rounded-full bg-background px-3 py-1.5 text-xs text-muted border border-border">

                ✂ اصلاح

            </span>

            <span
                class="rounded-full bg-background px-3 py-1.5 text-xs text-muted border border-border">

                💈 استایل

            </span>

            <span
                class="rounded-full bg-background px-3 py-1.5 text-xs text-muted border border-border">

                🧴 شستشو

            </span>

        </div>

        {{-- Info --}}
        <div
            class="mt-6 flex items-center justify-between rounded-2xl bg-background px-4 py-3">

            <div class="flex items-center gap-2 text-sm text-muted">

                🔥

                <span>

                    ۱۲۶ رزرو موفق

                </span>

            </div>

            <div class="flex items-center gap-2 text-sm text-muted">

                💬

                <span>

                    ۲۳۴ نظر

                </span>

            </div>

        </div>

        {{-- Footer --}}
        <div class="mt-8 flex items-center justify-between">

            <div>

                <p class="text-xs text-muted">

                    قیمت

                </p>

                <p class="mt-1 text-2xl font-black text-secondary">

                    ۲۵۰,۰۰۰ تومان

                </p>

            </div>

            <button
                class="rounded-2xl bg-primary px-6 py-3 font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-primary-hover active:scale-95">

                انتخاب سرویس

            </button>

        </div>

    </div>

</div>
