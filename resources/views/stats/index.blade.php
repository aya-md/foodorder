<x-layouts.console title="Stats">
    <div class="page-head">
        <div>
            <div class="eyebrow">Vendor Console</div>
            <h1>Stats</h1>
        </div>
    </div>

    <div class="dash-grid" style="grid-template-columns:repeat(2, 1fr);">
        <div class="dash-card" style="cursor:default;">
            <span class="tag">№ 01</span>
            <p class="mono" style="font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--paper-dim);margin:0 0 8px;">Orders Today</p>
            <p class="mono" style="font-size:28px;font-weight:800;margin:0;">{{ $ordersToday }}</p>
        </div>

        <div class="dash-card" style="cursor:default;">
            <span class="tag">№ 02</span>
            <p class="mono" style="font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--paper-dim);margin:0 0 8px;">Revenue Today</p>
            <p class="mono" style="font-size:28px;font-weight:800;color:var(--amber);margin:0;">{{ number_format($revenueToday, 2) }} {{ config('app.currency') }}</p>
        </div>

        <div class="dash-card" style="cursor:default;">
            <span class="tag">№ 03</span>
            <p class="mono" style="font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--paper-dim);margin:0 0 14px;">Top Items Today</p>
            @forelse ($topItems as $item)
                <div style="display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px dashed var(--line);font-size:13.5px;">
                    <span>{{ $item->name }}</span>
                    <span class="mono" style="color:var(--amber);">{{ $item->total_quantity }} sold</span>
                </div>
            @empty
                <p class="mono" style="color:var(--paper-dim);font-size:12.5px;">No sales yet today.</p>
            @endforelse
        </div>

        <div class="dash-card" style="cursor:default;">
            <span class="tag">№ 04</span>
            <p class="mono" style="font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--paper-dim);margin:0 0 14px;">Revenue — Last 7 Days</p>
            <canvas id="revenueChart"></canvas>
        </div>

        <div class="dash-card" style="cursor:default;grid-column:span 2;">
            <span class="tag">№ 05</span>
            <p class="mono" style="font-size:11px;letter-spacing:.08em;text-transform:uppercase;color:var(--paper-dim);margin:0 0 14px;">Top Items — Quantity Sold</p>
            <canvas id="topItemsChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const gridColor = 'rgba(53, 48, 42, 0.6)';
            const textColor = '#B9AF9C';

            new Chart(document.getElementById('revenueChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Revenue ({{ config('app.currency') }})',
                        data: {!! json_encode($revenueData) !!},
                        borderColor: '#E8A33D',
                        backgroundColor: 'rgba(232, 163, 61, 0.15)',
                        fill: true,
                        tension: 0.3,
                    }]
                },
                options: {
                    scales: {
                        x: { ticks: { color: textColor, font: { family: 'JetBrains Mono' } }, grid: { color: gridColor } },
                        y: { ticks: { color: textColor, font: { family: 'JetBrains Mono' } }, grid: { color: gridColor } }
                    },
                    plugins: {
                        legend: { labels: { color: textColor, font: { family: 'JetBrains Mono' } } }
                    }
                }
            });

            new Chart(document.getElementById('topItemsChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($topItems->pluck('name')) !!},
                    datasets: [{
                        label: 'Quantity Sold',
                        data: {!! json_encode($topItems->pluck('total_quantity')) !!},
                        backgroundColor: '#E8A33D',
                    }]
                },
                options: {
                    scales: {
                        x: { ticks: { color: textColor, font: { family: 'JetBrains Mono' } }, grid: { color: gridColor } },
                        y: { ticks: { color: textColor, stepSize: 1, font: { family: 'JetBrains Mono' } }, grid: { color: gridColor } }
                    },
                    plugins: {
                        legend: { labels: { color: textColor, font: { family: 'JetBrains Mono' } } }
                    }
                }
            });
        });
    </script>
</x-layouts.console>
