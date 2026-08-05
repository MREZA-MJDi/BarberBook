<x-layouts.dashboard>


    <div class="mb-8 flex items-center justify-between">


        <div>

            <h1 class="text-3xl font-black text-white">
                خدمات
            </h1>


            <p class="mt-2 text-zinc-400">
                مدیریت خدمات و قیمت‌های آرایشگاه
            </p>

        </div>



        <a href="{{ route('services.create') }}"
           class="rounded-xl bg-orange-500 px-5 py-3 text-sm font-black text-black hover:bg-orange-400">

            افزودن خدمت

        </a>


    </div>





    @if($services->count())


        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">


            @foreach($services as $service)


                <x-dashboard.services.card
                    :service="$service"
                />


            @endforeach


        </div>




        <div class="mt-8">

            {{ $services->links() }}

        </div>



    @else


        <x-dashboard.services.empty />


    @endif



</x-layouts.dashboard>
