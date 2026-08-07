@props([
'booking'
])


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6 transition hover:border-orange-500/40">


    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">


        {{-- Customer --}}
        <div class="flex items-center gap-4">


            <div
                class="flex h-12 w-12 items-center justify-center rounded-xl
                bg-orange-500/10 border border-orange-500/20
                text-lg font-black text-orange-500">


                {{ mb_substr($booking->customer_name,0,1) }}


            </div>



            <div>


                <h3 class="font-black text-white">

                    {{ $booking->customer_name }}

                </h3>


                <p class="text-sm text-zinc-500">

                    {{ $booking->service->name ?? '-' }}

                </p>


            </div>


        </div>





        {{-- Date --}}
        <div>


            <p class="text-xs text-zinc-500">
                زمان رزرو
            </p>


            <p class="mt-1 font-bold text-white">

                {{ $booking->booking_date }}

                -

                {{ $booking->booking_time }}

            </p>


        </div>






        {{-- Status --}}
        <x-dashboard.bookings.status
            :status="$booking->status"
        />






        {{-- Button --}}
        <a href="{{ route('bookings.show',$booking) }}"
           class="rounded-xl border border-zinc-700 px-4 py-2 text-sm font-bold text-white transition hover:border-orange-500 hover:text-orange-500">

            مشاهده

        </a>



    </div>


</div>
