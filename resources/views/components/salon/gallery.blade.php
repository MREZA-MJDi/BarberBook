<section class="bg-zinc-950" dir="rtl">
    <div class="container px-6 py-20 mx-auto">

        {{-- Title --}}
        <div class="text-center">

            <h2 class="text-3xl font-black text-white md:text-4xl">
                نمونه‌کارهای
                <span class="text-zinc-300">
                    آرایشگاه آلیجناب
                </span>
            </h2>

            <p class="max-w-2xl mx-auto mt-5 leading-8 text-zinc-400">
                جدیدترین مدل‌های اصلاح، استایل مو و خدمات تخصصی
                که توسط علی مجیدی انجام شده است.
            </p>

        </div>


        {{-- Gallery --}}
        <div class="grid grid-cols-1 gap-8 mt-12 md:grid-cols-2 xl:grid-cols-3">


            {{-- Card --}}
            <div class="relative h-[420px] overflow-hidden rounded-3xl group">

                <img
                    src="{{ asset('images/work-1.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="اصلاح کلاسیک">

                <div
                    class="absolute inset-0 flex flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-black via-black/40 to-transparent group-hover:opacity-100">

                    <h3 class="text-xl font-bold text-white">
                        اصلاح کلاسیک
                    </h3>

                    <p class="mt-2 text-sm text-zinc-300">
                        مدل مو
                    </p>

                </div>

            </div>



            <div class="relative h-[420px] overflow-hidden rounded-3xl group">

                <img
                    src="{{ asset('images/work-3.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="استایل مدرن">


                <div
                    class="absolute inset-0 flex flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-black via-black/40 to-transparent group-hover:opacity-100">


                    <h3 class="text-xl font-bold text-white">
                        استایل مدرن
                    </h3>

                    <p class="mt-2 text-sm text-zinc-300">
                        کوتاهی و فرم‌دهی
                    </p>


                </div>

            </div>




            <div class="relative h-[420px] overflow-hidden rounded-3xl group">

                <img
                    src="{{ asset('images/work-2.jpg') }}"
                    class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                    alt="مدل داماد">


                <div
                    class="absolute inset-0 flexا flex-col justify-end p-8 transition duration-500 opacity-0 bg-gradient-to-t from-black via-black/40 to-transparent group-hover:opacity-100">


                    <h3 class="text-xl font-bold text-white">
                        مدل ویژه داماد
                    </h3>

                    <p class="mt-2 text-sm text-zinc-300">
                        خدمات VIP
                    </p>


                </div>

            </div>


        </div>

    </div>
</section>
