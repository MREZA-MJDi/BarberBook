<section class="w-full py-20 bg-zinc-950" dir="rtl">

    <div class="max-w-3xl px-6 mx-auto">


        {{-- Title --}}
        <div class="mb-10 text-center">

            <h2 class="text-3xl font-black text-white md:text-4xl">

                انتخاب تاریخ نوبت

            </h2>


            <p class="mt-4 text-zinc-400">

                روز مناسب خودت را برای مراجعه انتخاب کن

            </p>

        </div>




        {{-- Calendar --}}
        <div
            class="p-6 border shadow-2xl bg-zinc-900 border-zinc-800 rounded-3xl">



            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">


                <button
                    class="flex items-center justify-center w-11 h-11 transition rounded-full bg-zinc-800 text-zinc-300 hover:bg-zinc-700">

                    ‹

                </button>



                <h3 class="text-lg font-bold text-white">

                    مرداد ۱۴۰۵

                </h3>




                <button
                    class="flex items-center justify-center w-11 h-11 transition rounded-full bg-zinc-800 text-zinc-300 hover:bg-zinc-700">

                    ›

                </button>


            </div>





            {{-- Week Days --}}
            <div class="grid grid-cols-7 gap-3 mb-5 text-center">


                @foreach(['ش','ی','د','س','چ','پ','ج'] as $day)

                    <span class="text-sm font-medium text-zinc-500">

                        {{ $day }}

                    </span>

                @endforeach


            </div>





            {{-- Dates --}}
            <div class="grid grid-cols-7 gap-3">


                @for ($i = 1; $i <= 30; $i++)

                    <button
                        class="
                        w-11 h-11 mx-auto
                        rounded-full
                        flex items-center justify-center
                        text-sm font-semibold
                        transition

                        bg-zinc-800
                        text-zinc-300

                        hover:bg-white
                        hover:text-black

                        ">

                        {{ $i }}

                    </button>


                @endfor



            </div>


        </div>


    </div>


</section>
