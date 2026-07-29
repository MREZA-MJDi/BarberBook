<section class="bg-background" dir="rtl">
    <div class="container px-6 py-20 mx-auto">

        {{-- Title --}}
        <div class="text-center">

            <h2 class="text-3xl font-black text-text md:text-4xl">
                نمونه‌کارهای
                <span class="text-primary">
                    آرایشگاه آلیجناب
                </span>
            </h2>

            <p class="max-w-2xl mx-auto mt-5 leading-8 text-muted">
                جدیدترین مدل‌های اصلاح، استایل مو و خدمات تخصصی
                که توسط علی مجیدی انجام شده است.
            </p>

        </div>

        {{-- Gallery --}}
        <div class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2 xl:grid-cols-3">

            {{-- Card 1 --}}
            <div class="relative overflow-hidden border shadow-lg h-[420px] rounded-3xl border-border bg-surface group">

                <img
                    src="{{ asset('images/work-1.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="اصلاح کلاسیک">

                <div
                    class="absolute inset-0 flex flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-primary/90 via-primary/30 to-transparent group-hover:opacity-100">

                    <h3 class="text-xl font-bold text-white">
                        اصلاح کلاسیک
                    </h3>

                    <p class="mt-2 text-sm text-white/80">
                        مدل مو
                    </p>

                </div>

            </div>

            {{-- Card 2 --}}
            <div class="relative overflow-hidden border shadow-lg h-[420px] rounded-3xl border-border bg-surface group">

                <img
                    src="{{ asset('images/work-3.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="استایل مدرن">

                <div
                    class="absolute inset-0 flex flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-secondary/90 via-secondary/30 to-transparent group-hover:opacity-100">

                    <h3 class="text-xl font-bold text-white">
                        استایل مدرن
                    </h3>

                    <p class="mt-2 text-sm text-white/80">
                        کوتاهی و فرم‌دهی
                    </p>

                </div>

            </div>

            {{-- Card 3 --}}
            <div class="relative overflow-hidden border shadow-lg h-[420px] rounded-3xl border-border bg-surface group">

                <img
                    src="{{ asset('images/work-2.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="مدل داماد">

                <div
                    class="absolute inset-0 flex flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-primary/90 via-secondary/20 to-transparent group-hover:opacity-100">

                    <h3 class="text-xl font-bold text-white">
                        مدل ویژه داماد
                    </h3>

                    <p class="mt-2 text-sm text-white/80">
                        خدمات VIP
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>
