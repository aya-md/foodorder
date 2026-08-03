<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stats') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-sm text-gray-500">Orders Today</h3>
                    <p class="text-3xl font-bold mt-1">{{ $ordersToday }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-sm text-gray-500">Revenue Today</h3>
                    <p class="text-3xl font-bold mt-1">{{ number_format($revenueToday, 2) }} {{ config('app.currency') }}</p>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                      <h3 class="text-sm text-gray-500 mb-3">Top Items Today</h3>
                      @forelse ($topItems as $item)
                          <div class="flex justify-between py-1 text-sm">
                             <span>{{ $item->name }}</span>
                             <span class="font-medium">{{ $item->total_quantity }} sold</span>
                         </div>
                      @empty
                           <p class="text-gray-400 text-sm">No sales yet today.</p>
                      @endforelse
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                       <h3 class="text-sm text-gray-500 mb-3">Revenue — Last 7 Days</h3>
                       <canvas id="revenueChart"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                       <h3 class="text-sm text-gray-500 mb-3">Top Items Today</h3>
                       <canvas id="topItemsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Revenue ({{ config('app.currency') }})',
                        data: {!! json_encode($revenueData) !!},
                        borderColor: 'rgb(79, 70, 229)',
                        tension: 0.3,
                  }]
               }
            });

            new Chart(document.getElementById('topItemsChart'), {
                type: 'bar',
                data: {
                     labels: {!! json_encode($topItems->pluck('name')) !!},
                     datasets: [{
                               label: 'Quantity Sold',
                               data: {!! json_encode($topItems->pluck('total_quantity')) !!},
                               backgroundColor: 'rgb(79, 70, 229)',
                     }]
                },
                options: {
                    scales: {
                        y: {
                           ticks: {
                              stepSize: 1
                           }
                       }
                   }
               }
           });
       });
   </script>
</x-app-layout>
