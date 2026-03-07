<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Laporan Laba Kotor</h2>
                <p class="text-sm text-slate-500 mt-1">Analisis keuntungan dari setiap transaksi penjualan</p>
            </div>
            <button type="button" onclick="window.print()" class="btn-secondary print:hidden">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak
            </button>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter --}}
            <div class="card print:hidden">
                <div class="card-body">
                    <form method="GET" action="{{ route('reports.gross-profit') }}" class="flex flex-wrap items-end gap-4">
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

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-5 text-white shadow-lg shadow-blue-500/20">
                    <p class="text-blue-100 text-xs font-medium uppercase tracking-wider">Total Pendapatan</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($report['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-rose-500 to-red-600 rounded-2xl p-5 text-white shadow-lg shadow-rose-500/20">
                    <p class="text-rose-100 text-xs font-medium uppercase tracking-wider">Total HPP</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($report['total_cost'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-5 text-white shadow-lg shadow-emerald-500/20">
                    <p class="text-emerald-100 text-xs font-medium uppercase tracking-wider">Laba Kotor</p>
                    <p class="text-2xl font-bold mt-2">Rp {{ number_format($report['gross_profit'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Obat</th>
                                <th class="text-center">Qty</th>
                                <th class="text-right">Harga Jual</th>
                                <th class="text-right">Harga Beli Avg</th>
                                <th class="text-right">Laba</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandProfit = 0; @endphp
                            @forelse($report['sales'] as $sale)
                                @foreach($sale->details as $detailIndex => $detail)
                                    @php
                                        $laba = ($detail->selling_price - $detail->purchase_price_avg) * $detail->quantity;
                                        $grandProfit += $laba;
                                    @endphp
                                    <tr>
                                        @if($detailIndex === 0)
                                            <td class="font-semibold text-emerald-600" rowspan="{{ $sale->details->count() }}">
                                                {{ $sale->invoice_number }}
                                            </td>
                                            <td rowspan="{{ $sale->details->count() }}">
                                                {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                                            </td>
                                        @endif
                                        <td class="font-medium">{{ $detail->medicine->name ?? '-' }}</td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-right">Rp {{ number_format($detail->selling_price, 0, ',', '.') }}</td>
                                        <td class="text-right">Rp {{ number_format($detail->purchase_price_avg, 0, ',', '.') }}</td>
                                        <td class="text-right font-semibold {{ $laba >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                            Rp {{ number_format($laba, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-slate-400">Tidak ada data penjualan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(isset($report['sales']) && count($report['sales']) > 0)
                            <tfoot>
                                <tr class="bg-slate-50">
                                    <td colspan="6" class="text-right font-bold text-slate-700 uppercase text-xs tracking-wider">Total Laba Kotor</td>
                                    <td class="text-right font-bold text-lg {{ $grandProfit >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                        Rp {{ number_format($grandProfit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
