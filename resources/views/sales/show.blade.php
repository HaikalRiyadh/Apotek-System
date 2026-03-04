<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Penjualan - {{ $sale->invoice_number }}
            </h2>
            <a href="{{ route('sales.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Sale Info & Financial Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Info Transaksi --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Transaksi</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">No Invoice</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $sale->invoice_number }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Tanggal</dt>
                                <dd class="text-sm text-gray-900">{{ $sale->created_at->format('d/m/Y H:i:s') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Kasir</dt>
                                <dd class="text-sm text-gray-900">{{ $sale->user->name ?? '-' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Metode Pembayaran</dt>
                                <dd class="text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($sale->payment_method === 'cash') bg-green-100 text-green-800
                                        @elseif($sale->payment_method === 'debit') bg-blue-100 text-blue-800
                                        @else bg-purple-100 text-purple-800
                                        @endif">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </dd>
                            </div>
                            @if($sale->notes)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Catatan</dt>
                                    <dd class="text-sm text-gray-900">{{ $sale->notes }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Ringkasan Keuangan --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Ringkasan Keuangan</h3>
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Subtotal</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Diskon</dt>
                                <dd class="text-sm text-red-600">- Rp {{ number_format($sale->discount, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Pajak</dt>
                                <dd class="text-sm text-gray-900">+ Rp {{ number_format($sale->tax, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <dt class="text-base font-bold text-gray-800">Grand Total</dt>
                                <dd class="text-base font-bold text-blue-600">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Dibayar</dt>
                                <dd class="text-sm font-medium text-gray-900">Rp {{ number_format($sale->amount_paid, 0, ',', '.') }}</dd>
                            </div>
                            <div class="flex justify-between border-t pt-3">
                                <dt class="text-sm font-semibold text-gray-700">Kembalian</dt>
                                <dd class="text-sm font-semibold text-green-600">Rp {{ number_format($sale->change, 0, ',', '.') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Detail Items --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Detail Barang</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Obat</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Jual</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga Beli (Avg)</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Laba</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php $totalProfit = 0; @endphp
                                @foreach($sale->details as $index => $detail)
                                    @php
                                        $subtotalItem = $detail->selling_price * $detail->quantity;
                                        $costItem = ($detail->purchase_price ?? 0) * $detail->quantity;
                                        $profit = $subtotalItem - $costItem;
                                        $totalProfit += $profit;
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $detail->medicine->name ?? '-' }}</div>
                                            <div class="text-xs text-gray-500">{{ $detail->medicine->code ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">
                                            Rp {{ number_format($detail->selling_price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">
                                            Rp {{ number_format($detail->purchase_price ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                            {{ $detail->quantity }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                            Rp {{ number_format($subtotalItem, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            Rp {{ number_format($profit, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-right text-sm font-bold text-gray-800 uppercase">
                                        Total Laba Kotor
                                    </td>
                                    <td class="px-6 py-4 text-right text-base font-bold {{ $totalProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($totalProfit, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
