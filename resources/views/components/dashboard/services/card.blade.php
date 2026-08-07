@props([
'service'
])


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- Header --}}
    <div class="flex items-start justify-between">


        <div>

            <h3 class="text-lg font-black text-white">

                {{ $service->name }}

            </h3>


            <p class="mt-2 text-sm text-zinc-400">

                {{ $service->description ?? 'بدون توضیحات' }}

            </p>

        </div>



        <span
            class="rounded-full px-3 py-1 text-xs font-bold
            {{ $service->is_active
                ? 'bg-green-500/10 text-green-400'
                : 'bg-red-500/10 text-red-400' }}">


            {{ $service->is_active ? 'فعال' : 'غیرفعال' }}


        </span>


    </div>





    {{-- Info --}}
    <div class="mt-6 space-y-3">


        <div class="flex items-center justify-between text-sm">


            <span class="text-zinc-500">
                قیمت
            </span>


            <span class="font-bold text-white">

                {{ number_format($service->price) }}

                تومان

            </span>


        </div>





        <div class="flex items-center justify-between text-sm">


            <span class="text-zinc-500">
                زمان
            </span>


            <span class="font-bold text-white">

                {{ $service->duration }}

                دقیقه

            </span>


        </div>



    </div>







    {{-- Actions --}}
    <div class="mt-6 flex gap-3">


        <a href="{{ route('services.edit',$service) }}"
           class="flex-1 rounded-xl border border-zinc-700 px-4 py-2 text-center text-sm font-bold text-white hover:bg-zinc-800">


            ویرایش


        </a>





        <form method="POST"
              action="{{ route('services.destroy',$service) }}">


            @csrf

            @method('DELETE')


            <button
                class="rounded-xl bg-red-500/10 px-4 py-2 text-sm font-bold text-red-400 hover:bg-red-500 hover:text-white">


                حذف


            </button>


        </form>


    </div>



</div>
