<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Pembelian</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Riwayat transaksi pembelian obat</p>
            <a href="{{ route('purchases.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Pembelian
            </a>
        </div>
        <!-- Filter -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('purchases.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Cari Invoice/Supplier</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="No. invoice atau supplier..."
                                   class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                    </div>
                    <div class="w-44">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                    </div>
                    <div class="w-44">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                    </div>
                    <div class="w-36">
                        <label class="block text-xs font-medium text-slate-500 mb-1">Status</label>
                        <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            <option value="">Semua</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary !py-2">Filter</button>
                        @if(request()->hasAny(['search', 'start_date', 'end_date', 'status']))
                            <a href="{{ route('purchases.index') }}" class="btn-secondary !py-2">Reset</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th>No Invoice</th>
                            <th>Supplier</th>
                            <th>Tanggal</th>
                            <th class="text-right">Total</th>
                            <th>User</th>
                            <th class="text-center w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $purchase)
                            <tr>
                                <td class="font-semibold text-emerald-600">{{ $purchase->invoice_number }}</td>
                                <td class="text-slate-600">{{ $purchase->supplier->name ?? '-' }}</td>
                                <td class="text-slate-500">{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                                <td class="text-right font-semibold text-slate-700">Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                <td class="text-slate-500">{{ $purchase->user->name ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('purchases.show', $purchase) }}"
                                       class="btn-icon-sm bg-emerald-50 text-emerald-600 hover:bg-emerald-100" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-12"><svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg><p class="text-sm text-slate-400">Belum ada data pembelian</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($purchases->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $purchases->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
