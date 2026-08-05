@props([
'booking'
])

<div class="space-y-3">



    @if($booking->status === 'pending')


        <form method="POST"
              action="{{ route('bookings.approve',$booking) }}">

            @csrf
            @method('PATCH')


            <button
                class="flex w-full items-center justify-center rounded-xl bg-green-500 px-4 py-3 text-sm font-black text-black hover:bg-green-400">

                تایید رزرو

            </button>


        </form>





        <form method="POST"
              action="{{ route('bookings.reject',$booking) }}">

            @csrf
            @method('PATCH')


            <button
                class="flex w-full items-center justify-center rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm font-black text-red-400 hover:bg-red-500 hover:text-white">

                رد رزرو

            </button>


        </form>


    @endif





    @if($booking->status === 'approved')


        <form method="POST"
              action="{{ route('bookings.complete',$booking) }}">

            @csrf
            @method('PATCH')


            <button
                class="flex w-full items-center justify-center rounded-xl bg-orange-500 px-4 py-3 text-sm font-black text-black">

                تکمیل خدمت

            </button>


        </form>


    @endif



</div>
