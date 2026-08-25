<section
    class="relative overflow-hidden bg-background text-text"
    dir="rtl"
>

    <div class="max-w-7xl mx-auto px-6 py-20 lg:py-28">

        <div class="grid items-center gap-12 lg:grid-cols-2">


            {{-- Content --}}

            <div>


                {{-- Badge --}}

                <span
                    class="
                    inline-flex items-center gap-2
                    rounded-full
                    border border-primary/20
                    bg-primary/10
                    px-5 py-2
                    text-sm font-bold
                    text-primary
                    "
                >

                    ✨ رزرو آنلاین آرایشگاه

                </span>


                {{-- Title --}}

                <h1
                    class="
                    mt-7
                    text-4xl
                    font-black
                    leading-tight
                    text-text
                    lg:text-6xl
                    "
                >

                    {{ $salon->name ?? 'آرایشگاه آلیجناب' }}

                </h1>


                {{-- Description --}}

                <p
                    class="
                    mt-6
                    max-w-xl
                    text-lg
                    leading-9
                    text-muted
                    "
                >

                    {{ $salon->description ?? 'تجربه‌ای متفاوت از اصلاح و استایل حرفه‌ای با بهترین خدمات آرایشگاهی' }}

                </p>


                {{-- Stats --}}

                <div class="flex flex-wrap gap-4 mt-8">


                    <div
                        class="
                        rounded-2xl
                        border border-border
                        bg-surface
                        px-5 py-3
                        "
                    >

                        ⭐

                        <span class="text-primary font-bold">
                        </span>

                        امتیاز

                    </div>


                    <div
                        class="
                        rounded-2xl
                        border border-border
                        bg-surface
                        px-5 py-3
                        "
                    >

                        📍

                    </div>


                </div>


                {{-- Buttons --}}

                <div class="flex flex-wrap gap-4 mt-10">


                    <a
                        href="#booking"
                        class="
                        rounded-2xl
                        bg-primary
                        px-8 py-4
                        font-black
                        text-white
                        transition
                        hover:bg-primary/90
                        shadow-[0_0_35px_rgba(249,115,22,.25)]
                        "
                    >

                        رزرو نوبت

                    </a>


                    <a
                        href="#services"
                        class="
                        rounded-2xl
                        border
                        border-border
                        px-8 py-4
                        font-bold
                        text-text
                        transition
                        hover:border-primary
                        hover:text-primary
                        "
                    >

                        مشاهده خدمات

                    </a>


                </div>


            </div>


            {{-- Image --}}

            <div class="relative">


                {{-- Glow --}}

                <div
                    class="
                    absolute
                    -inset-5
                    rounded-[50px]
                    bg-primary/20
                    blur-3xl
                    "
                ></div>


                <div
                    class="
                    relative
                    overflow-hidden
                    rounded-[45px]
                    border
                    border-border
                    "
                >

                    <img

                        src="{{ asset('images/hero2.jpg') }}"

                        alt="Salon"

                        class="
    h-[550px]
    w-full
    object-cover
    "

                    >

                    {{-- Image Overlay --}}

                    <div
                        class="
                        absolute
                        inset-0
                        bg-gradient-to-t
                        from-background/90
                        via-transparent
                        "
                    ></div>


                    {{-- Floating Card --}}

                    <div
                        class="
                        absolute
                        bottom-6
                        right-6
                        rounded-3xl
                        border
                        border-border
                        bg-background/80
                        backdrop-blur
                        px-6 py-4
                        "
                    >

                        <p class="text-sm text-muted">
                            متخصص استایل و اصلاح
                        </p>

                        <p class="mt-1 font-black text-primary">
                            بهترین تجربه برای شما
                        </p>


                    </div>


                </div>


            </div>


        </div>


    </div>


</section>
