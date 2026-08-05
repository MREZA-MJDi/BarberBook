@props([
'workingHour' => null,
'days',
'action',
'method' => 'POST'
])


<form method="POST"
      action="{{ $action }}"
      class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    @csrf


    @if($method !== 'POST')

        @method($method)

    @endif







    {{-- Day --}}
    <div class="mb-5">


        <label class="mb-2 block text-sm font-bold text-zinc-300">

            روز هفته

        </label>



        <select
            name="day_of_week"
            class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


            @foreach($days as $key=>$day)


                <option value="{{ $key }}"

                    {{ old(
                        'day_of_week',
                        $workingHour?->day_of_week
                    ) == $key ? 'selected' : '' }}>


                    {{ $day }}


                </option>


            @endforeach


        </select>


    </div>








    {{-- Times --}}
    <div class="grid gap-5 md:grid-cols-2">


        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                شروع کار

            </label>


            <input
                type="time"
                name="start_time"
                value="{{ old('start_time',$workingHour?->start_time) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>






        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                پایان کار

            </label>


            <input
                type="time"
                name="end_time"
                value="{{ old('end_time',$workingHour?->end_time) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>


    </div>









    {{-- Break --}}
    <div class="mt-5 grid gap-5 md:grid-cols-2">


        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                شروع استراحت

            </label>


            <input
                type="time"
                name="break_start"
                value="{{ old('break_start',$workingHour?->break_start) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>





        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                پایان استراحت

            </label>


            <input
                type="time"
                name="break_end"
                value="{{ old('break_end',$workingHour?->break_end) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>


    </div>









    {{-- Closed --}}
    <div class="mt-6 flex items-center gap-3">


        <input
            type="checkbox"
            name="is_closed"
            value="1"

            {{ old(
                'is_closed',
                $workingHour?->is_closed
            ) ? 'checked' : '' }}

            class="h-5 w-5 rounded border-zinc-700 bg-zinc-950 text-orange-500">


        <span class="text-sm text-zinc-300">

            این روز تعطیل است

        </span>


    </div>








    <button
        class="mt-8 rounded-xl bg-orange-500 px-6 py-3 font-black text-black hover:bg-orange-400">


        ذخیره


    </button>



</form>
