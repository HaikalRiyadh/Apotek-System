<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Penjualan Hari Ini</div>
                    <div class="text-2xl font-bold text-green-600">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Penjualan Bulan Ini</div>
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($salesMonth, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Stok Rendah</div>
                    <div class="text-2xl font-bold text-red-600">{{ $lowStock->count() }} obat</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm text-gray-500">Mendekati Expired</div>
                    <div class="text-2xl font-bold text-orange-600">{{ $expiring->count() }} batch</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Sales Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Penjualan 7 Hari Terakhir</h3>
                    <canvas id="salesChart" height="200"></canvas>
                </div>

                <!-- Top Medicines -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Top 5 Obat Terlaris</h3>
                    <canvas id="topMedicinesChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @if($lowStock->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-red-600">⚠️ Peringatan Stok Rendah</h3>
                    <table class="min-w-full text-sm">
                        <thead><tr class="border-b"><th class="text-left py-2">Obat</th><th class="text-right py-2">Stok</th><th class="text-right py-2">Minimum</th></tr></thead>
                        <tbody>
                            @foreach($lowStock->take(10) as $med)
                            <tr class="border-b"><td class="py-2">{{ $med->name }}</td><td class="text-right py-2 text-red-600 font-semibold">{{ $med->stock_total }}</td><td class="text-right py-2">{{ $med->minimum_stock }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                @if($expiring->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-orange-600">⏰ Obat Mendekati Expired (30 hari)</h3>
                    <table class="min-w-full text-sm">
                        <thead><tr class="border-b"><th class="text-left py-2">Obat</th><th class="text-left py-2">Batch</th><th class="text-right py-2">Sisa</th><th class="text-right py-2">Expired</th></tr></thead>
                        <tbody>
                            @foreach($expiring->take(10) as $batch)
                            <tr class="border-b"><td class="py-2">{{ $batch->medicine->name }}</td><td class="py-2">{{ $batch->batch_number }}</td><td class="text-right py-2">{{ $batch->remaining_quantity }}</td><td class="text-right py-2 text-orange-600">{{ $batch->expired_date->format('d/m/Y') }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = @json($salesChart);
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: salesData.map(d => d.date),
                datasets: [{
                    label: 'Penjualan (Rp)',
                    data: salesData.map(d => d.total),
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } } }
        });

        const topData = @json($topMedicines);
        new Chart(document.getElementById('topMedicinesChart'), {
            type: 'bar',
            data: {
                labels: topData.map(d => d.medicine ? d.medicine.name : 'N/A'),
                datasets: [{
                    label: 'Qty Terjual',
                    data: topData.map(d => parseInt(d.total_qty)),
                    backgroundColor: ['rgba(79,70,229,0.8)','rgba(16,185,129,0.8)','rgba(245,158,11,0.8)','rgba(239,68,68,0.8)','rgba(139,92,246,0.8)'],
                }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    </script>
    @endpush
</x-app-layout>
