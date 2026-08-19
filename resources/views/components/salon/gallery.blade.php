<section id="gallery" class="py-20 bg-background" dir="rtl">

    <div class="max-w-7xl px-5 mx-auto">

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

        @if($galleryItems->isNotEmpty())

            @php
                $variants = [
                    'min-w-[260px] h-[420px]',
                    'min-w-[220px] h-[320px] mt-12',
                    'min-w-[300px] h-[480px]',
                    'min-w-[240px] h-[360px] mt-20',
                ];
            @endphp

            <div class="flex gap-5 mt-10 overflow-x-auto snap-x snap-mandatory pb-2">

                @foreach($galleryItems as $index => $item)

                    @php
                        $variant = $variants[$index % count($variants)];
                    @endphp

                    <div
                        class="group relative {{ $variant }} overflow-hidden rounded-[30px] snap-start"
                    >

                        <img
                            src="{{ Storage::url($item->image_path) }}"
                            class="object-cover w-full h-full transition duration-500 group-hover:scale-110"
                            alt="{{ $item->alt_text ?: $item->title ?: 'نمونه‌کار آرایشگاه' }}"
                        >

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                        @if($item->title)

                            <div class="absolute bottom-5 right-5 left-5">

                                <span class="rounded-full bg-white/10 px-4 py-2 text-sm font-bold text-white backdrop-blur">

                                    {{ $item->title }}

                                </span>

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>
