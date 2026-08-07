<x-layouts.dashboard>


    <div class="mb-8">

        <h1 class="text-3xl font-black text-white">
            ویرایش خدمت
        </h1>

    </div>



    <x-dashboard.services.form
        :service="$service"
        :action="route('services.update',$service)"
        method="PUT"
    />


</x-layouts.dashboard>
