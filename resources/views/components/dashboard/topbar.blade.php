<header
    class="sticky top-0 z-40 border-b border-zinc-800 bg-zinc-950/80 backdrop-blur">


    <div class="flex h-20 items-center justify-between px-6 lg:px-8">



        {{-- Right Side --}}
        <div class="flex items-center gap-4">



            {{-- Mobile Menu --}}
            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-800 text-zinc-400 transition hover:text-orange-500 lg:hidden">


                <x-lucide-menu class="h-5 w-5" />


            </button>





            <div>


                <h2 class="text-xl font-black text-white">

                    پنل مدیریت

                </h2>



                <p class="text-sm text-zinc-500">

                    مدیریت آرایشگاه و رزروها

                </p>


            </div>


        </div>





        {{-- Left Side --}}
        <div class="flex items-center gap-4">





            {{-- Notification --}}
            <button
                type="button"
                class="relative flex h-11 w-11 items-center justify-center rounded-xl border border-zinc-800 text-zinc-400 transition hover:border-orange-500/40 hover:text-orange-500">


                <x-lucide-bell class="h-5 w-5" />



                <span
                    class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-orange-500 text-xs font-black text-black">

                    3

                </span>


            </button>







            {{-- Profile --}}
            <div class="hidden items-center gap-3 sm:flex">



                <div class="text-left">



                    <p class="text-sm font-bold text-white">

                        {{ auth()->user()->full_name ?? 'آرایشگر' }}

                    </p>




                    <p class="text-xs text-zinc-500">

                        مدیریت سالن

                    </p>



                </div>






                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500 font-black text-black">


                    {{ mb_substr(auth()->user()->full_name ?? 'B',0,1) }}


                </div>



            </div>



        </div>



    </div>



</header>
