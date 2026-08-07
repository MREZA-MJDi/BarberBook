<x-layouts.dashboard>


    <div class="mb-8">


        <h1 class="text-3xl font-black text-white">

            ویرایش ساعت کاری

        </h1>


    </div>




    <x-dashboard.working-hours.form

        :days="$days"

        :working-hour="$workingHour"

        :action="route('working-hours.update',$workingHour)"

        method="PUT"

    />


</x-layouts.dashboard>
