<x-layouts.dashboard>


    <div class="mb-8">


        <h1 class="text-3xl font-black text-white">

            افزودن ساعت کاری

        </h1>


    </div>




    <x-dashboard.working-hours.form
        :days="$days"
        :action="route('working-hours.store')"
    />


</x-layouts.dashboard>
