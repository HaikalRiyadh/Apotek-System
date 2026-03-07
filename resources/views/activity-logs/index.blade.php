<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Activity Log</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari Deskripsi</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                        <select name="user_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Semua User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-36">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Aksi</label>
                        <select name="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Semua</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Tambah</option>
                            <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Ubah</option>
                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>Hapus</option>
                        </select>
                    </div>
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                        <select name="model_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="w-40">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'user_id', 'action', 'model_type', 'start_date', 'end_date']))
                            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Log Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $log->user->name ?? 'System' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $log->action === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ $log->action_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">{{ $log->model_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-md truncate">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm" x-data="{ showDetail: false }">
                                        @if($log->old_values || $log->new_values)
                                            <button @click="showDetail = !showDetail" class="text-indigo-600 hover:text-indigo-800 text-xs">
                                                <span x-show="!showDetail">Lihat</span>
                                                <span x-show="showDetail">Tutup</span>
                                            </button>

                                            <div x-show="showDetail" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" @click.self="showDetail = false">
                                                <div class="bg-white rounded-lg shadow-xl p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                                                    <div class="flex justify-between items-center mb-4">
                                                        <h3 class="text-lg font-semibold">Detail Perubahan</h3>
                                                        <button @click="showDetail = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                                                    </div>

                                                    @if($log->action === 'updated')
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <h4 class="text-sm font-semibold text-red-600 mb-2">Nilai Lama</h4>
                                                                @if($log->old_values)
                                                                    @foreach($log->old_values as $key => $value)
                                                                        <div class="text-xs mb-1">
                                                                            <span class="font-medium text-gray-600">{{ $key }}:</span>
                                                                            <span class="text-red-700 bg-red-50 px-1 rounded">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <h4 class="text-sm font-semibold text-green-600 mb-2">Nilai Baru</h4>
                                                                @if($log->new_values)
                                                                    @foreach($log->new_values as $key => $value)
                                                                        <div class="text-xs mb-1">
                                                                            <span class="font-medium text-gray-600">{{ $key }}:</span>
                                                                            <span class="text-green-700 bg-green-50 px-1 rounded">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @elseif($log->action === 'created' && $log->new_values)
                                                        <h4 class="text-sm font-semibold text-green-600 mb-2">Data Baru</h4>
                                                        @foreach($log->new_values as $key => $value)
                                                            <div class="text-xs mb-1">
                                                                <span class="font-medium text-gray-600">{{ $key }}:</span>
                                                                <span>{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                            </div>
                                                        @endforeach
                                                    @elseif($log->action === 'deleted' && $log->old_values)
                                                        <h4 class="text-sm font-semibold text-red-600 mb-2">Data Yang Dihapus</h4>
                                                        @foreach($log->old_values as $key => $value)
                                                            <div class="text-xs mb-1">
                                                                <span class="font-medium text-gray-600">{{ $key }}:</span>
                                                                <span class="text-red-700">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        <div class="text-4xl mb-2">📝</div>
                                        Belum ada aktivitas tercatat.
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
    </div>
</x-app-layout>
