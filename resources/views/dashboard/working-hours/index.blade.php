<x-layouts.dashboard>


    <div class="mb-8 flex items-center justify-between">


        <div>

            <h1 class="text-3xl font-black text-white">
                ساعات کاری
            </h1>


            <p class="mt-2 text-zinc-400">
                مدیریت روزها و زمان فعالیت آرایشگاه
            </p>

        </div>




        <a href="{{ route('working-hours.create') }}"
           class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-black text-black hover:bg-orange-400">

            افزودن ساعت کاری

        </a>


    </div>





    @if($workingHours->count())


        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">


            @foreach($workingHours as $workingHour)


                <x-dashboard.working-hours.card
                    :working-hour="$workingHour"
                />


            @endforeach


        </div>



    @else


        <x-dashboard.working-hours.empty />


    @endif



</x-layouts.dashboard>
