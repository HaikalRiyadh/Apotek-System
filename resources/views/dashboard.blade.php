<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <span class="text-sm text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- Penjualan Hari Ini --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-lg">💰</div>
                        <span class="text-sm font-medium text-gray-500">Penjualan Hari Ini</span>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $salesCountToday }} transaksi</div>
                </div>

                {{-- Penjualan Bulan Ini --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-lg">📊</div>
                        <span class="text-sm font-medium text-gray-500">Penjualan Bulan Ini</span>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($salesMonth, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Pembelian: Rp {{ number_format($purchasesMonth, 0, ',', '.') }}</div>
                </div>

                {{-- Laba Kotor --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center text-lg">📈</div>
                        <span class="text-sm font-medium text-gray-500">Laba Kotor Bulan Ini</span>
                    </div>
                    <div class="text-2xl font-bold text-gray-800">Rp {{ number_format($grossProfitMonth, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">{{ $totalMedicines }} obat &middot; {{ $totalSuppliers }} supplier</div>
                </div>

                {{-- Peringatan --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-lg">⚠️</div>
                        <span class="text-sm font-medium text-gray-500">Peringatan</span>
                    </div>
                    <div class="flex items-center gap-4 mt-1">
                        <div>
                            <div class="text-2xl font-bold {{ $lowStock->count() > 0 ? 'text-red-600' : 'text-gray-800' }}">{{ $lowStock->count() }}</div>
                            <div class="text-xs text-gray-400">Stok Rendah</div>
                        </div>
                        <div class="w-px h-8 bg-gray-200"></div>
                        <div>
                            <div class="text-2xl font-bold {{ $expiring->count() > 0 ? 'text-orange-600' : 'text-gray-800' }}">{{ $expiring->count() }}</div>
                            <div class="text-xs text-gray-400">Hampir Expired</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                {{-- Sales & Purchases Chart --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Penjualan & Pembelian 7 Hari Terakhir</h3>
                    <canvas id="salesPurchasesChart" height="140"></canvas>
                </div>

                {{-- Top Medicines --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Top 5 Obat Terlaris</h3>
                    <canvas id="topMedicinesChart" height="200"></canvas>
                </div>
            </div>

            {{-- Alert Tables --}}
            @if($lowStock->count() > 0 || $expiring->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @if($lowStock->count() > 0)
                <div x-data="{ open: true }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
                        <h3 class="text-sm font-semibold text-red-600 flex items-center gap-2">
                            <span>⚠️</span> Stok Rendah
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $lowStock->count() }}</span>
                        </h3>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="overflow-x-auto border-t border-gray-100">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                                        <th class="text-left py-2.5 px-4 font-medium">Obat</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Stok</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Minimum</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($lowStock->take(10) as $med)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-2.5 px-4 text-gray-700">{{ $med->name }}</td>
                                        <td class="text-right py-2.5 px-4 font-semibold {{ $med->stock_total == 0 ? 'text-red-600' : 'text-orange-600' }}">{{ $med->stock_total }}</td>
                                        <td class="text-right py-2.5 px-4 text-gray-500">{{ $med->minimum_stock }}</td>
                                        <td class="text-right py-2.5 px-4">
                                            @if($med->stock_total == 0)
                                                <span class="px-2 py-0.5 text-xs font-medium bg-red-100 text-red-700 rounded-full">Habis</span>
                                            @else
                                                <span class="px-2 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full">Rendah</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($lowStock->count() > 10)
                            <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-50">dan {{ $lowStock->count() - 10 }} obat lainnya...</div>
                        @endif
                    </div>
                </div>
                @endif

                @if($expiring->count() > 0)
                <div x-data="{ open: true }" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
                        <h3 class="text-sm font-semibold text-orange-600 flex items-center gap-2">
                            <span>⏰</span> Mendekati Expired
                            <span class="bg-orange-100 text-orange-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $expiring->count() }}</span>
                        </h3>
                        <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-collapse>
                        <div class="overflow-x-auto border-t border-gray-100">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                                        <th class="text-left py-2.5 px-4 font-medium">Obat</th>
                                        <th class="text-left py-2.5 px-4 font-medium">Batch</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Sisa</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Expired</th>
                                        <th class="text-right py-2.5 px-4 font-medium">Sisa Hari</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($expiring->take(10) as $batch)
                                    <tr class="hover:bg-gray-50/50">
                                        <td class="py-2.5 px-4 text-gray-700">{{ $batch->medicine->name }}</td>
                                        <td class="py-2.5 px-4 text-gray-500 text-xs font-mono">{{ $batch->batch_number }}</td>
                                        <td class="text-right py-2.5 px-4 text-gray-700">{{ $batch->remaining_quantity }}</td>
                                        <td class="text-right py-2.5 px-4 text-gray-500">{{ $batch->expired_date->format('d/m/Y') }}</td>
                                        <td class="text-right py-2.5 px-4">
                                            @php $daysLeft = (int) now()->diffInDays($batch->expired_date, false); @endphp
                                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $daysLeft <= 7 ? 'bg-red-100 text-red-700' : 'bg-orange-100 text-orange-700' }}">
                                                {{ $daysLeft }} hari
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($expiring->count() > 10)
                            <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-50">dan {{ $expiring->count() - 10 }} batch lainnya...</div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Figtree', sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#6b7280';

        const palette = ['rgba(79,70,229,0.8)','rgba(16,185,129,0.8)','rgba(245,158,11,0.8)','rgba(239,68,68,0.8)','rgba(139,92,246,0.8)','rgba(6,182,212,0.8)','rgba(244,63,94,0.8)','rgba(34,197,94,0.8)'];

        // Combined Sales & Purchases Chart
        const salesData = @json($salesChart);
        const purchasesData = @json($purchasesChart);
        new Chart(document.getElementById('salesPurchasesChart'), {
            type: 'line',
            data: {
                labels: salesData.map(d => d.date),
                datasets: [
                    {
                        label: 'Penjualan',
                        data: salesData.map(d => d.total),
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        borderWidth: 2,
                    },
                    {
                        label: 'Pembelian',
                        data: purchasesData.map(d => d.total),
                        borderColor: 'rgb(139, 92, 246)',
                        backgroundColor: 'rgba(139, 92, 246, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 3,
                        borderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { boxWidth: 10, usePointStyle: true, pointStyle: 'circle', padding: 16 } } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'rb' } }, x: { grid: { display: false } } }
            }
        });

        // Top Medicines (Horizontal Bar)
        const topData = @json($topMedicines);
        new Chart(document.getElementById('topMedicinesChart'), {
            type: 'bar',
            data: {
                labels: topData.map(d => d.medicine ? d.medicine.name : 'N/A'),
                datasets: [{
                    data: topData.map(d => parseInt(d.total_qty)),
                    backgroundColor: palette,
                    borderRadius: 6,
                    maxBarThickness: 28,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } }, y: { grid: { display: false } } }
            }
        });


    </script>
    @endpush
</x-app-layout>
