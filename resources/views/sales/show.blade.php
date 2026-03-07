<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('sales.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Detail Penjualan</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-5 animate-fade-in">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Info Transaksi -->
            <div class="card">
                <div class="card-header"><h3 class="font-semibold text-slate-700">Informasi Transaksi</h3></div>
                <div class="card-body">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">No Invoice</dt>
                            <dd class="text-sm font-semibold text-emerald-600">{{ $sale->invoice_number }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Tanggal</dt>
                            <dd class="text-sm text-slate-700">{{ $sale->created_at->format('d/m/Y H:i:s') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Kasir</dt>
                            <dd class="text-sm text-slate-700">{{ $sale->user->name ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Pembayaran</dt>
                            <dd>
                                <span class="badge {{ $sale->payment_method === 'cash' ? 'badge-success' : ($sale->payment_method === 'debit' ? 'badge-info' : 'badge-warning') }}">
                                    {{ ucfirst($sale->payment_method) }}
                                </span>
                            </dd>
                        </div>
                        @if($sale->notes)
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Catatan</dt>
                            <dd class="text-sm text-slate-700">{{ $sale->notes }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Ringkasan Keuangan -->
            <div class="card">
                <div class="card-header"><h3 class="font-semibold text-slate-700">Ringkasan Keuangan</h3></div>
                <div class="card-body">
                    <dl class="space-y-4">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Subtotal</dt>
                            <dd class="text-sm text-slate-700">Rp {{ number_format($sale->subtotal, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Diskon</dt>
                            <dd class="text-sm text-red-500">- Rp {{ number_format($sale->discount, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Pajak</dt>
                            <dd class="text-sm text-slate-700">+ Rp {{ number_format($sale->tax, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-slate-100">
                            <dt class="text-base font-bold text-slate-800">Grand Total</dt>
                            <dd class="text-base font-bold text-emerald-600">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-400">Dibayar</dt>
                            <dd class="text-sm font-medium text-slate-700">Rp {{ number_format($sale->amount_paid, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-slate-100">
                            <dt class="text-sm font-semibold text-slate-600">Kembalian</dt>
                            <dd class="text-sm font-semibold text-emerald-600">Rp {{ number_format($sale->change, 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Detail Items -->
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Detail Barang</h3></div>
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th class="w-12">#</th>
                            <th>Obat</th>
                            <th class="text-right">Harga Jual</th>
                            <th class="text-right">Harga Beli (Avg)</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Subtotal</th>
                            <th class="text-right">Laba</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalProfit = 0; @endphp
                        @foreach($sale->details as $index => $detail)
                            @php
                                $subtotalItem = $detail->selling_price * $detail->quantity;
                                $costItem = ($detail->purchase_price ?? 0) * $detail->quantity;
                                $profit = $subtotalItem - $costItem;
                                $totalProfit += $profit;
                            @endphp
                            <tr>
                                <td class="text-slate-400">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-medium text-slate-700">{{ $detail->medicine->name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $detail->medicine->code ?? '' }}</div>
                                </td>
                                <td class="text-right text-slate-600">Rp {{ number_format($detail->selling_price, 0, ',', '.') }}</td>
                                <td class="text-right text-slate-500">Rp {{ number_format($detail->purchase_price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-right font-semibold text-slate-700">Rp {{ number_format($subtotalItem, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold {{ $profit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">Rp {{ number_format($profit, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50">
                            <td colspan="6" class="text-right font-bold text-slate-600 text-xs uppercase tracking-wider">Total Laba Kotor</td>
                            <td class="text-right text-base font-bold {{ $totalProfit >= 0 ? 'text-emerald-600' : 'text-red-500' }}">Rp {{ number_format($totalProfit, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
