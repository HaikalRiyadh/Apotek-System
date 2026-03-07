<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Penyesuaian Stok</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Riwayat perubahan stok obat (buang expired, koreksi, retur)</p>
            <div class="flex gap-2">
                <a href="{{ route('stock-adjustments.dispose-expired') }}" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Buang Obat Expired
                </a>
                <a href="{{ route('stock-adjustments.create') }}" class="btn-primary">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Penyesuaian Baru
                </a>
            </div>
        </div>
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 text-sm text-emerald-700 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('stock-adjustments.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-48">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Cari Obat</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama obat..."
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="w-44">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tipe</label>
                            <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">Semua</option>
                                <option value="dispose" {{ request('type') == 'dispose' ? 'selected' : '' }}>Buang/Expired</option>
                                <option value="correction" {{ request('type') == 'correction' ? 'selected' : '' }}>Koreksi Stok</option>
                                <option value="return" {{ request('type') == 'return' ? 'selected' : '' }}>Retur Supplier</option>
                                <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="btn-primary">Filter</button>
                            @if(request()->hasAny(['search', 'type', 'start_date', 'end_date']))
                                <a href="{{ route('stock-adjustments.index') }}" class="btn-secondary">Reset</a>
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
                                <th>Waktu</th>
                                <th>Obat</th>
                                <th>Batch</th>
                                <th>Tipe</th>
                                <th class="text-center">Sebelum</th>
                                <th class="text-center">Dikurangi</th>
                                <th class="text-center">Sesudah</th>
                                <th>Alasan</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($adjustments as $adj)
                                <tr>
                                    <td class="whitespace-nowrap text-xs text-slate-400">
                                        {{ $adj->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="font-medium">{{ $adj->medicine->name }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $adj->medicineBatch->batch_number }}</span>
                                        <div class="text-xs text-slate-400 mt-0.5">Exp: {{ $adj->medicineBatch->expired_date->format('d/m/Y') }}</div>
                                    </td>
                                    <td>
                                        @switch($adj->type)
                                            @case('dispose')
                                                <span class="badge badge-danger">{{ $adj->type_label }}</span>
                                                @break
                                            @case('correction')
                                                <span class="badge badge-info">{{ $adj->type_label }}</span>
                                                @break
                                            @case('return')
                                                <span class="badge badge-warning">{{ $adj->type_label }}</span>
                                                @break
                                            @default
                                                <span class="badge">{{ $adj->type_label }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center font-medium">{{ $adj->quantity_before }}</td>
                                    <td class="text-center text-red-600 font-bold">-{{ $adj->quantity_adjusted }}</td>
                                    <td class="text-center font-medium">{{ $adj->quantity_after }}</td>
                                    <td class="max-w-xs truncate text-sm">{{ $adj->reason }}</td>
                                    <td class="text-sm">{{ $adj->user->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        <p class="text-slate-400">Belum ada riwayat penyesuaian stok.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($adjustments->hasPages())
                    <div class="p-4 border-t border-slate-100">
                        {{ $adjustments->links() }}
                    </div>
                @endif
            </div>
        </div>
</x-app-layout>
