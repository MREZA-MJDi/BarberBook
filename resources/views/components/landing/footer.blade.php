<footer class="border-t border-zinc-200 bg-zinc-50">
    <div class="container mx-auto px-6 py-16">

        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12">

            {{-- Logo & Description --}}
            <div class="lg:col-span-5">

                <x-ui.logo />

                <p class="mt-6 max-w-md text-[14px] leading-8 text-zinc-500">
                    سامانه نوبت‌دهی آنلاین برای آرایشگاه‌ها و سالن‌های زیبایی.
                    مدیریت ساده نوبت‌ها، مشتریان و خدمات در یک پنل مدرن.
                </p>

                <div class="mt-8 flex items-center gap-3">

                    <a href="#"
                       class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 text-zinc-500 transition duration-200 hover:border-zinc-900 hover:text-zinc-900">

                        {{-- Instagram Icon --}}
                    </a>

                    <a href="#"
                       class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 text-zinc-500 transition duration-200 hover:border-zinc-900 hover:text-zinc-900">

                        {{-- Telegram Icon --}}
                    </a>

                    <a href="#"
                       class="flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 text-zinc-500 transition duration-200 hover:border-zinc-900 hover:text-zinc-900">

                        {{-- Linkedin Icon --}}
                    </a>

                </div>

            </div>

            {{-- About --}}
            <div class="lg:col-span-2">

                    <h3 class="text-[15px] font-symbols tracking-tight text-zinc-900">
                    درباره
                </h3>

                <div class="mt-4 flex flex-col gap-2">

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        درباره ما
                    </a>

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        تماس با ما
                    </a>

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        قوانین و مقررات
                    </a>

                </div>

            </div>

            {{-- Services --}}
            <div class="lg:col-span-2">

                <h3 class="text-[15px] font-semibold tracking-tight text-zinc-900">
                    خدمات
                </h3>

                <div class="mt-4 flex flex-col gap-2">

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        رزرو نوبت
                    </a>

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        مدیریت سالن
                    </a>

                    <a href="#"
                       class="text-[14px] leading-7 text-zinc-500 transition duration-200 hover:translate-x-1 hover:text-zinc-900">
                        پنل مشتری
                    </a>

                </div>

            </div>

            {{-- Contact --}}
            <div class="lg:col-span-3">

                <h3 class="text-[15px] font-semibold tracking-tight text-zinc-900">
                    ارتباط
                </h3>

                <div class="mt-4 flex flex-col gap-2 text-[14px] leading-7 text-zinc-500">

                    <span>support@nobat.ir</span>

                    <span>0912 000 0000</span>

                    <span>شنبه تا پنجشنبه | ۹:۰۰ الی ۱۸:۰۰</span>

                </div>

            </div>

        </div>

        <div class="my-10 border-t border-zinc-200"></div>

        <div class="flex flex-col-reverse items-center justify-between gap-5 text-xs tracking-wide text-zinc-500 md:flex-row">

            <div class="flex gap-6">

                <a href="#" class="transition hover:text-zinc-900">
                    حریم خصوصی
                </a>

                <a href="#" class="transition hover:text-zinc-900">
                    قوانین استفاده
                </a>

                <a href="#" class="transition hover:text-zinc-900">
                    پشتیبانی
                </a>

            </div>

            <p>
                © {{ date('Y') }} BarberBook. تمامی حقوق محفوظ است.
            </p>

        </div>

    </div>
</footer>
