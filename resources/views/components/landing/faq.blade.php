<section class="bg-zinc-950 py-24" x-data="{ open: 1 }">

    <div class="container mx-auto max-w-4xl px-6">

        <div class="text-center">

            <span class="text-sm font-semibold uppercase tracking-widest text-zinc-400">
                سوالات متداول
            </span>

            <h2 class="mt-4 text-4xl font-bold text-white">
                پاسخ سوالات شما
            </h2>

            <p class="mt-6 text-lg text-zinc-400">
                اگر پاسخ سوالتان را پیدا نکردید، با ما در ارتباط باشید.
            </p>

        </div>

        <div class="mt-14 space-y-5">

            {{-- Item 1 --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900">

                <button
                    @click="open = open === 1 ? null : 1"
                    class="flex w-full items-center justify-between p-6 text-right">

                    <h3 class="text-lg font-semibold text-white">
                        چگونه نوبت رزرو کنم؟
                    </h3>

                    <x-lucide-chevron-down
                        class="h-5 w-5 text-zinc-400 transition duration-300"
                        x-bind:class="{ 'rotate-180': open === 1 }" />

                </button>

                <div
                    x-show="open === 1"
                    x-collapse>

                    <p class="px-6 pb-6 leading-8 text-zinc-400">

                        کافی است آرایشگاه موردنظر، خدمات و زمان دلخواهتان را انتخاب کنید
                        و در کمتر از یک دقیقه نوبت خود را ثبت نمایید.

                    </p>

                </div>

            </div>

            {{-- Item 2 --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900">

                <button
                    @click="open = open === 2 ? null : 2"
                    class="flex w-full items-center justify-between p-6 text-right">

                    <h3 class="text-lg font-semibold text-white">
                        آیا امکان لغو یا تغییر نوبت وجود دارد؟
                    </h3>

                    <x-lucide-chevron-down
                        class="h-5 w-5 text-zinc-400 transition duration-300"
                        x-bind:class="{ 'rotate-180': open === 2 }" />

                </button>

                <div
                    x-show="open === 2"
                    x-collapse>

                    <p class="px-6 pb-6 leading-8 text-zinc-400">

                        بله، تا قبل از زمان مراجعه می‌توانید نوبت خود را از پنل کاربری
                        لغو یا ویرایش کنید.

                    </p>

                </div>

            </div>

            {{-- Item 3 --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900">

                <button
                    @click="open = open === 3 ? null : 3"
                    class="flex w-full items-center justify-between p-6 text-right">

                    <h3 class="text-lg font-semibold text-white">
                        آیا برای رزرو باید ثبت‌نام کنم؟
                    </h3>

                    <x-lucide-chevron-down
                        class="h-5 w-5 text-zinc-400 transition duration-300"
                        x-bind:class="{ 'rotate-180': open === 3 }" />

                </button>

                <div
                    x-show="open === 3"
                    x-collapse>

                    <p class="px-6 pb-6 leading-8 text-zinc-400">

                        بله، با ساخت حساب کاربری می‌توانید سوابق نوبت‌ها و وضعیت رزروهای
                        خود را مشاهده و مدیریت کنید.

                    </p>

                </div>

            </div>

            {{-- Item 4 --}}
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900">

                <button
                    @click="open = open === 4 ? null : 4"
                    class="flex w-full items-center justify-between p-6 text-right">

                    <h3 class="text-lg font-semibold text-white">
                        آیا پیامک یادآوری ارسال می‌شود؟
                    </h3>

                    <x-lucide-chevron-down
                        class="h-5 w-5 text-zinc-400 transition duration-300"
                        x-bind:class="{ 'rotate-180': open === 4 }" />

                </button>

                <div
                    x-show="open === 4"
                    x-collapse>

                    <p class="px-6 pb-6 leading-8 text-zinc-400">

                        بله، قبل از زمان نوبت برای شما پیامک یادآوری ارسال خواهد شد.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>
