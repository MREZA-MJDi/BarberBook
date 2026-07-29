<div
    class="group overflow-hidden rounded-[32px] border border-border bg-surface transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_25px_60px_rgba(0,0,0,.10)]">

    {{-- Image --}}
    <div class="relative overflow-hidden h-80">

        <img
            src="{{ asset('images/model1.jpg') }}"
            alt="French Crop"
            class="h-full w-full object-contain transition duration-700 group-hover:scale-110">

        {{-- Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

        {{-- Rank --}}
        <div
            class="absolute top-5 right-5 rounded-full bg-white/90 px-4 py-2 text-xs font-bold text-secondary backdrop-blur">

            🥇 ترند شماره ۱

        </div>

        {{-- Rating --}}
        <div
            class="absolute bottom-5 left-5 rounded-full bg-black/50 px-4 py-2 text-sm text-white backdrop-blur">

            ⭐ 4.9
            <span class="text-white/70">
                (۲۳۴ نظر)
            </span>

        </div>

    </div>

    {{-- Body --}}
    <div class="p-7">

        <h3 class="text-2xl font-black text-text">

            French Crop

        </h3>

        <p class="mt-2 leading-7 text-muted">

            یکی از محبوب‌ترین مدل‌های سال ۲۰۲۶ با حجم طبیعی و فید حرفه‌ای.

        </p>

        {{-- Stats --}}
        <div class="mt-6 grid grid-cols-3 gap-3">

            <div class="rounded-2xl bg-background p-3 text-center">

                <div class="text-lg font-black text-secondary">

                    🔥 ۱۲۶

                </div>

                <div class="mt-1 text-xs text-muted">

                    رزرو

                </div>

            </div>

            <div class="rounded-2xl bg-background p-3 text-center">

                <div class="text-lg font-black text-secondary">

                    ⏱ ۴۵

                </div>

                <div class="mt-1 text-xs text-muted">

                    دقیقه

                </div>

            </div>

            <div class="rounded-2xl bg-background p-3 text-center">

                <div class="text-lg font-black text-secondary">

                    💬 ۲۳۴

                </div>

                <div class="mt-1 text-xs text-muted">

                    نظر

                </div>

            </div>

        </div>

        {{-- Footer --}}
        <div class="mt-8 flex items-center justify-between">

            <div>

                <p class="text-sm text-muted">

                    شروع از

                </p>

                <p class="mt-1 text-2xl font-black text-secondary">

                    ۲۵۰ هزار تومان

                </p>

            </div>

            <button
                class="rounded-2xl bg-primary px-6 py-3 font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-primary-hover">

                انتخاب این مدل

            </button>

        </div>

    </div>

</div>
