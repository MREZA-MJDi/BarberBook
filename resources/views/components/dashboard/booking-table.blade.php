
<div class="space-y-4">

    @forelse($bookings as $booking)

        <div
            class="flex items-center justify-between
            rounded-xl
            border border-zinc-800
            bg-zinc-950
            p-4
            transition
            hover:border-orange-500/40">


            {{-- Customer --}}
            <div class="flex items-center gap-4">

                <div
                    class="flex h-11 w-11 items-center justify-center
                    rounded-xl
                    bg-orange-500/10
                    border border-orange-500/20
                    text-orange-500
                    font-black">

                    {{ mb_substr($booking->customer_name,0,1) }}

                </div>


                <div>

                    <h4 class="font-bold text-white">
                        {{ $booking->customer_name }}
                    </h4>


                    <p class="text-sm text-zinc-500">
                        {{ $booking->service?->name ?? 'بدون سرویس' }}
                    </p>

                </div>

            </div>



            {{-- Time --}}
            <div class="hidden md:block text-center">

                <p class="text-sm text-zinc-400">
                    ساعت
                </p>

                <p class="font-bold text-white">
                    {{ $booking->booking_time }}
                </p>

            </div>




            {{-- Status --}}
            <div>

                @if($booking->status === 'approved')

                    <span
                        class="rounded-full
                        bg-green-500/10
                        px-3 py-1
                        text-xs
                        font-bold
                        text-green-400">

                        تایید شده

                    </span>

                @else

                    <span
                        class="rounded-full
                        bg-orange-500/10
                        px-3 py-1
                        text-xs
                        font-bold
                        text-orange-400">

                        در انتظار

                    </span>

                @endif

            </div>


        </div>


    @empty

        <div class="rounded-xl border border-zinc-800 bg-zinc-950 p-6 text-center text-zinc-500">

            رزروی وجود ندارد

        </div>

    @endforelse


</div>
