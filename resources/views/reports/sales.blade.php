<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Laporan Penjualan</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Rekap data penjualan berdasarkan periode</p>
            <button onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>

            {{-- Filter --}}
            <div class="card print:hidden">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.sales') }}" class="flex flex-wrap items-end gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-slate-600 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date"
                                   value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}"
                                   class="bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-slate-600 mb-1">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date"
                                   value="{{ request('end_date', now()->toDateString()) }}"
                                   class="bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div>
                            <button type="submit" class="btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Summary --}}
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Total Penjualan</p>
                        <p class="text-3xl font-bold mt-1">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th class="text-right">Grand Total</th>
                                <th>Kasir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sales as $index => $sale)
                                <tr>
                                    <td class="text-slate-400">{{ $index + 1 }}</td>
                                    <td class="font-semibold text-emerald-600">{{ $sale->invoice_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y H:i') }}</td>
                                    <td class="text-right font-semibold">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                                    <td>{{ $sale->user->name ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-slate-400">Tidak ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
</x-app-layout>
