<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- Header --}}
    <div class="flex items-start justify-between">


        <div>

            <h2 class="text-lg font-black text-white">

                درآمد ماهانه

            </h2>


            <p class="mt-1 text-sm text-zinc-500">

                بررسی رشد درآمد سالن

            </p>


        </div>



        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl border border-orange-500/20 bg-orange-500/10">


            <x-lucide-chart-line
                class="h-5 w-5 text-orange-500" />


        </div>


    </div>





    {{-- Numbers --}}
    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">


        <div class="rounded-xl bg-zinc-950 p-4">


            <p class="text-sm text-zinc-500">
                درآمد این ماه
            </p>


            <h3 class="mt-2 text-2xl font-black text-white">
                18,500,000
            </h3>


            <span class="text-xs text-zinc-500">
                تومان
            </span>


        </div>






        <div class="rounded-xl bg-zinc-950 p-4">


            <p class="text-sm text-zinc-500">
                هدف ماه
            </p>


            <h3 class="mt-2 text-2xl font-black text-white">
                25,000,000
            </h3>


            <span class="text-xs text-zinc-500">
                تومان
            </span>


        </div>






        <div class="rounded-xl bg-zinc-950 p-4">


            <p class="text-sm text-zinc-500">
                رشد نسبت به ماه قبل
            </p>


            <h3 class="mt-2 text-2xl font-black text-green-400">
                +18%
            </h3>


        </div>



    </div>







    {{-- Progress --}}
    <div class="mt-6">


        <div class="mb-2 flex justify-between text-sm">


            <span class="text-zinc-400">
                پیشرفت هدف ماهانه
            </span>


            <span class="font-bold text-white">
                74%
            </span>


        </div>



        <div class="h-3 overflow-hidden rounded-full bg-zinc-800">


            <div
                class="h-full rounded-full bg-orange-500"
                style="width:74%">
            </div>


        </div>



    </div>








    {{-- Fake Chart --}}
    <div class="mt-8">


        <div class="flex h-40 items-end gap-3">


            <div class="h-[35%] flex-1 rounded-t-xl bg-orange-500/20"></div>


            <div class="h-[50%] flex-1 rounded-t-xl bg-orange-500/30"></div>


            <div class="h-[65%] flex-1 rounded-t-xl bg-orange-500/40"></div>


            <div class="h-[45%] flex-1 rounded-t-xl bg-orange-500/30"></div>


            <div class="h-[80%] flex-1 rounded-t-xl bg-orange-500/60"></div>


            <div class="h-[90%] flex-1 rounded-t-xl bg-orange-500/80"></div>


        </div>



        <div class="mt-3 flex justify-between text-xs text-zinc-600">

            <span>شنبه</span>
            <span>یکشنبه</span>
            <span>دوشنبه</span>
            <span>سه‌شنبه</span>
            <span>چهارشنبه</span>
            <span>پنجشنبه</span>

        </div>


    </div>



</div>
