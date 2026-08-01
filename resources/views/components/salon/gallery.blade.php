<section id="gallery" class="py-20 bg-background" dir="rtl">

    <div class="max-w-7xl px-5 mx-auto">

        {{-- Header --}}
        <div class="flex items-end justify-between">

            <div>

                <span class="text-sm font-bold tracking-widest uppercase text-primary">

                    Gallery

                </span>

                <h2 class="mt-2 text-3xl font-black text-text lg:text-4xl">

                    آخرین نمونه‌کارها

                </h2>

                <p class="mt-3 max-w-xl leading-8 text-muted">

                    چند نمونه از اصلاح‌ها و استایل‌هایی که اخیراً در آرایشگاه انجام شده است.

                </p>

            </div>

        </div>

        {{-- Gallery --}}
        <div
            class="flex gap-5 mt-10 overflow-x-auto snap-x snap-mandatory pb-2">

            {{-- Card 1 --}}
            <div
                class="group relative min-w-[260px] h-[420px] overflow-hidden rounded-[30px] snap-start">

                <img
                    src="{{ asset('images/work-1.jpg') }}"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-110"
                    alt="">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                <div
                    class="absolute bottom-5 right-5 left-5">

                    <span
                        class="rounded-full bg-white/10 px-4 py-2 text-sm font-bold text-white backdrop-blur">

                        French Crop

                    </span>

                </div>

            </div>

            {{-- Card 2 --}}
            <div
                class="group relative min-w-[220px] h-[320px] mt-12 overflow-hidden rounded-[26px] snap-start">

                <img
                    src="{{ asset('images/work-2.jpg') }}"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-110"
                    alt="">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                <div
                    class="absolute bottom-5 right-5">

                    <span
                        class="rounded-full bg-primary px-3 py-2 text-xs font-bold text-white">

                        Fade

                    </span>

                </div>

            </div>

            {{-- Card 3 --}}
            <div
                class="group relative min-w-[300px] h-[480px] overflow-hidden rounded-[34px] snap-start">

                <img
                    src="{{ asset('images/work-3.jpg') }}"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-110"
                    alt="">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                <div
                    class="absolute bottom-5 right-5">

                    <span
                        class="rounded-full bg-white/10 px-4 py-2 text-sm font-bold text-white backdrop-blur">

                        Buzz Cut

                    </span>

                </div>

            </div>

            {{-- Card 4 --}}
            <div
                class="group relative min-w-[240px] h-[360px] mt-20 overflow-hidden rounded-[28px] snap-start">

                <img
                    src="{{ asset('images/Modern-Barbershop-interior-design.png') }}"
                    class="object-cover w-full h-full transition duration-500 group-hover:scale-110"
                    alt="">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                <div
                    class="absolute bottom-5 right-5">

                    <span
                        class="rounded-full bg-primary px-4 py-2 text-sm font-bold text-white">

                        Modern

                    </span>

                </div>

            </div>

        </div>

    </div>

</section>
