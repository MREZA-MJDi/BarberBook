@props([
'revenue' => [
'labels' => [],
'data' => [],
'total' => 0,
]
])


<div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-6">


    {{-- Header --}}
    <div class="flex items-center justify-between">


        <div>

            <h3 class="text-lg font-black text-white">
                درآمد این ماه
            </h3>


            <p class="mt-1 text-sm text-zinc-500">
                گزارش درآمد بر اساس رزروهای تایید شده
            </p>

        </div>



        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl
            bg-orange-500/10 border border-orange-500/20">

            <x-lucide-wallet
                class="h-6 w-6 text-orange-500" />

        </div>


    </div>



    {{-- Total --}}
    <div class="mt-8">


        <p class="text-sm text-zinc-400">
            مجموع درآمد
        </p>


        <h2 class="mt-2 text-3xl font-black text-white">

            {{ number_format($revenue['total']) }}
            <span class="text-base text-zinc-500">
                تومان
            </span>

        </h2>


    </div>




    {{-- Chart --}}
    <div class="mt-8 h-72">


        <canvas id="revenueChart"></canvas>


    </div>



</div>





@push('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {


            const ctx = document
                .getElementById('revenueChart');


            if(!ctx) return;



            new Chart(ctx, {


                type: 'line',


                data: {


                    labels: @json($revenue['labels']),


                    datasets: [{

                        label: 'درآمد',


                        data: @json($revenue['data']),


                        borderWidth: 3,


                        tension: 0.4,


                        fill: true,


                    }]

                },



                options: {


                    responsive: true,


                    maintainAspectRatio: false,


                    plugins: {


                        legend: {

                            display: false

                        }

                    },


                    scales: {


                        y: {


                            ticks: {


                                callback: function(value){

                                    return value.toLocaleString() + ' تومان';

                                }


                            }

                        }


                    }


                }


            });


        });


    </script>

@endpush
