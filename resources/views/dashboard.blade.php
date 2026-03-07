<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <p class="text-sm text-gray-500 mt-0.5">Selamat datang kembali, {{ Auth::user()->name }}!</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Penjualan Hari Ini</div>
                        <div class="text-xl font-bold text-green-600 mt-0.5">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Penjualan Bulan Ini</div>
                        <div class="text-xl font-bold text-blue-600 mt-0.5">Rp {{ number_format($salesMonth, 0, ',', '.') }}</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Stok Rendah</div>
                        <div class="text-xl font-bold text-red-600 mt-0.5">{{ $lowStock->count() }} obat</div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 font-medium uppercase tracking-wide">Mendekati Expired</div>
                        <div class="text-xl font-bold text-orange-600 mt-0.5">{{ $expiring->count() }} batch</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
                <!-- Sales Chart -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">📈 Penjualan 7 Hari Terakhir</h3>
                    <canvas id="salesChart" height="200"></canvas>
                </div>

                <!-- Top Medicines -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">🏆 Top 5 Obat Terlaris</h3>
                    <canvas id="topMedicinesChart" height="200"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @if($lowStock->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-6">
                    <h3 class="text-base font-semibold mb-4 text-red-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        Peringatan Stok Rendah
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left py-2 font-semibold text-gray-600">Obat</th>
                                    <th class="text-right py-2 font-semibold text-gray-600">Stok</th>
                                    <th class="text-right py-2 font-semibold text-gray-600">Minimum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStock->take(10) as $med)
                                <tr class="border-b border-gray-50 hover:bg-red-50 transition-colors">
                                    <td class="py-2.5 text-gray-700">{{ $med->name }}</td>
                                    <td class="text-right py-2.5 text-red-600 font-bold">{{ $med->stock_total }}</td>
                                    <td class="text-right py-2.5 text-gray-500">{{ $med->minimum_stock }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if($expiring->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-6">
                    <h3 class="text-base font-semibold mb-4 text-orange-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        Obat Mendekati Expired (30 hari)
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left py-2 font-semibold text-gray-600">Obat</th>
                                    <th class="text-left py-2 font-semibold text-gray-600">Batch</th>
                                    <th class="text-right py-2 font-semibold text-gray-600">Sisa</th>
                                    <th class="text-right py-2 font-semibold text-gray-600">Expired</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiring->take(10) as $batch)
                                <tr class="border-b border-gray-50 hover:bg-orange-50 transition-colors">
                                    <td class="py-2.5 text-gray-700">{{ $batch->medicine->name }}</td>
                                    <td class="py-2.5 text-gray-500 font-mono text-xs">{{ $batch->batch_number }}</td>
                                    <td class="text-right py-2.5 text-gray-700 font-semibold">{{ $batch->remaining_quantity }}</td>
                                    <td class="text-right py-2.5 text-orange-600 font-semibold">{{ $batch->expired_date->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    backgroundColor: 'rgba(79, 70, 229, 0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(79, 70, 229)',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') }
                    },
                    x: { grid: { display: false } }
                }
            }
        });

        const topData = @json($topMedicines);
        new Chart(document.getElementById('topMedicinesChart'), {
            type: 'bar',
            data: {
                labels: topData.map(d => d.medicine ? d.medicine.name : 'N/A'),
                datasets: [{
                    label: 'Qty Terjual',
                    data: topData.map(d => parseInt(d.total_qty)),
                    backgroundColor: [
                        'rgba(79,70,229,0.85)',
                        'rgba(16,185,129,0.85)',
                        'rgba(245,158,11,0.85)',
                        'rgba(239,68,68,0.85)',
                        'rgba(139,92,246,0.85)'
                    ],
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
