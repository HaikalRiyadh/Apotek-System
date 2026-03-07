<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Dashboard</h2>
    </x-slot>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Penjualan Hari Ini --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg shadow-emerald-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs text-slate-400 font-medium">{{ $salesCountToday }} transaksi</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($salesToday, 0, ',', '.') }}</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">Penjualan Hari Ini</div>
            </div>

            {{-- Penjualan Bulan Ini --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <span class="badge badge-info">Bulan Ini</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($salesMonth, 0, ',', '.') }}</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">Pembelian: Rp {{ number_format($purchasesMonth, 0, ',', '.') }}</div>
            </div>

            {{-- Laba Kotor --}}
            <div class="stat-card">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg shadow-violet-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <span class="badge badge-success">Profit</span>
                </div>
                <div class="text-2xl font-extrabold text-slate-800">Rp {{ number_format($grossProfitMonth, 0, ',', '.') }}</div>
                <div class="text-xs text-slate-500 mt-1 font-medium">{{ $totalMedicines }} obat &middot; {{ $totalSuppliers }} supplier</div>
            </div>

            {{-- Peringatan --}}
            <div class="stat-card {{ ($lowStock->count() > 0 || $expiring->count() > 0) ? 'ring-1 ring-red-100' : '' }}">
                <div class="flex items-center justify-between mb-4">
                    <div class="stat-icon bg-gradient-to-br from-red-500 to-rose-600 shadow-lg shadow-red-500/20">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    @if($lowStock->count() > 0 || $expiring->count() > 0)
                        <span class="badge badge-danger">Perhatian</span>
                    @endif
                </div>
                <div class="flex items-center gap-5">
                    <div>
                        <div class="text-2xl font-extrabold {{ $lowStock->count() > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ $lowStock->count() }}</div>
                        <div class="text-xs text-slate-500 font-medium">Stok Rendah</div>
                    </div>
                    <div class="w-px h-10 bg-slate-200"></div>
                    <div>
                        <div class="text-2xl font-extrabold {{ $expiring->count() > 0 ? 'text-amber-600' : 'text-slate-800' }}">{{ $expiring->count() }}</div>
                        <div class="text-xs text-slate-500 font-medium">Hampir Expired</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Sales & Purchases Chart --}}
            <div class="lg:col-span-2 card">
                <div class="card-header">
                    <h3 class="text-sm font-bold text-slate-700">Penjualan & Pembelian 7 Hari Terakhir</h3>
                    <span class="badge badge-info">Mingguan</span>
                </div>
                <div class="card-body">
                    <canvas id="salesPurchasesChart" height="140"></canvas>
                </div>
            </div>

            {{-- Top Medicines --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="text-sm font-bold text-slate-700">Top 5 Obat Terlaris</h3>
                    <span class="badge badge-success">Terbaik</span>
                </div>
                <div class="card-body">
                    <canvas id="topMedicinesChart" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Alert Tables --}}
        @if($lowStock->count() > 0 || $expiring->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            @if($lowStock->count() > 0)
            <div x-data="{ open: true }" class="card">
                <button @click="open = !open" class="w-full card-header hover:bg-slate-50/50 transition-colors cursor-pointer">
                    <h3 class="text-sm font-bold text-red-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        Stok Rendah
                        <span class="badge badge-danger">{{ $lowStock->count() }}</span>
                    </h3>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="overflow-x-auto">
                        <table class="pro-table">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th class="text-right">Stok</th>
                                    <th class="text-right">Minimum</th>
                                    <th class="text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStock->take(10) as $med)
                                <tr>
                                    <td class="font-medium text-slate-700">{{ $med->name }}</td>
                                    <td class="text-right font-bold {{ $med->stock_total == 0 ? 'text-red-600' : 'text-amber-600' }}">{{ $med->stock_total }}</td>
                                    <td class="text-right text-slate-400">{{ $med->minimum_stock }}</td>
                                    <td class="text-right">
                                        @if($med->stock_total == 0)
                                            <span class="badge badge-danger">Habis</span>
                                        @else
                                            <span class="badge badge-warning">Rendah</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($lowStock->count() > 10)
                        <div class="px-5 py-3 text-xs text-slate-400 border-t border-slate-100">dan {{ $lowStock->count() - 10 }} obat lainnya...</div>
                    @endif
                </div>
            </div>
            @endif

            @if($expiring->count() > 0)
            <div x-data="{ open: true }" class="card">
                <button @click="open = !open" class="w-full card-header hover:bg-slate-50/50 transition-colors cursor-pointer">
                    <h3 class="text-sm font-bold text-amber-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mendekati Expired
                        <span class="badge badge-warning">{{ $expiring->count() }}</span>
                    </h3>
                    <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="overflow-x-auto">
                        <table class="pro-table">
                            <thead>
                                <tr>
                                    <th>Obat</th>
                                    <th>Batch</th>
                                    <th class="text-right">Sisa</th>
                                    <th class="text-right">Expired</th>
                                    <th class="text-right">Sisa Hari</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expiring->take(10) as $batch)
                                <tr>
                                    <td class="font-medium text-slate-700">{{ $batch->medicine->name }}</td>
                                    <td class="text-slate-400 text-xs font-mono">{{ $batch->batch_number }}</td>
                                    <td class="text-right text-slate-600">{{ $batch->remaining_quantity }}</td>
                                    <td class="text-right text-slate-400">{{ $batch->expired_date->format('d/m/Y') }}</td>
                                    <td class="text-right">
                                        @php $daysLeft = (int) now()->diffInDays($batch->expired_date, false); @endphp
                                        <span class="badge {{ $daysLeft <= 7 ? 'badge-danger' : 'badge-warning' }}">
                                            {{ $daysLeft }} hari
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($expiring->count() > 10)
                        <div class="px-5 py-3 text-xs text-slate-400 border-t border-slate-100">dan {{ $expiring->count() - 10 }} batch lainnya...</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#94a3b8';

        const palette = ['rgba(16,185,129,0.85)','rgba(59,130,246,0.85)','rgba(245,158,11,0.85)','rgba(239,68,68,0.85)','rgba(139,92,246,0.85)','rgba(6,182,212,0.85)','rgba(244,63,94,0.85)','rgba(34,197,94,0.85)'];

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
                        backgroundColor: 'rgba(16, 185, 129, 0.06)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(16, 185, 129)',
                        borderWidth: 2.5,
                    },
                    {
                        label: 'Pembelian',
                        data: purchasesData.map(d => d.total),
                        borderColor: 'rgb(99, 102, 241)',
                        backgroundColor: 'rgba(99, 102, 241, 0.06)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(99, 102, 241)',
                        borderWidth: 2.5,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: { legend: { position: 'top', labels: { boxWidth: 8, usePointStyle: true, pointStyle: 'circle', padding: 20, font: { size: 12, weight: '600' } } } },
                scales: { y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { callback: v => 'Rp ' + (v/1000).toFixed(0) + 'rb', font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
            }
        });

        const topData = @json($topMedicines);
        new Chart(document.getElementById('topMedicinesChart'), {
            type: 'bar',
            data: {
                labels: topData.map(d => d.medicine ? d.medicine.name : 'N/A'),
                datasets: [{
                    data: topData.map(d => parseInt(d.total_qty)),
                    backgroundColor: palette,
                    borderRadius: 8,
                    maxBarThickness: 24,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { font: { size: 11 } } }, y: { grid: { display: false }, ticks: { font: { size: 11, weight: '500' } } } }
            }
        });
    </script>
    @endpush
</x-app-layout>
