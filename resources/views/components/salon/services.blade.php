<section class="py-20 bg-zinc-950" dir="rtl">

    <div class="container px-6 mx-auto">


        {{-- Title --}}
        <div class="max-w-2xl mx-auto text-center">

            <h2 class="text-3xl font-black text-white md:text-4xl">

                خدمات
                <span class="text-zinc-300">
                    آرایشگاه آلیجناب
                </span>

            </h2>


            <p class="mt-5 leading-8 text-zinc-400">

                خدمات تخصصی اصلاح و زیبایی را انتخاب کنید و
                زمان مناسب خودتان را رزرو کنید.

            </p>

        </div>



        {{-- Services Grid --}}
        <div class="grid gap-10 mt-14 sm:grid-cols-2 lg:grid-cols-3">



            {{-- Service Card --}}
            <div class="max-w-sm mx-auto group">


                {{-- Image --}}
                <div class="h-72 overflow-hidden rounded-3xl">

                    <img
                        src="{{ asset('images/service-3.jpg') }}"
                        class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                        alt="اصلاح کلاسیک">

                </div>



                {{-- Info --}}
                <div
                    class="relative w-64 mx-auto -mt-12 overflow-hidden rounded-2xl bg-zinc-900 shadow-2xl">


                    <h3 class="py-5 text-lg font-bold text-center text-white">

                        اصلاح کلاسیک

                    </h3>



                    <div class="flex items-center justify-between px-5 py-4 bg-black">


                        <span class="font-bold text-zinc-200">

                            250 هزار تومان

                        </span>


                        <button
                            class="px-4 py-2 text-xs font-bold text-black transition bg-white rounded-xl hover:bg-zinc-200">

                            رزرو

                        </button>


                    </div>


                </div>


            </div>





            {{-- Service 2 --}}
            <div class="max-w-sm mx-auto group">


                <div class="h-72 overflow-hidden rounded-3xl">

                    <img
                        src="{{ asset('images/work-1.jpg') }}"
                        class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                        alt="اصلاح ریش">

                </div>



                <div
                    class="relative w-64 mx-auto -mt-12 overflow-hidden rounded-2xl bg-zinc-900 shadow-2xl">


                    <h3 class="py-5 text-lg font-bold text-center text-white">

                        اصلاح ریش

                    </h3>


                    <div class="flex items-center justify-between px-5 py-4 bg-black">


                        <span class="font-bold text-zinc-200">

                            120 هزار تومان

                        </span>


                        <button
                            class="px-4 py-2 text-xs font-bold text-black transition bg-white rounded-xl hover:bg-zinc-200">

                            رزرو

                        </button>


                    </div>


                </div>


            </div>





            {{-- Service 3 --}}
            <div class="max-w-sm mx-auto group">


                <div class="h-72 overflow-hidden rounded-3xl">


                    <img
                        src="{{ asset('images/work-3.jpg') }}"
                        class="object-cover w-full h-full transition duration-700 group-hover:scale-110"
                        alt="خدمات VIP">


                </div>




                <div
                    class="relative w-64 mx-auto -mt-12 overflow-hidden rounded-2xl bg-zinc-900 shadow-2xl">


                    <h3 class="py-5 text-lg font-bold text-center text-white">

                        خدمات VIP

                    </h3>


                    <div class="flex items-center justify-between px-5 py-4 bg-black">


                        <span class="font-bold text-zinc-200">

                            500 هزار تومان

                        </span>


                        <button
                            class="px-4 py-2 text-xs font-bold text-black transition bg-white rounded-xl hover:bg-zinc-200">

                            رزرو

                        </button>


                    </div>


                </div>


            </div>



        </div>


    </div>


</section>
