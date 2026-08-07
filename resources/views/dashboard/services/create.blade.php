<x-layouts.dashboard>


    <div class="mb-8">

        <h1 class="text-3xl font-black text-white">
            افزودن خدمت جدید
        </h1>

    </div>



    <x-dashboard.services.form
        :action="route('services.store')"
    />


</x-layouts.dashboard>
