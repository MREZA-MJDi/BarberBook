<section
    class="relative min-h-screen overflow-hidden bg-background text-text"
    dir="rtl"
>


    {{-- Background --}}
    <div class="absolute inset-0">

        <div
            class="
            absolute
            top-20
            right-1/3
            h-72
            w-72
            rounded-full
            bg-primary/10
            blur-[160px]
            "
        ></div>

    </div>




    <div
        class="
        relative
        mx-auto
        flex
        min-h-screen
        max-w-7xl
        flex-col
        px-6
        py-10
        lg:px-8
        "
    >



        {{-- Navbar Mini --}}

        <nav class="flex items-center justify-between">


            <div
                class="
                text-2xl
                font-black
                text-text
                "
            >

                BarberBook

            </div>



            <a
                href="#booking"
                class="
                rounded-2xl
                bg-primary
                px-6
                py-3
                font-bold
                text-white
                transition
                hover:bg-primary/90
                "
            >

                رزرو نوبت

            </a>


        </nav>






        {{-- Hero Content --}}

        <div
            class="
            flex
            flex-1
            items-center
            "
        >


            <div class="w-full text-center">



                <span
                    class="
                    inline-flex
                    rounded-full
                    border
                    border-primary/20
                    bg-primary/10
                    px-5
                    py-2
                    text-sm
                    font-bold
                    text-primary
                    "
                >

                    ✨ رزرو آنلاین آرایشگاه

                </span>




                <h1
                    class="
                    mt-8
                    text-5xl
                    font-black
                    leading-tight
                    text-text
                    md:text-7xl
                    lg:text-8xl
                    "
                >

                    استایل جدیدت

                    <br>

                    از اینجا

                    <span class="text-primary">

                        شروع میشه

                    </span>


                </h1>





                <p
                    class="
                    mx-auto
                    mt-8
                    max-w-3xl
                    text-lg
                    leading-9
                    text-muted
                    md:text-xl
                    "
                >

                    {{ $salon->name ?? 'آرایشگاه آلیجناب' }}

                    با تجربه حرفه‌ای،
                    خدمات تخصصی اصلاح و استایل مردانه را
                    با رزرو آنلاین در اختیار شما قرار می‌دهد.

                </p>







                {{-- Actions --}}

                <div
                    class="
                    mt-10
                    flex
                    flex-col
                    justify-center
                    gap-4
                    sm:flex-row
                    "
                >


                    <a
                        href="#booking"
                        class="
                        rounded-2xl
                        bg-primary
                        px-10
                        py-4
                        font-black
                        text-white
                        shadow-xl
                        transition
                        hover:bg-primary/90
                        "
                    >

                        همین الان رزرو کن

                    </a>




                    <a
                        href="#gallery"
                        class="
                        rounded-2xl
                        border
                        border-border
                        bg-surface
                        px-10
                        py-4
                        font-bold
                        text-text
                        transition
                        hover:border-primary
                        hover:text-primary
                        "
                    >

                        دیدن نمونه‌کارها

                    </a>



                </div>






                {{-- Trust Info --}}

                <div
                    class="
                    mx-auto
                    mt-14
                    grid
                    max-w-3xl
                    grid-cols-1
                    gap-4
                    sm:grid-cols-3
                    "
                >


                    <div
                        class="
                        rounded-3xl
                        border
                        border-border
                        bg-surface
                        p-5
                        "
                    >

                        <p class="text-2xl font-black text-primary">
                            4.9 ⭐
                        </p>

                        <p class="mt-2 text-sm text-muted">
                            امتیاز مشتریان
                        </p>


                    </div>




                    <div
                        class="
                        rounded-3xl
                        border
                        border-border
                        bg-surface
                        p-5
                        "
                    >

                        <p class="text-2xl font-black text-text">
                            ۲۳۶+
                        </p>

                        <p class="mt-2 text-sm text-muted">
                            مشتری راضی
                        </p>


                    </div>





                    <div
                        class="
                        rounded-3xl
                        border
                        border-border
                        bg-surface
                        p-5
                        "
                    >

                        <p class="text-2xl font-black text-green-400">
                            باز
                        </p>

                        <p class="mt-2 text-sm text-muted">
                            امروز تا ۲۲:۰۰
                        </p>


                    </div>



                </div>



            </div>



        </div>

    </div>


</section>
