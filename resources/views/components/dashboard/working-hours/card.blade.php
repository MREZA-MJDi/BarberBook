@props([
'workingHour'
])


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- Header --}}
    <div class="flex items-center justify-between">


        <h3 class="text-lg font-black text-white">

            {{ \App\Support\Days::name($workingHour->day_of_week) }}

        </h3>



        <span
            class="rounded-full px-3 py-1 text-xs font-bold
            {{ $workingHour->is_closed
                ? 'bg-red-500/10 text-red-400'
                : 'bg-green-500/10 text-green-400' }}">


            {{ $workingHour->is_closed ? 'تعطیل' : 'فعال' }}


        </span>


    </div>





    @if(!$workingHour->is_closed)


        <div class="mt-6 space-y-4">


            {{-- Working Time --}}
            <div class="flex items-center justify-between">


                <span class="text-sm text-zinc-500">

                    ساعت کاری

                </span>



                <span class="font-bold text-white">

                    {{ $workingHour->start_time }}

                    -

                    {{ $workingHour->end_time }}

                </span>


            </div>






            {{-- Break --}}
            @if($workingHour->break_start && $workingHour->break_end)


                <div class="flex items-center justify-between">


                    <span class="text-sm text-zinc-500">

                        زمان استراحت

                    </span>



                    <span class="font-bold text-orange-400">

                        {{ $workingHour->break_start }}

                        -

                        {{ $workingHour->break_end }}

                    </span>


                </div>


            @endif



        </div>


    @endif







    {{-- Actions --}}
    <div class="mt-6 flex gap-3">



        <a href="{{ route('working-hours.edit',$workingHour) }}"
           class="flex-1 rounded-xl border border-zinc-700 px-4 py-2 text-center text-sm font-bold text-white hover:bg-zinc-800">


            ویرایش


        </a>





        <form method="POST"
              action="{{ route('working-hours.destroy',$workingHour) }}">


            @csrf

            @method('DELETE')


            <button
                class="rounded-xl bg-red-500/10 px-4 py-2 text-sm font-bold text-red-400 hover:bg-red-500 hover:text-white">


                حذف


            </button>


        </form>


    </div>



</div>
