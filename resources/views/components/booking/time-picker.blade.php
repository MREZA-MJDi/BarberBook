<section class="w-full py-20 bg-zinc-950" dir="rtl">

    <div class="max-w-3xl px-6 mx-auto">


        {{-- Title --}}
        <div class="mb-10 text-center">

            <h2 class="text-3xl font-black text-white md:text-4xl">

                انتخاب ساعت نوبت

            </h2>


            <p class="mt-4 text-zinc-400">

                یکی از زمان‌های آزاد را انتخاب کنید

            </p>

        </div>




        {{-- Selected Date --}}
        <div
            class="flex items-center justify-between p-6 mb-10 border rounded-3xl bg-zinc-900 border-zinc-800">


            <div>

                <p class="text-sm text-zinc-500">

                    تاریخ انتخاب شده

                </p>


                <h3 class="mt-2 font-bold text-white">

                    شنبه ۲۵ مرداد ۱۴۰۵

                </h3>

            </div>



            <span
                class="px-4 py-2 text-sm font-bold text-black bg-white rounded-xl">

                آماده رزرو

            </span>


        </div>





        {{-- Time Slots --}}
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">


            @foreach([
                '09:00',
                '09:30',
                '10:00',
                '10:30',
                '11:00',
                '11:30',
                '14:00',
                '14:30',
                '15:00',
                '16:00',
                '17:30',
                '18:00'
            ] as $time)


                <button
                    class="
                    px-5
                    py-4
                    text-sm
                    font-bold
                    transition
                    rounded-2xl
                    border
                    border-zinc-800
                    bg-zinc-900
                    text-zinc-300

                    hover:bg-white
                    hover:text-black
                    hover:border-white
                    ">

                    {{ $time }}

                </button>


            @endforeach


        </div>





        {{-- Continue --}}
        <button
            class="
            w-full
            mt-10
            py-4
            font-black
            text-black
            transition
            bg-white
            rounded-2xl
            hover:bg-zinc-200
            ">

            ادامه ثبت درخواست

        </button>



    </div>


</section>
