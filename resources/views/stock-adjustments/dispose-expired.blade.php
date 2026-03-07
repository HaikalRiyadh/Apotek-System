<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('stock-adjustments.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Buang Obat Expired</h2>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-6 animate-fade-in">
            @if($expiredBatches->isEmpty())
                <div class="card">
                    <div class="card-body py-16 text-center">
                        <svg class="w-20 h-20 mx-auto mb-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <h3 class="text-lg font-bold text-slate-700 mb-1">Tidak Ada Obat Expired</h3>
                        <p class="text-slate-400">Semua batch obat masih dalam masa berlaku. Bagus!</p>
                        <a href="{{ route('stock-adjustments.index') }}" class="btn-primary mt-4 inline-flex">Kembali</a>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('stock-adjustments.dispose-expired.store') }}" x-data="{ selectedAll: false, selected: [] }">
                    @csrf

                    <!-- Summary -->
                    <div class="bg-gradient-to-r from-red-500 to-rose-600 rounded-2xl p-6 text-white mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold">{{ $expiredBatches->count() }} Batch Expired</h3>
                                <p class="text-red-100 text-sm">Total {{ $expiredBatches->sum('remaining_quantity') }} unit obat yang sudah melewati tanggal kadaluarsa</p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header flex items-center justify-between">
                            <h3 class="font-bold text-slate-800">Pilih Batch untuk Dibuang</h3>
                            <label class="flex items-center gap-2 cursor-pointer text-sm text-slate-600">
                                <input type="checkbox" x-model="selectedAll"
                                       @change="selected = selectedAll ? {{ $expiredBatches->pluck('id') }} : []"
                                       class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                Pilih Semua
                            </label>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="pro-table">
                                <thead>
                                    <tr>
                                        <th class="w-10"></th>
                                        <th>Obat</th>
                                        <th>Batch No.</th>
                                        <th>Tanggal Expired</th>
                                        <th class="text-center">Sisa Stok</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiredBatches as $batch)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="batch_ids[]" value="{{ $batch->id }}"
                                                       x-model="selected" :value="{{ $batch->id }}"
                                                       class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500/20">
                                            </td>
                                            <td class="font-medium">{{ $batch->medicine->name }}</td>
                                            <td><span class="badge badge-info">{{ $batch->batch_number }}</span></td>
                                            <td class="text-red-600 font-medium">{{ $batch->expired_date->format('d/m/Y') }}</td>
                                            <td class="text-center font-bold">{{ $batch->remaining_quantity }}</td>
                                            <td>
                                                @php $daysExpired = now()->diffInDays($batch->expired_date); @endphp
                                                <span class="badge badge-danger">Expired {{ $daysExpired }} hari</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Reason & Submit -->
                    <div class="card mt-6">
                        <div class="card-body">
                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-600 mb-1">Alasan (opsional)</label>
                                <input type="text" name="reason" value="Pembuangan obat expired" placeholder="Alasan pembuangan..."
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            </div>
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('stock-adjustments.index') }}" class="btn-secondary">Batal</a>
                                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white text-xs font-semibold rounded-xl uppercase tracking-widest hover:bg-red-700 transition"
                                        :disabled="selected.length === 0"
                                        :class="selected.length === 0 ? 'opacity-50 cursor-not-allowed' : ''">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Buang <span x-text="selected.length" class="mx-1"></span> Batch Terpilih
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
</x-app-layout>
