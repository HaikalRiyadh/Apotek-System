<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-slate-800">Activity Log</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6 animate-fade-in">
        <p class="text-sm text-slate-500 -mt-1">Riwayat seluruh aktivitas dalam sistem</p>
            <!-- Filter -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-48">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Cari Deskripsi</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..."
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">User</label>
                            <select name="user_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-36">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Aksi</label>
                            <select name="action" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">Semua</option>
                                <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Tambah</option>
                                <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Ubah</option>
                                <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Hapus</option>
                            </select>
                        </div>
                        <div class="w-40">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Model</label>
                            <select name="model_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">Semua</option>
                                <option value="Medicine" {{ request('model_type') == 'Medicine' ? 'selected' : '' }}>Obat</option>
                                <option value="Category" {{ request('model_type') == 'Category' ? 'selected' : '' }}>Kategori</option>
                                <option value="Unit" {{ request('model_type') == 'Unit' ? 'selected' : '' }}>Satuan</option>
                                <option value="Supplier" {{ request('model_type') == 'Supplier' ? 'selected' : '' }}>Supplier</option>
                                <option value="Purchase" {{ request('model_type') == 'Purchase' ? 'selected' : '' }}>Pembelian</option>
                                <option value="Sale" {{ request('model_type') == 'Sale' ? 'selected' : '' }}>Penjualan</option>
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
                            @if(request()->hasAny(['search', 'user_id', 'action', 'model_type', 'start_date', 'end_date']))
                                <a href="{{ route('activity-logs.index') }}" class="btn-secondary">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Log Table -->
            <div class="card">
                <div class="overflow-x-auto">
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Model</th>
                                <th>Deskripsi</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr>
                                    <td class="whitespace-nowrap text-xs text-slate-400">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="font-medium">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td>
                                        <span class="badge
                                            {{ $log->action === 'created' ? 'badge-success' : '' }}
                                            {{ $log->action === 'updated' ? 'badge-info' : '' }}
                                            {{ $log->action === 'deleted' ? 'badge-danger' : '' }}">
                                            {{ $log->action_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-warning">{{ $log->model_name }}</span>
                                    </td>
                                    <td class="max-w-md truncate">
                                        {{ $log->description }}
                                    </td>
                                    <td class="whitespace-nowrap" x-data="{ showDetail: false }">
                                        @if($log->old_values || $log->new_values)
                                            <button @click="showDetail = !showDetail" class="text-emerald-600 hover:text-emerald-800 text-xs font-semibold">
                                                <span x-show="!showDetail">Lihat</span>
                                                <span x-show="showDetail">Tutup</span>
                                            </button>

                                            <div x-show="showDetail" x-transition class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50" @click.self="showDetail = false">
                                                <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-bold text-slate-800">Detail Perubahan</h3>
                                                        <button @click="showDetail = false" class="btn-icon-sm bg-slate-100 text-slate-500 hover:bg-slate-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                        </button>
                                                    </div>

                                                    @if($log->action === 'updated')
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div class="bg-red-50/50 rounded-xl p-3">
                                                                <h4 class="text-sm font-bold text-red-600 mb-2 flex items-center gap-1">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                    Nilai Lama
                                                                </h4>
                                                                @if($log->old_values)
                                                                    @foreach($log->old_values as $key => $value)
                                                                        <div class="text-xs mb-1.5">
                                                                            <span class="font-semibold text-slate-500">{{ $key }}:</span>
                                                                            <span class="text-red-700 bg-red-100 px-1.5 py-0.5 rounded-md">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div class="bg-emerald-50/50 rounded-xl p-3">
                                                                <h4 class="text-sm font-bold text-emerald-600 mb-2 flex items-center gap-1">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                    Nilai Baru
                                                                </h4>
                                                                @if($log->new_values)
                                                                    @foreach($log->new_values as $key => $value)
                                                                        <div class="text-xs mb-1.5">
                                                                            <span class="font-semibold text-slate-500">{{ $key }}:</span>
                                                                            <span class="text-emerald-700 bg-emerald-100 px-1.5 py-0.5 rounded-md">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($log->action === 'created' && $log->new_values)
                                                        <div class="bg-emerald-50/50 rounded-xl p-3">
                                                            <h4 class="text-sm font-bold text-emerald-600 mb-2">Data Baru</h4>
                                                            @foreach($log->new_values as $key => $value)
                                                                <div class="text-xs mb-1.5">
                                                                    <span class="font-semibold text-slate-500">{{ $key }}:</span>
                                                                    <span class="text-slate-700">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @elseif($log->action === 'deleted' && $log->old_values)
                                                        <div class="bg-red-50/50 rounded-xl p-3">
                                                            <h4 class="text-sm font-bold text-red-600 mb-2">Data Yang Dihapus</h4>
                                                            @foreach($log->old_values as $key => $value)
                                                                <div class="text-xs mb-1.5">
                                                                    <span class="font-semibold text-slate-500">{{ $key }}:</span>
                                                                    <span class="text-red-700">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-slate-300 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-slate-400">Belum ada aktivitas tercatat.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4">
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
</x-app-layout>
