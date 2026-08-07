<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- Header --}}
    <div class="flex items-center justify-between">


        <div>

            <h2 class="text-lg font-black text-white">

                رزرو بعدی

            </h2>


            <p class="mt-1 text-sm text-zinc-500">

                نزدیک‌ترین مشتری شما

            </p>

        </div>



        <div
            class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-500/10 border border-orange-500/20">

            <x-lucide-calendar-clock
                class="h-5 w-5 text-orange-500" />

        </div>


    </div>






    {{-- Booking Info --}}
    <div class="mt-6 rounded-xl border border-zinc-800 bg-zinc-950 p-5">


        <div class="flex items-center justify-between">


            {{-- Customer --}}
            <div class="flex items-center gap-4">


                <div
                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-500/10 text-orange-500 font-black">


                    م


                </div>



                <div>

                    <h3 class="font-bold text-white">

                        محمد رضایی

                    </h3>


                    <p class="mt-1 text-sm text-zinc-500">

                        ✂ اصلاح کلاسیک

                    </p>


                </div>


            </div>





            {{-- Time --}}
            <div class="text-left">


                <p class="text-xs text-zinc-500">

                    ساعت

                </p>


                <p class="mt-1 text-xl font-black text-white">

                    14:30

                </p>


            </div>


        </div>





        {{-- Status --}}
        <div class="mt-5 flex items-center justify-between">


            <span
                class="rounded-full bg-orange-500/10 px-3 py-1 text-xs font-bold text-orange-400">


                در انتظار تایید


            </span>





            <span class="text-xs text-zinc-500">

                امروز

            </span>


        </div>





        {{-- Actions --}}
        <div class="mt-5 flex gap-3">


            <button
                class="flex-1 rounded-xl bg-green-500/10 py-3 text-sm font-bold text-green-400 transition hover:bg-green-500/20">


                تایید


            </button>





            <button
                class="flex-1 rounded-xl bg-red-500/10 py-3 text-sm font-bold text-red-400 transition hover:bg-red-500/20">


                رد


            </button>


        </div>



    </div>


</div>
