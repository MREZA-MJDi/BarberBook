@props([
'service' => null,
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




    {{-- Name --}}
    <div class="mb-5">


        <label class="mb-2 block text-sm font-bold text-zinc-300">

            نام خدمت

        </label>



        <input
            type="text"
            name="name"
            value="{{ old('name',$service?->name) }}"
            class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white focus:border-orange-500 focus:outline-none">


        @error('name')

        <p class="mt-2 text-sm text-red-400">
            {{ $message }}
        </p>

        @enderror


    </div>







    {{-- Description --}}
    <div class="mb-5">


        <label class="mb-2 block text-sm font-bold text-zinc-300">

            توضیحات

        </label>



        <textarea
            name="description"
            rows="4"
            class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">{{ old('description',$service?->description) }}</textarea>


    </div>







    {{-- Price + Duration --}}
    <div class="grid gap-5 md:grid-cols-2">



        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                قیمت

            </label>



            <input
                type="number"
                name="price"
                value="{{ old('price',$service?->price) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>





        <div>


            <label class="mb-2 block text-sm font-bold text-zinc-300">

                مدت زمان (دقیقه)

            </label>



            <input
                type="number"
                name="duration"
                value="{{ old('duration',$service?->duration) }}"
                class="w-full rounded-xl border border-zinc-700 bg-zinc-950 px-4 py-3 text-white">


        </div>


    </div>








    {{-- Active --}}
    <div class="mt-5 flex items-center gap-3">


        <input
            type="checkbox"
            name="is_active"
            value="1"
            {{ old('is_active',$service?->is_active ?? true) ? 'checked' : '' }}
            class="h-5 w-5 rounded border-zinc-700 bg-zinc-950 text-orange-500">



        <span class="text-sm text-zinc-300">

            فعال باشد

        </span>


    </div>







    <button
        class="mt-8 rounded-xl bg-orange-500 px-6 py-3 font-black text-black hover:bg-orange-400">


        ذخیره


    </button>



</form>
