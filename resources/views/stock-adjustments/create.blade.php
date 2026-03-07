<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('stock-adjustments.index') }}" class="btn-icon-sm bg-white text-slate-500 hover:bg-slate-50 border border-slate-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <h2 class="text-xl font-bold text-slate-800">Penyesuaian Stok</h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6 animate-fade-in">
            <div class="card" x-data="stockAdjustment()">
                <div class="card-header">
                    <h3 class="font-bold text-slate-800">Form Penyesuaian</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('stock-adjustments.store') }}" class="space-y-5">
                        @csrf

                        <!-- Medicine -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Obat <span class="text-red-500">*</span></label>
                            <select x-model="medicineId" @change="fetchBatches()"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Obat --</option>
                                @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" {{ $selectedBatch && $selectedBatch->medicine_id == $medicine->id ? 'selected' : '' }}>
                                        {{ $medicine->name }} (Stok: {{ $medicine->stock_total }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Batch -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Batch <span class="text-red-500">*</span></label>
                            <template x-if="loading">
                                <div class="flex items-center gap-2 text-sm text-slate-400 py-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    Memuat batch...
                                </div>
                            </template>
                            <select x-show="!loading" name="medicine_batch_id" x-model="batchId" @change="selectBatch()"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20"
                                    :required="true">
                                <option value="">-- Pilih Batch --</option>
                                <template x-for="batch in batches" :key="batch.id">
                                    <option :value="batch.id"
                                            :class="batch.is_expired ? 'text-red-600' : ''"
                                            x-text="batch.batch_number + ' | Exp: ' + batch.expired_date_formatted + ' | Sisa: ' + batch.remaining_quantity + (batch.is_expired ? ' ⚠️ EXPIRED' : '')">
                                    </option>
                                </template>
                            </select>
                            @error('medicine_batch_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Batch Info -->
                        <div x-show="selectedBatch" x-transition
                             class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-slate-400">Batch No.</span>
                                    <p class="font-bold text-slate-700" x-text="selectedBatch?.batch_number"></p>
                                </div>
                                <div>
                                    <span class="text-slate-400">Tanggal Expired</span>
                                    <p class="font-bold" :class="selectedBatch?.is_expired ? 'text-red-600' : 'text-slate-700'" x-text="selectedBatch?.expired_date_formatted"></p>
                                </div>
                                <div>
                                    <span class="text-slate-400">Sisa Stok</span>
                                    <p class="font-bold text-slate-700" x-text="selectedBatch?.remaining_quantity"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Tipe Penyesuaian <span class="text-red-500">*</span></label>
                            <select name="type" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="dispose" {{ old('type') == 'dispose' ? 'selected' : '' }}>🗑️ Buang / Expired</option>
                                <option value="correction" {{ old('type') == 'correction' ? 'selected' : '' }}>📝 Koreksi Stok</option>
                                <option value="return" {{ old('type') == 'return' ? 'selected' : '' }}>↩️ Retur ke Supplier</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>📦 Lainnya</option>
                            </select>
                            @error('type')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Jumlah Dikurangi <span class="text-red-500">*</span></label>
                            <input type="number" name="quantity_adjusted" value="{{ old('quantity_adjusted') }}"
                                   min="1" :max="selectedBatch?.remaining_quantity || 99999" required
                                   placeholder="Masukkan jumlah yang akan dikurangi"
                                   class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">
                            @error('quantity_adjusted')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reason -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-600 mb-1">Alasan <span class="text-red-500">*</span></label>
                            <textarea name="reason" rows="3" required
                                      placeholder="Contoh: Obat sudah melewati tanggal kadaluarsa"
                                      class="w-full bg-slate-50 border border-slate-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500/20">{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-end gap-3 pt-2">
                            <a href="{{ route('stock-adjustments.index') }}" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Simpan Penyesuaian
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @push('scripts')
    <script>
        function stockAdjustment() {
            return {
                medicineId: '{{ $selectedBatch ? $selectedBatch->medicine_id : '' }}',
                batchId: '{{ $selectedBatch ? $selectedBatch->id : '' }}',
                batches: [],
                selectedBatch: null,
                loading: false,

                init() {
                    if (this.medicineId) {
                        this.fetchBatches();
                    }
                },

                async fetchBatches() {
                    if (!this.medicineId) {
                        this.batches = [];
                        this.selectedBatch = null;
                        return;
                    }
                    this.loading = true;
                    try {
                        const res = await fetch(`/stock-adjustments/batches/${this.medicineId}`);
                        const data = await res.json();
                        const today = new Date().toISOString().split('T')[0];
                        this.batches = data.map(b => ({
                            ...b,
                            expired_date_formatted: new Date(b.expired_date).toLocaleDateString('id-ID'),
                            is_expired: b.expired_date <= today,
                        }));
                        if (this.batchId) {
                            this.selectBatch();
                        }
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.loading = false;
                    }
                },

                selectBatch() {
                    this.selectedBatch = this.batches.find(b => b.id == this.batchId) || null;
                },
            };
        }
    </script>
    @endpush
</x-app-layout>
