<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Satuan</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Kelola satuan obat</p>
            <a href="{{ route('units.create') }}" class="btn-primary">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Satuan
            </a>
        </div>
        <div class="card">
            <div class="overflow-x-auto">
                <table class="pro-table">
                    <thead>
                        <tr>
                            <th class="w-16">No</th>
                            <th>Nama</th>
                            <th>Singkatan</th>
                            <th class="text-center">Jumlah Obat</th>
                            <th class="text-center w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($units as $unit)
                            <tr>
                                <td class="text-slate-400 font-medium">{{ $loop->iteration + ($units->currentPage() - 1) * $units->perPage() }}</td>
                                <td class="font-semibold text-slate-700">{{ $unit->name }}</td>
                                <td><span class="badge badge-info">{{ $unit->abbreviation }}</span></td>
                                <td class="text-center">
                                    <span class="text-slate-600 font-medium">{{ $unit->medicines_count ?? $unit->medicines->count() }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('units.edit', $unit) }}"
                                           class="btn-icon-sm bg-amber-50 text-amber-600 hover:bg-amber-100" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <form action="{{ route('units.destroy', $unit) }}" method="POST" class="delete-form">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-icon-sm bg-red-50 text-red-600 hover:bg-red-100" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center py-12"><svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg><p class="text-sm text-slate-400">Belum ada data satuan</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($units->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">{{ $units->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
