<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('purchases.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Detail Pembelian</h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-5 animate-fade-in">
        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Informasi Pembelian</h3></div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">No Invoice</span>
                        <p class="mt-1 text-sm font-semibold text-emerald-600">{{ $purchase->invoice_number }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Supplier</span>
                        <p class="mt-1 text-sm font-semibold text-slate-700">{{ $purchase->supplier->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Tanggal</span>
                        <p class="mt-1 text-sm text-slate-600">{{ $purchase->purchase_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total</span>
                        <p class="mt-1 text-lg font-bold text-slate-800">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">User</span>
                        <p class="mt-1 text-sm text-slate-600">{{ $purchase->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Catatan</span>
                        <p class="mt-1 text-sm text-slate-600">{{ $purchase->notes ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="font-semibold text-slate-700">Detail Item</h3></div>
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>Obat</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Subtotal</th>
                            <th>No Batch</th>
                            <th>Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchase->details as $detail)
                            <tr>
                                <td class="font-medium text-slate-700">{{ $detail->medicine->name ?? '-' }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-right text-slate-600">Rp {{ number_format($detail->purchase_price, 0, ',', '.') }}</td>
                                <td class="text-right font-semibold text-slate-700">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                <td class="text-slate-500">{{ $detail->batch_number }}</td>
                                <td>
                                    @if($detail->expired_date)
                                        <span class="{{ $detail->expired_date->isPast() ? 'text-red-500 font-semibold' : 'text-slate-500' }}">{{ $detail->expired_date->format('d/m/Y') }}</span>
                                    @else - @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-8 text-sm text-slate-400">Tidak ada detail item</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-slate-50">
                            <td colspan="3" class="text-right font-bold text-slate-600 uppercase text-xs tracking-wider">Total</td>
                            <td class="text-right font-bold text-emerald-600">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
