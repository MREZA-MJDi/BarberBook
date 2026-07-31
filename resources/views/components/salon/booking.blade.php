<section id="booking" class="py-24 bg-background" dir="rtl">

    <div class="max-w-7xl mx-auto px-5">

        {{-- Header --}}
        <div class="text-center">

            <span
                class="inline-flex items-center rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary">

                رزرو آنلاین

            </span>

            <h2 class="mt-5 text-4xl font-black text-text">

                فقط چند قدم تا نوبتت باقی مونده

            </h2>

            <p class="mx-auto mt-4 max-w-2xl leading-8 text-muted">

                تاریخ و ساعت مناسب خودت رو انتخاب کن و بدون تماس تلفنی نوبتت رو ثبت کن.

            </p>

        </div>


        <div class="mt-14 grid gap-8 lg:grid-cols-3">


            {{-- Left --}}
            <div class="space-y-6 lg:col-span-2">


                {{-- Salon Info --}}
                <div
                    class="rounded-[30px] border border-border bg-surface p-7">


                    <div class="flex items-start justify-between">


                        <div>

                            <h3 class="text-2xl font-black text-text">

                                آرایشگاه آلیجناب

                            </h3>


                            <p class="mt-3 text-muted">

                                قزوین، خیابان فلسطین، روبروی بانک ملی

                            </p>


                        </div>


                        <span
                            class="rounded-full bg-primary/10 px-4 py-2 text-sm font-bold text-primary">

                            باز است

                        </span>


                    </div>



                    <div class="mt-6 flex flex-wrap gap-3">


                        <button
                            class="rounded-2xl border border-border bg-background px-5 py-3 font-semibold text-text transition hover:border-primary">

                            🗺 مشاهده روی نقشه

                        </button>


                        <button
                            class="rounded-2xl border border-border bg-background px-5 py-3 font-semibold text-text transition hover:border-primary">

                            📞 تماس

                        </button>


                    </div>


                </div>



                {{-- Calendar --}}
                <div class="grid gap-6 lg:grid-cols-2">

                    <x-booking.calendar/>

                    <x-booking.time-picker/>

                </div>



                {{-- Customer Message --}}
                <div
                    class="rounded-[30px] border border-border bg-surface p-7">


                    <h3 class="text-xl font-black text-text">

                        📝 توضیحات برای آرایشگر

                    </h3>


                    <p class="mt-2 text-sm leading-7 text-muted">

                        اگر درخواست خاصی درباره مدل مو یا خدمات داری اینجا بنویس.

                    </p>


                    <textarea
                        rows="4"
                        placeholder="مثلا: مدل مو مثل عکس قبلی باشه..."
                        class="mt-5 w-full rounded-2xl border border-border bg-background p-4 text-text outline-none transition focus:border-primary"></textarea>


                </div>



            </div>





            {{-- Summary --}}
            <div>


                <div
                    class="sticky top-24 rounded-[30px] border border-border bg-surface p-6 lg:p-8">


                    <h3 class="text-xl font-black text-text">

                        خلاصه رزرو

                    </h3>



                    <div class="mt-8 space-y-5">



                        <div class="flex justify-between">

                            <span class="text-muted">
                                مدل انتخابی
                            </span>

                            <span class="font-bold text-text">
                                French Crop
                            </span>

                        </div>



                        <div class="flex justify-between">

                            <span class="text-muted">
                                خدمت
                            </span>

                            <span class="font-bold text-text">
                                اصلاح کلاسیک
                            </span>

                        </div>



                        <div class="flex justify-between">

                            <span class="text-muted">
                                تاریخ
                            </span>

                            <span class="font-bold text-text">
                                انتخاب نشده
                            </span>

                        </div>




                        <div class="flex justify-between">

                            <span class="text-muted">
                                ساعت
                            </span>

                            <span class="font-bold text-text">
                                انتخاب نشده
                            </span>

                        </div>


                    </div>




                    {{-- Status Preview --}}
                    <div
                        class="mt-8 rounded-2xl bg-background p-4">


                        <div class="flex items-center gap-3">


                            <span
                                class="h-3 w-3 rounded-full bg-yellow-500">
                            </span>


                            <p class="text-sm font-bold text-text">

                                پس از ثبت، منتظر تایید آرایشگر باشید

                            </p>


                        </div>


                    </div>





                    <button
                        class="mt-8 w-full rounded-2xl bg-primary py-4 text-lg font-black text-white transition hover:bg-primary-hover">


                        ثبت نهایی رزرو


                    </button>




                </div>


            </div>


        </div>


    </div>


</section>
