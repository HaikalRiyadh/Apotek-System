<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Daftar Obat</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Kelola data obat di apotek Anda</p>
            <a href="{{ route('medicines.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Obat
            </a>
        </div>
        <!-- Search & Filter -->
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('medicines.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="search" class="block text-sm font-semibold text-slate-700 mb-1.5">Cari Obat</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input id="search" name="search" type="text"
                                   class="block w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all"
                                   placeholder="Kode atau nama obat..." value="{{ request('search') }}" />
                        </div>
                    </div>
                    <div class="w-48">
                        <label for="category_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori</label>
                        <select id="category_id" name="category_id"
                                class="block w-full py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Cari
                        </button>
                        @if(request()->hasAny(['search', 'category_id']))
                        <a href="{{ route('medicines.index') }}" class="btn-secondary">Reset</a>
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
                            <th>Kode</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Harga Jual</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medicines as $medicine)
                            <tr>
                                <td>
                                    <span class="font-mono text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-md">{{ $medicine->code }}</span>
                                </td>
                                <td class="font-semibold text-slate-700">{{ $medicine->name }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $medicine->category->name ?? '-' }}</span>
                                </td>
                                <td class="text-slate-500">{{ $medicine->unit->name ?? '-' }}</td>
                                <td class="text-right text-slate-600 font-medium">Rp {{ number_format($medicine->default_purchase_price, 0, ',', '.') }}</td>
                                <td class="text-right text-slate-600 font-medium">Rp {{ number_format($medicine->selling_price, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($medicine->stock <= $medicine->minimum_stock)
                                        <span class="badge badge-danger font-bold">{{ $medicine->stock }}</span>
                                    @else
                                        <span class="badge badge-success font-bold">{{ $medicine->stock }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('medicines.show', $medicine) }}"
                                           class="btn-icon-sm bg-blue-50 text-blue-600 hover:bg-blue-100" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('medicines.edit', $medicine) }}"
                                           class="btn-icon-sm bg-amber-50 text-amber-600 hover:bg-amber-100" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        @can('delete medicines')
                                            <form action="{{ route('medicines.destroy', $medicine) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-icon-sm bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-sm text-slate-400">Tidak ada data obat</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($medicines->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $medicines->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
