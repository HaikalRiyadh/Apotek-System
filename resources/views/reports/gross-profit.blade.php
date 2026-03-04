<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Laba Kotor
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <div class="bg-white shadow sm:rounded-lg p-6 mb-6 print:hidden">
                <form method="GET" action="{{ route('reports.gross-profit') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date"
                               value="{{ request('start_date', now()->startOfMonth()->toDateString()) }}"
                               class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                        <input type="date" name="end_date" id="end_date"
                               value="{{ request('end_date', now()->toDateString()) }}"
                               class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                            Filter
                        </button>
                    </div>
                    <div class="ml-auto">
                        <button type="button" onclick="window.print()"
                                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                            🖨️ Cetak
                        </button>
                    </div>
                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                {{-- Total Pendapatan --}}
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600">Rp {{ number_format($report['total_revenue'], 0, ',', '.') }}</p>
                </div>
                {{-- Total HPP --}}
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total HPP</h3>
                    <p class="mt-2 text-2xl font-bold text-red-600">Rp {{ number_format($report['total_cost'], 0, ',', '.') }}</p>
                </div>
                {{-- Laba Kotor --}}
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Laba Kotor</h3>
                    <p class="mt-2 text-2xl font-bold text-green-600">Rp {{ number_format($report['gross_profit'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Beli Avg</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Laba</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $grandProfit = 0; @endphp
                        @forelse($report['sales'] as $sale)
                            @foreach($sale->details as $detailIndex => $detail)
                                @php
                                    $laba = ($detail->selling_price - $detail->purchase_price_avg) * $detail->quantity;
                                    $grandProfit += $laba;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    @if($detailIndex === 0)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900" rowspan="{{ $sale->details->count() }}">
                                            {{ $sale->invoice_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" rowspan="{{ $sale->details->count() }}">
                                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $detail->medicine->name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">{{ $detail->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($detail->selling_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">Rp {{ number_format($detail->purchase_price_avg, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-right {{ $laba >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($laba, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(isset($report['sales']) && count($report['sales']) > 0)
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-right text-sm font-bold text-gray-700 uppercase">Total Laba Kotor</td>
                                <td class="px-6 py-4 text-right text-sm font-bold {{ $grandProfit >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                    Rp {{ number_format($grandProfit, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
